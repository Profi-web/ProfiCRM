<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: /404');
}
/**/

$company = new Company($id);


$loginValidate = new validateLogin();
$loginValidate->securityCheck();
//
?>
<div class="card-header border-0 bg-light-second rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <div>Contactgegevens</div>
        <a class="btn btn-info rounded text-white btn-sm trigger_contact"
           id="<?php echo $company->getData('id'); ?>">Bewerken</a>
    </div>
</div>
<div class="container-fluid p-4 rounded-bottom rounded-top">
    <div style="cursor:default" class="modal fade" id="statusmodel" tabindex="-1"
         role="dialog" aria-labelledby="Modal status #<?php echo $company->getData('id'); ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bedrijf #<?php echo $company->getData('id'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert_field_<?php echo $company->getData('id'); ?>">
                    </div>
                    <div class="list-group" id="statusList">
                        <div data-uid="<?php echo $company->getData('id'); ?>" data-status="1"
                             class="list-group-item list-group-item-action <?php if ($company->getData('status') == 1) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>Normaal</div>
                                <div><i class="fad fa-check-circle"></i></div>
                            </div>
                        </div>
                        <div data-uid="<?php echo $company->getData('id'); ?>" data-status="2"
                             class="list-group-item list-group-item-action <?php if ($company->getData('status') == 2) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>Suspended</div>
                                <div><i class="fad fa-exclamation-circle text-red"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded text-white" data-dismiss="modal">Sluiten
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 ">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i
                            class="fad fa-sign"></i> <?php echo $company->getData('name'); ?>
                </li>
                <li class="list-group-item">
                    <div class="row justify-content-between pl-3">
                        <div>
                            <i class="fad fa-phone-office"></i> <?php echo $company->getData('phonenumber'); ?>
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=31<?php echo $company->getData('phonenumber'); ?>&lang=nl"
                           target="_blank">
                            <i class="fab fa-whatsapp list-group-item p-0 pt-1 text-green font-size-20"></i></a>
                    </div>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-at"></i> <?php echo $company->getData('email'); ?>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-road"></i> <?php echo $company->getData('address'); ?>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-map"></i> <?php echo $company->getData('zipcode'); ?>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-city"></i> <?php echo $company->getData('city') ?>
                </li>
                <li class="list-group-item"><i
                        class="fad fa-university"></i> <?php echo $company->getData('kvk') ? $company->getData('kvk') : '-';  ?>
                </li>
                <li class="list-group-item"><i
                        class="fad fa-money-check"></i> <?php echo $company->getData('iban') ? $company->getData('kvk') : '-'; ?>
                </li>
                <li class="list-group-item">
                    <span class="py-1"
                          data-toggle="modal"
                          data-target="#statusmodel"><?php echo $company->getStatus($company->getData('status')); ?></span>
                </li>
            </ul>

        </div>
    </div>
</div>
<script>
    $('#statusList .list-group-item').on('click', function () {
        var statusId = $(this).data('uid');
        var statusStatus = $(this).data('status');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/company/company_contact_save_status.php?id=' + statusId + '&status=' + statusStatus, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('#company_contact').load('/controllers/tables/company/company_contact_single.php?id=<?php echo $company->getData('id'); ?>', function () {
                    });

                } else {
                    $(".alert_field_" + statusId).load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

    });


    $('.trigger_contact').on('click', function () {
        $('#company_contact').load('/controllers/tables/company/company_contact.php?id=<?php echo $id; ?>', function () {
        });
    });
</script>

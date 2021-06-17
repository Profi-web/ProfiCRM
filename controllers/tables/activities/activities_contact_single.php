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

$activity = new Activity($id);


$employee = new User($activity->getDataNormal('user'));
if ($activity->getDataNormal('lastUser') && !empty($activity->getDataNormal('lastUser'))) {
    $lastUser = new User($activity->getDataNormal('lastUser'));
    $lastUser = $lastUser->data['name'];
} else {
    $lastUser = '-';
}
if ($activity->getDataNormal('sentUser') && !empty($activity->getDataNormal('sentUser'))) {
    $sentUser = new User($activity->getDataNormal('sentUser'));
    $sentUser = $sentUser->data['name'];
} else {
    $sentUser = '-';
}

$loginValidate = new validateLogin();
$loginValidate->securityCheck();
//
?>
<div class="card-header border-0 bg-light-second rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <div>Contactgegevens</div>
        <a class="btn btn-info rounded text-white btn-sm trigger_contact"
           id="<?php echo $activity->getData('id'); ?>">Bewerken</a>
    </div>
</div>
<div class="container-fluid p-4 rounded-bottom rounded-top">
    <div style="cursor:default" class="modal fade"
         id="facturering" tabindex="-1"
         role="dialog" aria-labelledby="Modal Facturering #<?php echo $activity->getData('id'); ?>"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Taak
                        #<?php echo $activity->getData('id'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert_field_<?php echo $activity->getData('id'); ?>">
                    </div>
                    <div class="list-group" id="factureringList">
                        <div data-uid="<?php echo $activity->getData('id'); ?>" data-facturering="1"
                             class="list-group-item list-group-item-action <?php if ($activity->getData('facturering') == 1) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>Nee</div>
                                <div><i class="fad fa-print"></i></div>
                            </div>
                        </div>
                        <div data-uid="<?php echo $activity->getData('id'); ?>" data-facturering="2"
                             class="list-group-item list-group-item-action <?php if ($activity->getData('facturering') == 2) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>Ja</div>
                                <div><i class="fad fa-print text-green"></i></div>
                            </div>
                        </div>
                        <div data-uid="<?php echo $activity->getData('id'); ?>" data-facturering="3"
                             class="list-group-item list-group-item-action <?php if ($activity->getData('facturering') == 3) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>Service / Garantie</div>
                                <div><i class="fad fa-shield-alt text-cyan"></i></div>
                            </div>
                        </div>
                        <div data-uid="<?php echo $activity->getData('id'); ?>" data-facturering="4"
                             class="list-group-item list-group-item-action <?php if ($activity->getData('facturering') == 4) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>Eigen gebruik</div>
                                <div><i class="fad fa-badge text-warning"></i></div>
                            </div>
                        </div>
                        <div data-uid="<?php echo $activity->getData('id'); ?>" data-facturering="5"
                             class="list-group-item list-group-item-action <?php if ($activity->getData('facturering') == 5) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>Contract</div>
                                <div><i class="fad fa-file-contract text-primary"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded text-white" data-dismiss="modal">
                        Sluiten
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div style="cursor:default" class="modal fade" id="statusmodel" tabindex="-1"
         role="dialog" aria-labelledby="Modal status #<?php echo $activity->getData('id'); ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Taak #<?php echo $activity->getData('id'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert_field_<?php echo $activity->getData('id'); ?>">
                    </div>
                    <div class="list-group" id="statusList">
                        <div data-uid="<?php echo $activity->getData('id'); ?>" data-status="1"
                             class="list-group-item list-group-item-action <?php if ($activity->getData('status') == 1) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>Open</div>
                                <div><i class="fad fa-clock"></i></div>
                            </div>
                        </div>
                        <div data-uid="<?php echo $activity->getData('id'); ?>" data-status="2"
                             class="list-group-item list-group-item-action <?php if ($activity->getData('status') == 2) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>Uitgevoerd</div>
                                <div><i class="fad fa-check-double text-green"></i></div>
                            </div>
                        </div>
                        <div data-uid="<?php echo $activity->getData('id'); ?>" data-status="3"
                             class="list-group-item list-group-item-action <?php if ($activity->getData('status') == 3) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>In behandeling</div>
                                <div><i class="fad fa-pause-circle text-indianred"></i></div>
                            </div>
                        </div>
                        <div data-uid="<?php echo $activity->getData('id'); ?>" data-status="4"
                             class="list-group-item list-group-item-action <?php if ($activity->getData('status') == 4) {
                                 echo 'active';
                             } ?>">
                            <div class="row justify-content-between px-3">
                                <div>Wachten op klant</div>
                                <div><i class="fad fa-dolly text-warning"></i></div>
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
                <li class="list-group-item">
                    <i class="fad fa-user-tie"></i> <?php echo $employee->data['name'] ?>
                </li>

                <li class="list-group-item clickRelation">
                    <?php echo $activity->getRelation($activity->getData('relation_id'), $activity->getData('relation_type')); ?>
                </li>
                <li class="list-group-item">
                    <span class="py-1"
                          data-toggle="modal"
                          data-target="#statusmodel"><?php echo $activity->getStatus($activity->getData('status')); ?></span>
                </li>
                <li class="list-group-item">


                    <span class="py-1"
                          data-toggle="modal"
                          data-target="#facturering"><?php echo $activity->getGefactureerd($activity->getData('facturering')); ?></span>
                </li>
                <li class="list-group-item"> <span class="iconSpan"><i
                                class="fad fa-calendar-alt"></i></span><?php echo $activity->getData('date'); ?>
                </li>
                <li class="list-group-item">  <span class="iconSpan"><i
                                class="fad fa-business-time "></i></span><?php echo $activity->getData('time_from'); ?>
                </li>
                <li class="list-group-item">  <span class="iconSpan"><i
                                class="fad fa-business-time "></i> </span><?php echo $activity->getData('time_to'); ?>
                </li>
                <li class="list-group-item">
                      <span class="iconSpan"><i
                                  class="fad fa-route "></i> </span><?php if ($activity->getData('traveltime') !== '-') {
                        echo $activity->getData('traveltime') . ' minuten';
                    } else {
                        echo '-';
                    } ?>
                </li>
                <li class="list-group-item">
                    <span class="iconSpan"><i
                                class="fad fa-user-crown text-amber "></i></span><?php echo $sentUser; ?>
                </li>
                <li class="list-group-item">
                    <span class="iconSpan"><i class="fad fa-user-edit text-cyan-1"></i></span><?php echo $lastUser;?>
                </li>
            </ul>

        </div>
    </div>
</div>
<script>
    $('.trigger_contact').on('click', function () {
        $('#activity_contact').load('/controllers/tables/activities/activities_contact.php?id=<?php echo $id; ?>', function () {
        });
    });
    var relation = '<?php echo $activity->getData('relation_type');?>';
    if (relation == '1') {
        var type = 'bedrijf';
    } else if (relation == '2') {
        var type = 'contact';
    } else if (relation == '3') {
        var type = 'leverancier';
    }
    $('.clickRelation').on('click', function () {
        window.location.href = '/' + type + '?id=<?php echo $activity->getData('relation_id');?>';
    });


    $('#factureringList .list-group-item').on('click', function () {
        var factureringsID = $(this).data('uid');
        var facturering = $(this).data('facturering');

        var id = $('.activities_table').attr('id');
        var user = $('.currentuser').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save_facturering.php?id=' + factureringsID + '&facturering=' + facturering, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('#activity_contact').load('/controllers/tables/activities/activities_contact_single.php?id=<?php echo $activity->getData('id') ?>', function () {
                    });

                } else {
                    $(".alert_field_" + factureringsID).load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

    });


    $('#statusList .list-group-item').on('click', function () {
        var statusId = $(this).data('uid');
        var statusStatus = $(this).data('status');

        var id = $('.activities_table').attr('id');
        var user = $('.currentuser').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save_status.php?id=' + statusId + '&status=' + statusStatus, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('#activity_contact').load('/controllers/tables/activities/activities_contact_single.php?id=<?php echo $activity->getData('id') ?>', function () {
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


    $('.change_status').on('click', function (e) {
        var uid = $(this).data('uid');
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save_status.php?id=' + uid, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#activity_contact').load('/controllers/tables/activities/activities_contact_single.php?id=<?php echo $id; ?>', function () {
                    });
                }
            }
        });

    });
</script>
<style>
    .clickRelation:hover {
        cursor: pointer;
        color: grey;
    }

    .change_facturering:hover {
        cursor: pointer;
        color: orange;
        font-weight: bold;
    }

    .change_facturering:hover > .fas {
        color: orange;
        font-weight: bold;
    }

    .change_status:hover {
        cursor: pointer;
        color: orange;
        font-weight: bold;
    }

    .change_status:hover > .fas {
        color: orange;
        font-weight: bold;
    }
</style>

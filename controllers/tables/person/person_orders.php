<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
$paginationOrders = 1;
if (isset($_GET['pageOrders'])) {
    $paginationOrders = $_GET['pageOrders'];
}
/**/
/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: /404');
}
/**/

/*Classes*/
$table = new TableOrdersPerson($paginationOrders, 'orders', 'contact',$id);
$orders = new Orders('', $table->limit);
$loginValidate = new validateLogin();
$loginValidate->securityCheck();
$search = $orders->findAllId($table->startfrom, $table->limit, $id,2);

$person = new Person($id);

?>
<div class="card-header border-0 bg-white rounded-top p-4">
    <div class="row px-4 align-items-center justify-content-between">
        <h5 class="mb-0 ">Bestellingen</h5>
        <a class="btn btn-info rounded text-white" href="/bestellingen/nieuw?relation=<?php echo urlencode($person->getData('name')); ?>">Nieuwe bestelling</a>

    </div>
</div>
<div class="container-fluid  bg-white p-0 rounded-bottom orderTable">
    <div class="row p-0">
        <div class="col-12">
            <div class="w-100"></div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush mb-0 table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Datum</th>
                        <th scope="col">ID</th>
                        <th scope="col">Info</th>
                        <th scope="col">Vkp €</i></th>
                        <th scope="col">Besteld</th>
                        <th scope="col">Gefactureerd</th>
                        <th scope="col">Acties</th>
                    </tr>
                    </thead>
                    <tbody class="order_table" id="<?php echo $table->currentpage; ?>">

                    <?php
                    foreach ($search as $order) {
                        ?>
                        <tr id="<?php echo $order['id'] ?>" class="user_tablee work_table_tr">
                            <td valign="middle" width="10%" class="tr_click">
                                <?php echo $order['date'] ?>
                            </td>
                            <td valign="middle" width="10%" class="tr_click">
                                <?php echo $order['id'] ?>
                            </td>
                            <td valign="middle" width="30%" class="tr_click">
                                <?php echo $orders->getExcerpt($order['text']); ?>
                            </td>
                            <td valign="middle" width="10%" class="tr_click">
                                €<?php echo $order['price'] ?>
                            </td>
                            <td valign="middle" width="12%" class="change_statusOrder"
                                data-uid="<?php echo $order['id'] ?>">
                                <?php echo $orders->getStatus($order['status']) ?>
                            </td>
                            <td valign="middle" width="16%" class=""
                                data-uid="<?php echo $order['id'] ?>">
                                <div class="py-2 w-100"  data-toggle="modal"
                                     data-target="#facturering<?php echo $order['id'] ?>"><?php echo $orders->getFacturering($order['facturering']) ?></div>
                                <div style="cursor:default" class="modal fade" id="facturering<?php echo $order['id'] ?>" tabindex="-1"
                                     role="dialog" aria-labelledby="Modal Factuerering #<?php echo $order['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content rounded">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Taak #<?php echo $order['id'] ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert_field_status_<?php echo $order['id'] ?>">
                                                </div>contact_tasks
                                                <div class="list-group" id="factureringListOrder">
                                                    <div data-uid="<?php echo $order['id'] ?>" data-facturering="1" class="list-group-item list-group-item-action <?php if($order['facturering'] == 1){ echo 'active';}?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Nee</div>
                                                            <div><i class="fad fa-print"></i></div>
                                                        </div>
                                                    </div>
                                                    <div data-uid="<?php echo $order['id'] ?>" data-facturering="2" class="list-group-item list-group-item-action <?php if($order['facturering'] == 2){ echo 'active';}?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Ja</div>
                                                            <div><i class="fad fa-print text-green"></i></div>
                                                        </div>
                                                    </div>
                                                    <div data-uid="<?php echo $order['id'] ?>" data-facturering="3" class="list-group-item list-group-item-action <?php if($order['facturering'] == 3){ echo 'active';}?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Service / Garantie </div>
                                                            <div><i class="fad fa-shield-alt text-cyan"></i></div>
                                                        </div>
                                                    </div>
                                                    <div  data-uid="<?php echo $order['id'] ?>" data-facturering="4" class="list-group-item list-group-item-action <?php if($order['facturering'] == 4){ echo 'active';}?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Eigen gebruik</div>
                                                            <div><i class="fad fa-badge text-warning"></i></div>
                                                        </div>
                                                    </div>
                                                    <div  data-uid="<?php echo $order['id'] ?>" data-facturering="5" class="list-group-item list-group-item-action <?php if($order['facturering'] == 5){ echo 'active';}?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Contract</div>
                                                            <div><i class="fad fa-file-contract text-primary"></i></div>
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
                            </td>
                            <td valign="middle" width="6%" data-uid="<?php echo $order['id'] ?>"  class="text-center">
                                <i class="fad fa-info-circle" data-toggle="modal"
                                   data-target="#modal<?php echo $order['id'] ?>"></i>
                                <div style="cursor:default;" class="modal fade" id="modal<?php echo $order['id'] ?>"
                                     tabindex="-1" role="dialog" aria-labelledby="Modal #<?php echo $order['id'] ?>"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content rounded">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Bestelling
                                                    #<?php echo $order['id'] ?></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="list-group">
                                                    <a href="#" class="list-group-item list-group-item-action ">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h5 class="mb-1 font-weight-bold">Price:</h5>
                                                        </div>
                                                        <p class="mb-1 text-left">€<?php echo $order['price']; ?></p>
                                                    </a>
                                                    <a href="#" class="list-group-item list-group-item-action ">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h5 class="mb-1 font-weight-bold">Informatie:</h5>
                                                        </div>
                                                        <p class="mb-1 text-left"><?php echo nl2br($order['text']); ?></p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info rounded text-white"
                                                        data-dismiss="modal">Sluiten
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <?php
                    }
                    $errors = array_filter($search);
                    if (empty($errors)) {

                        ?>
                        <tr class="user_tablee work_table_tr">
                            <td valign="middle" width="10%" class="">
                                -
                            </td>
                            <td valign="middle" width="10%" class="">
                                -
                            </td>
                            <td valign="middle" width="30%" class="">
                                -
                            </td>
                            <td valign="middle" width="12%" class="">
                                -
                            </td>
                            <td valign="middle" width="12%" class="">
                                -
                            </td>
                            <td valign="middle" width="6%" class="">
                                -
                            </td>
                            <td valign="middle" width="6%" class="">
                                -
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="currentid" id="<?php echo $id; ?>"/>
<div class="card-footer py-4 bg-white rounded-bottom">
    <nav aria-label="...">
        <ul class="pagination justify-content-center justify-content-md-end mb-0">

            <?php
            $table->showPaginationId($id);
            ?>

        </ul>
    </nav>
</div>
<script>

    $('#factureringListOrder .list-group-item').on('click', function () {
        var factureringsID = $(this).data('uid');
        var facturering = $(this).data('facturering');

        var page = $('.order_table').attr('id');
        var id = $('.currentid').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/orders/orders_contact_save_facturering.php?id=' + factureringsID+'&facturering='+facturering, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering'+factureringsID).modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('#contact_orders').load('/controllers/tables/person/person_orders.php?pageOrders=' + page + '&id=' + id, function () {
                    });
                } else {
                    $(".alert_field_status_"+factureringsID).load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

    });


    $('.change_statusOrder').on('click', function (e) {
        var uid = $(this).data('uid');
        var page = $('.order_table').attr('id');
        var id = $('.currentid').attr('id');
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/orders/orders_contact_save_status.php?id=' + uid, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#contact_orders').load('/controllers/tables/person/person_orders.php?pageOrders=' + page + '&id=' + id, function () {
                    });
                }
            }
        });

    });


    $('.orderTable .tr_click').on('click', function e() {
        window.location.href = '/bestelling?id=' + $(this).parent().attr('id');

    });

</script>
<style>
    .change_facturering:hover {
        cursor: pointer;
        color: orange;
        font-weight: bold;
    }

    .change_facturering:hover > .fas {
        color: orange;
        font-weight: bold;
    }

</style>

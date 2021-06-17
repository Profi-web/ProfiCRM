<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
$pagination = 1;
if (isset($_GET['page'])) {
    $pagination = $_GET['page'];
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
$table = new TableActivities($pagination, 'activities', 'contact',$id);
$activities = new Activities('', $table->limit);

$loginValidate = new validateLogin();
$loginValidate->securityCheck();
$search = $activities->findAllId($table->startfrom, $table->limit, $id,2);

$user = new User();

$person = new Person($id);

?>
<div class="card-header border-0 bg-white rounded-top p-4">
    <div class="row px-4 align-items-center justify-content-between">
        <h5 class="mb-0 ">Taken</h5>
        <a class="btn btn-info rounded text-white" href="/taken/nieuw?relation=<?php echo urlencode($person->getData('name')); ?>&id=<?php echo $user->data['id'];?>">Nieuwe taak</a>

    </div>
</div>
<div class="container-fluid  bg-white p-0 rounded-bottom activityTable">
    <div class="row p-0">
        <div class="col-12">
            <div class="w-100"></div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush mb-0 table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Datum</th>
                        <th scope="col">Medewerker</th>
                        <th scope="col">Info</th>
                        <th scope="col">Status</i></th>
                        <th scope="col">Gefactureerd</th>
                        <th scope="col">Acties</th>
                    </tr>
                    </thead>
                    <tbody class="activities_table" id="<?php echo $table->currentpage; ?>">

                    <?php
                    foreach ($search as $activity) {
                        ?>
                        <tr id="<?php echo $activity['id'] ?>" class="user_tablee work_table_tr">
                            <td valign="middle" width="10%" class="tr_click">
                                <?php echo $activity['date'] ?>
                            </td>
                            <td valign="middle" width="10%" class="tr_click">
                                <?php echo $activities->getUser($activity['user']) ?>
                            </td>
                            <td valign="middle" width="30%" class="tr_click">
                                <?php echo $activities->getExcerpt($activity['text']); ?>
                            </td>
                            <td valign="middle" width="20%" data-uid="<?php echo $activity['id'] ?>">
                                <div class="py-2 w-100" data-toggle="modal"
                                     data-target="#status<?php echo $activity['id'] ?>"><?php echo $activities->getStatus($activity['status']) ?></div>
                                <div style="cursor:default" class="modal fade" id="status<?php echo $activity['id'] ?>"
                                     tabindex="-1"
                                     role="dialog" aria-labelledby="Modal status #<?php echo $activity['id'] ?>"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content rounded">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Taak
                                                    #<?php echo $activity['id'] ?></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert_field_status_<?php echo $activity['id'] ?>">
                                                </div>
                                                <div class="list-group" id="statusList">
                                                    <div data-uid="<?php echo $activity['id'] ?>" data-status="1"
                                                         class="list-group-item list-group-item-action <?php if ($activity['status'] == 1) {
                                                             echo 'active';
                                                         } ?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Open</div>
                                                            <div><i class="fad fa-clock"></i></div>
                                                        </div>
                                                    </div>
                                                    <div data-uid="<?php echo $activity['id'] ?>" data-status="2"
                                                         class="list-group-item list-group-item-action <?php if ($activity['status'] == 2) {
                                                             echo 'active';
                                                         } ?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Uitgevoerd</div>
                                                            <div><i class="fad fa-check-double text-green"></i></div>
                                                        </div>
                                                    </div>
                                                    <div data-uid="<?php echo $activity['id'] ?>" data-status="3"
                                                         class="list-group-item list-group-item-action <?php if ($activity['status'] == 3) {
                                                             echo 'active';
                                                         } ?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>In behandeling</div>
                                                            <div><i class="fad fa-pause-circle text-indianred"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div data-uid="<?php echo $activity['id'] ?>" data-status="4"
                                                         class="list-group-item list-group-item-action <?php if ($activity['status'] == 4) {
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
                                                <button type="button" class="btn btn-info rounded text-white"
                                                        data-dismiss="modal">Sluiten
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td valign="middle" width="16%" class=""
                                data-uid="<?php echo $activity['id'] ?>">
                                <div class="py-2 w-100"  data-toggle="modal"
                                     data-target="#facturering<?php echo $activity['id'] ?>"><?php echo $activities->getFacturering($activity['facturering']) ?></div>
                                <div style="cursor:default" class="modal fade" id="facturering<?php echo $activity['id'] ?>" tabindex="-1"
                                     role="dialog" aria-labelledby="Modal Factuerering #<?php echo $activity['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content rounded">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Taak #<?php echo $activity['id'] ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert_field_fac_<?php echo $activity['id'] ?>">
                                                </div>
                                                <div class="list-group" id="factureringList">
                                                    <div data-uid="<?php echo $activity['id'] ?>" data-facturering="1" class="list-group-item list-group-item-action <?php if($activity['facturering'] == 1){ echo 'active';}?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Nee</div>
                                                            <div><i class="fad fa-print"></i></div>
                                                        </div>
                                                    </div>
                                                    <div data-uid="<?php echo $activity['id'] ?>" data-facturering="2" class="list-group-item list-group-item-action <?php if($activity['facturering'] == 2){ echo 'active';}?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Ja</div>
                                                            <div><i class="fad fa-print text-green"></i></div>
                                                        </div>
                                                    </div>
                                                    <div data-uid="<?php echo $activity['id'] ?>" data-facturering="3" class="list-group-item list-group-item-action <?php if($activity['facturering'] == 3){ echo 'active';}?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Service / Garantie </div>
                                                            <div><i class="fad fa-shield-alt text-cyan"></i></div>
                                                        </div>
                                                    </div>
                                                    <div  data-uid="<?php echo $activity['id'] ?>" data-facturering="4" class="list-group-item list-group-item-action <?php if($activity['facturering'] == 4){ echo 'active';}?>">
                                                        <div class="row justify-content-between px-3">
                                                            <div>Eigen gebruik</div>
                                                            <div><i class="fad fa-badge text-warning"></i></div>
                                                        </div>
                                                    </div>
                                                    <div  data-uid="<?php echo $activity['id'] ?>" data-facturering="5" class="list-group-item list-group-item-action <?php if($activity['facturering'] == 5){ echo 'active';}?>">
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
                            <td valign="middle" width="6%" data-uid="<?php echo $activity['id'] ?>" data-toggle="modal"
                                data-target="#modal<?php echo $activity['id'] ?>" class="text-center">
                                <i class="fad fa-info-circle"></i>
                                <div style="cursor:default;" class="modal fade" id="modal<?php echo $activity['id'] ?>"
                                     tabindex="-1" role="dialog" aria-labelledby="Modal #<?php echo $activity['id'] ?>"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content rounded">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Taak
                                                    #<?php echo $activity['id'] ?></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="list-group">
                                                    <?php
                                                    if ($activity['time_from'] && $activity['time_to']) {
                                                        $time = $activity['time_from'] . ' tot ' . $activity['time_to'];
                                                    } else {
                                                        $time = '-';
                                                    }

                                                    if ($activity['traveltime']) {
                                                        $traveltime = $activity['traveltime'];
                                                    } else {
                                                        $traveltime = '-';
                                                    }
                                                    ?>
                                                    <a href="#" class="list-group-item list-group-item-action ">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h5 class="mb-1 font-weight-bold">Tijd:</h5>
                                                        </div>
                                                        <p class="mb-1 text-left"><?php echo $time; ?></p>
                                                    </a>
                                                    <a href="#" class="list-group-item list-group-item-action ">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h5 class="mb-1 font-weight-bold">Reistijd:</h5>
                                                        </div>
                                                        <p class="mb-1 text-left"><?php echo $traveltime; ?></p>
                                                    </a>
                                                    <a href="#" class="list-group-item list-group-item-action ">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <h5 class="mb-1 font-weight-bold">Informatie:</h5>
                                                        </div>
                                                        <p class="mb-1 text-left"><?php echo nl2br($activity['text']); ?></p>
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
    $('#factureringList .list-group-item').on('click', function () {
        var factureringsID = $(this).data('uid');
        var facturering = $(this).data('facturering');

        var page = $('.activities_table').attr('id');
        var id = $('.currentid').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save_facturering.php?id=' + factureringsID+'&facturering='+facturering, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering'+factureringsID).modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();

                    $('#contact_tasks').load('/controllers/tables/person/person_activities.php?page=' + page + '&id=' + id, function () {
                    });
                } else {
                    $(".alert_field_fac_"+factureringsID).load("/controllers/error.php", {
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
        var statusID = $(this).data('uid');
        var statusStatus = $(this).data('status');


        var page = $('.activities_table').attr('id');
        var id = $('.currentid').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save_status.php?id=' + statusID + '&status=' + statusStatus, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering' + statusID).modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();


                    var url = new URL(window.location.href);
                    if (url.searchParams.get('gefactureerd')) {
                        var gefactureerd = url.searchParams.get('gefactureerd');
                        if (gefactureerd === "asc" || gefactureerd === "desc") {
                            var gefactureerdsearch = '&gefactureerd=' + gefactureerd;
                        }
                    } else {
                        var gefactureerdsearch = '';
                    }

                    if (url.searchParams.get('status')) {
                        var status = url.searchParams.get('status');
                        if (status === "asc" || status === "desc") {
                            var statussearch = '&status=' + status;
                        }
                    } else {
                        var statussearch = '';
                    }

                    if (url.searchParams.get('datum')) {
                        var datum = url.searchParams.get('datum');
                        if (datum === "asc" || datum === "desc") {
                            var datumsearch = '&datum=' + datum;
                        }
                    } else {
                        var datumsearch = '';
                    }
                    $('#contact_tasks').load('/controllers/tables/person/person_activities.php?page=' + page + '&id=' + id, function () {
                    });
                } else {
                    $(".alert_field_status_" + statusID).load("/controllers/error.php", {
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
        var page = $('.activities_table').attr('id');
        var id = $('.currentid').attr('id');
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save_status.php?id=' + uid, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#contact_tasks').load('/controllers/tables/person/person_activities.php?page=' + page + '&id=' + id, function () {
                    });
                }
            }
        });

    });


    $('.activityTable .tr_click').on('click', function e() {
        window.location.href = '/taak?id=' + $(this).parent().attr('id');

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

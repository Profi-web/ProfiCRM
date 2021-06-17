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

if (isset($_GET['datum']) && $_GET['datum']) {
    if ($_GET['datum'] === "desc" || $_GET['datum'] === "asc") {
        $datumsort = strtoupper($_GET['datum']);
    } else {
        $datumsort = '';
    }
} else {
    $datumsort = '';
}

/*Classes*/
$table = new Table($pagination, 'nice_to_haves', 'Nice to haves');
$nice_to_haves = new Nice_to_haves('', $table->limit);

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/

/*Variables*/
/**/
foreach ($nice_to_haves->findAll($table->startfrom, $table->limit, $datumsort) as $nice_to_have) {
    ?>
    <tr id="<?php echo $nice_to_have['id'] ?>">
        <td scope="row" class="tr_click">
            <?php echo $nice_to_have['title'] ?> <span
                    class="text-muted op-50"> #<?php echo $nice_to_have['id'] ?></span>
        </td>
        <td class="tr_click">
            <?php echo $nice_to_haves->getExcerpt($nice_to_have['text']); ?>
        </td>
        <td class="tr_click">
            <?php
            if ($nice_to_have['date'] != '0000-00-00') {
                $date = strtotime($nice_to_have['date']);
                $date = date('d-m-Y', $date);

                echo $date;
            } else {
                echo '-';
            } ?>
        </td>
        <td valign="middle" width="20%" data-uid="<?php echo $nice_to_have['id'] ?>">
            <div class="py-2 w-100" data-toggle="modal"
                 data-target="#status<?php echo $nice_to_have['id'] ?>"><?php echo $nice_to_haves->getStatus($nice_to_have['status']) ?></div>
            <div style="cursor:default" class="modal fade" id="status<?php echo $nice_to_have['id'] ?>" tabindex="-1"
                 role="dialog" aria-labelledby="Modal status #<?php echo $nice_to_have['id'] ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nice to have
                                #<?php echo $nice_to_have['id'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert_field_<?php echo $nice_to_have['id'] ?>">
                            </div>
                            <div class="list-group" id="statusList">
                                <div data-uid="<?php echo $nice_to_have['id'] ?>" data-status="1"
                                     class="list-group-item list-group-item-action <?php if ($nice_to_have['status'] == 1) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Open</div>
                                        <div><i class="fad fa-clock"></i></div>
                                    </div>
                                </div>
                                <div data-uid="<?php echo $nice_to_have['id'] ?>" data-status="2"
                                     class="list-group-item list-group-item-action <?php if ($nice_to_have['status'] == 2) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Uitgevoerd</div>
                                        <div><i class="fad fa-check-double text-green"></i></div>
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
        <td valign="middle" width="20%" data-uid="<?php echo $nice_to_have['id'] ?>">
            <div class="py-2 w-100" data-toggle="modal"
                 data-target="#priority<?php echo $nice_to_have['id'] ?>"><?php echo $nice_to_haves->getpriority($nice_to_have['priority']) ?></div>
            <div style="cursor:default" class="modal fade" id="priority<?php echo $nice_to_have['id'] ?>" tabindex="-1"
                 role="dialog" aria-labelledby="Modal priority #<?php echo $nice_to_have['id'] ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nice to have
                                #<?php echo $nice_to_have['id'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert_field_<?php echo $nice_to_have['id'] ?>">
                            </div>
                            <div class="list-group none" id="priorityList">
                                <div data-uid="<?php echo $nice_to_have['id'] ?>" data-priority="1"
                                     class="list-group-item list-group-item-action <?php if ($nice_to_have['priority'] == 1) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Laag</div>
                                        <div><i class="fad fa-flag text-blue"></i></div>
                                    </div>
                                </div>
                                <div data-uid="<?php echo $nice_to_have['id'] ?>" data-priority="2"
                                     class="list-group-item list-group-item-action <?php if ($nice_to_have['priority'] == 2) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Middel</div>
                                        <div><i class="fad fa-flag text-warning"></i></div>
                                    </div>
                                </div>
                                <div data-uid="<?php echo $nice_to_have['id'] ?>" data-priority="3"
                                     class="list-group-item list-group-item-action <?php if ($nice_to_have['priority'] == 3) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Hoog</div>
                                        <div><i class="fad fa-flag text-danger"></i></div>
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
    </tr>
    <?php
}
?>

<script>
    $('tbody .tr_click').on('click', function () {
        window.location.href = '/nice-to-haves/item?id=' + $(this).parent().attr('id');
    });

    $('#statusList .list-group-item').on('click', function () {
        var statusID = $(this).data('uid');
        var statusStatus = $(this).data('status');

        var id = $('.nice_to_haves_table').attr('id');
        var user = $('.currentuser').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/nice_to_have/nice_to_haves_contact_save_status.php?id=' + statusID + '&status=' + statusStatus, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering' + statusID).modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();

                    var url = new URL(window.location.href);

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

                    $('.nice_to_haves_table').load('/controllers/tables/nice_to_have/nice_to_haves.php?page='+id+datumsearch,function () {
                    });
                } else {
                    $(".alert_field_" + statusID).load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

    });

    $('#priorityList .list-group-item').on('click', function () {
        var priorityID = $(this).data('uid');
        var priorityPriority = $(this).data('priority');

        var id = $('.nice_to_haves_table').attr('id');
        var user = $('.currentuser').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/nice_to_have/nice_to_haves_contact_save_priority.php?id=' + priorityID + '&priority=' + priorityPriority, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering' + priorityID).modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();


                    var url = new URL(window.location.href);

                    if (url.searchParams.get('priority')) {
                        var priority = url.searchParams.get('priority');
                        if (priority === "asc" || priority === "desc") {
                            var prioritysearch = '&priority=' + priority;
                        }
                    } else {
                        var prioritysearch = '';
                    }

                    if (url.searchParams.get('datum')) {
                        var datum = url.searchParams.get('datum');
                        if (datum === "asc" || datum === "desc") {
                            var datumsearch = '&datum=' + datum;
                        }
                    } else {
                        var datumsearch = '';
                    }

                    $('.nice_to_haves_table').load('/controllers/tables/nice_to_have/nice_to_haves.php?page='+id+datumsearch,function () {
                    });
                } else {
                    $(".alert_field_" + priorityID).load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

    });
</script>

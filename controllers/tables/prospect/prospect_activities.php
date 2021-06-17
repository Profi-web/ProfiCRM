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
$table = new TableProspectActivities($pagination, 'prospects_activities', 'prospect', $id);
$prospects_activities = new ProspectActivities('', $table->limit);
$usertheme = new User();
$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();
$search = $prospects_activities->findAllId($table->startfrom, $table->limit, $id);

$user = new User();

$prospect = new Prospect($id);

?>
<div class="card-header border-0 bg-white rounded-top p-4">
    <div class="row px-4 align-items-center justify-content-between">
        <h5 class="mb-0 ">Activiteiten</h5>
        <a class="btn btn-info rounded text-white" data-toggle="modal" data-target="#newActivity">Nieuwe activiteit</a>
        <div class="modal fade" id="newActivity" tabindex="-1" role="dialog" aria-labelledby="newActivity"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nieuwe activiteit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert_field_prospect"></div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-0 py-2">
                                <label>Status</label>
                                <div class="input-group">

                                    <select class="custom-select rounded" id="status" name="status">
                                        <option value="1">Open</option>
                                        <option value="2">Gebelt</option>
                                        <option value="3">Terugbellen</option>
                                        <option value="4">Afspraak gemaakt</option>
                                        <option value="5">Niet geïnteresseerd</option>
                                    </select>
                                </div>
                            </li>
                            <li class="list-group-item p-0 py-2">
                                <div class="form-group">
                                    <label for="info">Informatie</label>
                                    <textarea class="form-control rounded info" id="info" rows="3"
                                              name="info"></textarea>
                                </div>
                            </li>
                            <li class="list-group-item p-0 py-2 dateli">
                                <label>Datum</label>
                                <div class="input-group date " id="date" data-target-input="nearest">
                                    <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fad fa-calendar-alt pl-1"></i></div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" data-target="#date"
                                           placeholder="Kies een datum en tijd"/>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-grey rounded" data-dismiss="modal">Sluiten</button>
                        <button type="button" class="btn btn-success text-white rounded" id="saveActivity">Opslaan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid  bg-white p-0 rounded-bottom">
    <?php
    foreach ($search as $key => $activity) {

        ?>
        <div class="modal fade" id="editActivity<?php echo $activity['id'] ?>" tabindex="-1" role="dialog"
             aria-labelledby="newActivity<?php echo $activity['id'] ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bewerk activiteit
                            #<?php echo $activity['id'] ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert_field_prospect"></div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-0 py-2">
                                <label>Status</label>
                                <div class="input-group">

                                    <select class="custom-select rounded" id="statusEdit" name="statusEdit">
                                        <option <?php if ($activity['status'] == '1') {
                                            echo 'selected';
                                        } ?> value="1">Open
                                        </option>
                                        <option <?php if ($activity['status'] == '2') {
                                            echo 'selected';
                                        } ?> value="2">Gebeld
                                        </option>
                                        <option <?php if ($activity['status'] == '3') {
                                            echo 'selected';
                                        } ?> value="3">Terugbellen
                                        </option>
                                        <option <?php if ($activity['status'] == '4') {
                                            echo 'selected';
                                        } ?> value="4">Afspraak gemaakt
                                        </option>
                                        <option <?php if ($activity['status'] == '5') {
                                            echo 'selected';
                                        } ?> value="5">Niet geïnteresseerd
                                        </option>
                                    </select>
                                </div>
                            </li>
                            <li class="list-group-item p-0 py-2">
                                <div class="form-group">
                                    <label for="info">Informatie</label>
                                    <textarea class="form-control rounded info"
                                              id="infoEdit<?php echo $activity['id'] ?>" rows="3"
                                              name="infoEdit"><?php echo $activity['info']; ?></textarea>
                                </div>
                            </li>

                            <li class="list-group-item p-0 py-2 dateli">
                                <label>Datum</label>
                                <div class="input-group date datePicker" id="date<?php echo $key + 1; ?>"
                                     data-target-input="nearest">
                                    <div class="input-group-append"
                                         data-target="#date<?php echo $key + 1; ?>"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text"><i
                                                    class="fad fa-calendar-alt pl-1"></i></div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input"
                                           data-target="#date<?php echo $key + 1; ?>"
                                           placeholder="Kies een datum en tijd"
                                           value="<?php
                                           $date = strtotime($activity['activity_date']);
                                           $date = date('d-m-Y', $date);

                                           echo $date; ?>"/>
                                </div>
                            </li>
                            <input id="idActivity" name="idActivity" type="hidden"
                                   value="<?php echo $activity['id'] ?>"/>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white rounded delete_prospect_activity"
                                id="<?php echo $activity['id'] ?>">Verwijderen
                        </button>
                        <button type="button" class="btn btn-success text-white rounded editActivity">
                            Opslaan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    ?>
    <div class="row p-0">
        <div class="col-12">
            <div class="w-100"></div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush mb-0 table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Bewerk datum</th>
                        <th scope="col">Info</th>
                        <th scope="col">Status</i></th>
                        <th scope="col">Opvolg datum</i></th>
                    </tr>
                    </thead>
                    <tbody class="activities_table" id="<?php echo $table->currentpage; ?>">

                    <?php
                    foreach ($search as $key => $activity) {

                        ?>

                        <tr id="<?php echo $activity['id'] ?>" class="user_tablee work_table_tr" data-toggle="modal"
                            data-target="#editActivity<?php echo $activity['id'] ?>" data-html="true" title="Gemaakt door<b> <?php echo $prospects_activities->getUser($activity['user']); ?></b>">
                                <td valign="middle" width="10%" class="tr_click">
                                    <?php
                                    $date = strtotime($activity['date']);
                                    $date = date('d-m-Y', $date);

                                    echo $date; ?>
                                </td>
                                <td valign="middle" width="30%" class="tr_click">
                                    <?php echo $prospects_activities->getExcerpt($activity['info']); ?>
                                </td>
                                <td valign="middle" width="20%" data-uid="<?php echo $activity['id'] ?>">
                                    <div class="py-2 w-100" data-toggle="modal"
                                         data-target="#status<?php echo $activity['id'] ?>"><?php echo $prospects_activities->getStatus($activity['status']) ?></div>
                                </td>
                                <td valign="middle" width="10%" class="tr_click">
                                    <?php
                                    $date = strtotime($activity['activity_date']);
                                    $date = date('d-m-Y', $date);

                                    echo $date; ?>
                                </td>
                            </div>
                        </tr>
                        <?php
                    }
                    if (is_array($search)) {
                        $errors = array_filter($search);
                    }
                    if (empty($errors)) {

                        ?>
                        <tr class="user_tablee work_table_tr">
                            <td valign="middle" width="10%" class="tr_click">
                                -
                            </td>
                            <td valign="middle" width="10%" class="tr_click">
                                -
                            </td>
                            <td valign="middle" width="30%" class="tr_click">
                                -
                            </td>
                            <td valign="middle" width="30%" class="tr_click">
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
    $(function () {
        $('[data-toggle="modal"]').tooltip()
    })
    alertify.defaults.transition = "fade";
    alertify.defaults.theme.ok = "btn btn-info btn-sm rounded";
    alertify.defaults.theme.cancel = "btn btn-danger btn-sm rounded";
    alertify.defaults.theme.input = "form-control";
    alertify.defaults.glossary.ok = "Oke";
    alertify.defaults.glossary.cancel = "Annuleren";
    $('.delete_prospect_activity').on('click', function () {
        var id = $(this).attr('id');
        alertify.confirm('Verwijderen', "Weet je zeker dat je dit wilt verwijderen?",
            function () {
                $.ajax({ //Process the form using $.ajax()
                    type: 'POST', //Method type
                    url: '/controllers/tables/prospect/prospect_activities_delete.php', //Your form processing file URL
                    data: {'id': id}, //Forms name
                    success: function (data) {
                        data = JSON.parse(data);

                        if (data.status === 'success') {
                            $('#newActivity').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            var page = $('#prospect_tasks').data('page');
                            $('#prospect_tasks').load('/controllers/tables/prospect/prospect_activities.php?id=<?php echo $prospect->getData('id') ?>&page=' + page, function () {
                            });
                        }
                    }
                });
            },
            function () {
            });
    });

    $(function () {
        $('#date').datetimepicker({
            locale: 'nl',
            icons: {
                time: "fad fa-clock",
                date: "fad fa-calendar",
                up: "fad fa-arrow-up",
                down: "fad fa-arrow-down"
            },
            format: 'L',
            useCurrent: true
        });
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = dd + '-' + mm + '-' + yyyy;
        $('#date .datetimepicker-input').val(today);
        $('.datePicker').each(function (index) {
            index = index + 1;
            $('#date' + index).datetimepicker({
                locale: 'nl',
                icons: {
                    time: "fad fa-clock",
                    date: "fad fa-calendar",
                    up: "fad fa-arrow-up",
                    down: "fad fa-arrow-down"
                },
                format: 'L',
                useCurrent: true
            });
        });
    });
    $(document).ready(function () {
        tinymce.remove();
        tinymce.init({
            plugins: "autolink link",
            selector: '.info',
            branding: false,
            body_class: "rounded",
            mobile: {
                theme: 'silver'
            },
            menubar: false,
            relative_urls: true,
            forced_root_block: "",
            paste_data_images: true,
            invalid_elements: "script,img,iframe",
            toolbar: " redo | undo | bold | italic | link | unlink",
            default_link_target: "_blank"
        });
        tinymce.triggerSave();
        });
    $('#saveActivity').on('click', function (event) {
        event.preventDefault();

        if ($('#status').val() === '') {
            $('#status').addClass('is-invalid');
        } else {
            $('#status').removeClass('is-invalid');
        }

        if ($('#date input').val() == '') {
            $('#date input').addClass('is-invalid');
        } else {
            $('#date input').removeClass('is-invalid');
            $('#date input').addClass('is-valid');
        }


        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/prospect/prospect_activities_save.php', //Your form processing file URL
            data: {
                status: $('#status').val(),
                info: tinymce.get('info').getContent(),
                id: $('.currentid').attr('id'),
                date: $('#date input').val(),
            }, //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#newActivity').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    var page = $('#prospect_tasks').data('page');
                    $('#prospect_tasks').load('/controllers/tables/prospect/prospect_activities.php?id=<?php echo $prospect->getData('id') ?>&page=' + page, function () {
                    });
                } else {
                    $(".alert_field_prospect").load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
            return pattern.test(emailAddress);
        };
    });
    $('.editActivity').on('click', function (event) {
        event.preventDefault();

        if ($(this).parent().parent().find('#statusEdit').val() === '') {
            $(this).parent().parent().find('#statusEdit').addClass('is-invalid');
        } else {
            $(this).parent().parent().find('#statusEdit').removeClass('is-invalid');
        }

        if ($(this).parent().parent().find('.date').val() == '') {
            $(this).parent().parent().find('.date').addClass('is-invalid')
        } else {
            $(this).parent().parent().find('.date').removeClass('is-invalid');
            $(this).parent().parent().find('.date').addClass('is-valid');
        }


        var infoID = $(this).parent().parent().find('.info').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/prospect/prospect_activities_update.php', //Your form processing file URL
            data: {
                status: $(this).parent().parent().find('#statusEdit').val(),
                date: $(this).parent().parent().find('.date input').val(),
                id: $(this).parent().parent().find('#idActivity').val(),
                info: tinymce.get(infoID).getContent(),
            }, //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#newActivity').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    var page = $('#prospect_tasks').data('page');
                    $('#prospect_tasks').load('/controllers/tables/prospect/prospect_activities.php?id=<?php echo $prospect->getData('id') ?>&page=' + page, function () {
                    });
                } else {
                    $(".alert_field_prospect").load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

    });


    // $('#statusList .list-group-item').on('click', function () {
    //     var statusID = $(this).data('uid');
    //     var statusStatus = $(this).data('status');
    //
    //
    //     var page = $('.activities_table').attr('id');
    //     var id = $('.currentid').attr('id');
    //     var url = new URL(window.location.href);
    //     $.ajax({ //Process the form using $.ajax()
    //         type: 'POST', //Method type
    //         url: '/controllers/tables/prospect/prospect_activities_contact_save_status.php?id=' + statusID + '&status=' + statusStatus, //Your form processing file URL
    //         success: function (data) {
    //             data = JSON.parse(data);
    //
    //             if (data.status === 'success') {
    //                 $('#status' + statusID).modal('hide');
    //                 $('body').removeClass('modal-open');
    //                 $('.modal-backdrop').remove();
    //
    //
    //                 if (url.searchParams.get('status')) {
    //                     var status = url.searchParams.get('status');
    //                     if (status === "asc" || status === "desc") {
    //                         var statussearch = '&status=' + status;
    //                     }
    //                 } else {
    //                     var statussearch = '';
    //                 }
    //                 var page = $('#prospect_tasks').data('page');
    //                 $('#prospect_tasks').load('/controllers/tables/prospect/prospect_activities.php?page=' + page + '&id=' + id+statussearch, function () {
    //                 });
    //             } else {
    //                 $(".alert_field_status_" + statusID).load("/controllers/error.php", {
    //                     message: data.message,
    //                     class: data.class
    //                 }, function () {
    //
    //                     $('.alert').fadeIn(1000);
    //                 });
    //             }
    //         }
    //     });
    // });


    // $('.change_status').on('click', function (e) {
    //     var uid = $(this).data('uid');
    //     var page = $('.activities_table').attr('id');
    //     var id = $('.currentid').attr('id');
    //     $.ajax({ //Process the form using $.ajax()
    //         type: 'POST', //Method type
    //         url: '/controllers/tables/prospect/prospect_activities_contact_save_status.php?id=' + uid, //Your form processing file URL
    //         success: function (data) {
    //             data = JSON.parse(data);
    //
    //             if (data.status === 'success') {
    //                 $('#prospect_tasks').load('/controllers/tables/prospect/prospect_activities.php?page=' + page + '&id=' + id, function () {
    //                 });
    //             }
    //         }
    //     });
    //
    // });


    // $('tbody .tr_click').on('click', function e() {
    //     window.location.href = '/taak?id=' + $(this).parent().attr('id');
    //
    // });

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

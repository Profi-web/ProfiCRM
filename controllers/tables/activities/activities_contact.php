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
$users = new Users();


$employee = new User($activity->getData('user'));

$loginValidate = new validateLogin();
$loginValidate->securityCheck();
//
?>
<div class="p-0 m-0">
    <div class="card-header border-0 bg-light-second rounded-top p-3">
        <div class="row px-4 align-items-center justify-content-between">
            <div>Contactgegevens</div>
            <a class="btn btn-dark rounded text-white btn-sm" id="back_contact">Terug</a>
        </div>
    </div>
    <div class="container-fluid p-4 rounded-bottom rounded-top">
        <div class="alert_field">
        </div>
        <div class="row">
            <div class="col-12 ">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-0 py-2">
                        <label>Werknemer</label>
                        <div class="input-group">

                            <select class="custom-select rounded" id="userid" name="userid">
                                <?php
                                foreach ($users->findAll() as $single_user) {
                                    if ($employee->data['id'] == $single_user['id']) {
                                        ?>
                                        <option selected value="<?php echo $single_user['id']; ?>"><?php echo $single_user['name']; ?></option>

                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $single_user['id']; ?>"><?php echo $single_user['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <label>Relatie</label>
                        <div class="input-group">
                            <input type="text" class="form-control rounded relation_search"
                                   placeholder="Typ om te zoeken.."
                                   aria-label="Typ om te zoeken.."
                                   name="foo" autocomplete="off"
                                   value="<?php echo $activity->getRelationName($activity->getData('relation_id'), $activity->getData('relation_type')); ?>">
                            <input type="hidden" id="relation_id"
                                   value="<?php echo $activity->getData('relation_id'); ?>"/>
                            <input type="hidden" id="relation_type"
                                   value="<?php echo $activity->getData('relation_type'); ?>"/>
                            <div class="invalid-feedback">
                                Vul a.u.b een geldige keuze in
                            </div>
                            <!--                                   value="-->
                            <?php //echo $activity->getData('phonenumber'); ?><!--" -->

                        </div>
                        <div class="relation_box container position-absolute shadow"
                             style="z-index: 500;max-height: 500px;overflow: auto">
                            <div class="rounded row bg-light p-2 relation_search_box">
                                <div class="col-12 py-2 px-4 search_item muted">
                                    <a class="row align-items-center">
                                        <i class="fad fa-search text-primary search_icon"></i>
                                        <div class="pl-2 search_text">Typ om te zoeken</div>
                                    </a></div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <label>Status</label>
                        <div class="input-group">

                            <select class="custom-select rounded" id="status" name="status">
                                <option <?php if ($activity->getData('status') == '1') {
                                    echo 'selected';
                                } ?> value="1">Open
                                </option>
                                <option <?php if ($activity->getData('status') == '2') {
                                    echo 'selected';
                                } ?> value="2">Uitgevoerd
                                </option>
                                <option <?php if ($activity->getData('status') == '3') {
                                    echo 'selected';
                                } ?> value="3">In behandeling
                                </option>
                                <option <?php if ($activity->getData('status') == '4') {
                                    echo 'selected';
                                } ?> value="4">Wachten op klant
                                </option>
                            </select>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <label>Gefactureerd</label>
                        <div class="input-group">

                            <select class="custom-select rounded" id="gefactureerd" name="gefactureerd">
                                <option <?php if($activity->getData('facturering') == '1'){ echo 'selected'; }?> value="1">Nee</option>
                                <option <?php if($activity->getData('facturering') == '2'){ echo 'selected'; }?> value="2">Ja</option>
                                <option <?php if($activity->getData('facturering') == '3'){ echo 'selected'; }?> value="3">Service / Garantie</option>
                                <option <?php if($activity->getData('facturering') == '4'){ echo 'selected'; }?> value="4">Eigen gebruik</option>
                                <option <?php if($activity->getData('facturering') == '5'){ echo 'selected'; }?> value="5">Contract</option>

                            </select>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <label>Datum</label>
                        <div class="input-group date" id="date" data-target-input="nearest">
                            <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fad fa-calendar-alt pl-1"></i></div>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" data-target="#date"
                                   placeholder="Kies een datum en tijd"
                                   value="<?php echo $activity->getData('date'); ?>"/>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <label>Van</label>
                        <div class="input-group date" id="from_time" data-target-input="nearest">
                            <div class="input-group-append" data-target="#from_time" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fad fa-business-time pl-1"></i></div>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" data-target="#from_time"
                                   placeholder="Kies een datum en tijd"
                                   value="<?php echo $activity->getData('time_from'); ?>"/>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <label>Tot</label>
                        <div class="input-group date" id="to_time" data-target-input="nearest">
                            <div class="input-group-append" data-target="#to_time" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fad fa-business-time pl-1"></i></div>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" data-target="#to_time"
                                   placeholder="Kies een datum en tijd"
                                   value="<?php echo $activity->getData('time_to'); ?>"/>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <label>Reistijd</label>
                        <div class="input-group date">
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fad fa-clock pl-1"></i></div>
                            </div>
                            <input type="number" class="form-control" id="traveltime" placeholder="Vul het aantal minuten in" value="<?php echo $activity->getData('traveltime'); ?>"/>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row justify-content-end px-3">
            <button class="btn btn-success text-white rounded submit_activity_contact">Opslaan</button>

        </div>
    </div>
</div>
<script>
    $(function () {
        $('#date').datetimepicker({
            locale: 'nl',
            icons: {
                time: "fad fa-clock",
                date: "fad fa-calendar",
                up: "fad fa-arrow-up",
                down: "fad fa-arrow-down"
            },
            format: 'L'
        });

        $('#from_time').datetimepicker({
            locale: 'nl',
            icons: {
                time: "fad fa-clock",
                date: "fad fa-calendar",
                up: "fad fa-arrow-up",
                down: "fad fa-arrow-down"
            },
            format: 'LT'
        });

        $('#to_time').datetimepicker({
            locale: 'nl',
            icons: {
                time: "fad fa-clock",
                date: "fad fa-calendar",
                up: "fad fa-arrow-up",
                down: "fad fa-arrow-down"
            },
            format: 'LT'
        });
    });

    $(window).click(function () {

        /*WERKZAAMHEID*/
        $('.relation_box').hide();
        /**/
    });

    /*WERKZAAMHEDEN*/
    $('.relation_search').on('click', function (event) {
        event.stopPropagation();
        $('.relation_box').show();
    });
    /****************/


    /*SEARCH*/
    $('.relation_search').on("keyup input", function () {
        var defaultInput0 = '<div class="col-12 py-2 px-4 search_item muted">\n' +
            '                                                <a class="row align-items-center">\n' +
            '                                                    <i class="fad fa-search text-primary search_icon"></i>\n' +
            '                                                    <div class="pl-2 search_text">Typ om te zoeken</div>' +
            '                                                </a>\n' +
            '                                            </div>';
        var defaultInput1 = '<div class="col-12 py-2 px-4 search_item muted">\n' +
            '                                                <a class="row align-items-center">\n' +
            '                                                    <i class="fad fa-search text-primary search_icon"></i>\n' +
            '                                                    <div class="pl-2 search_text">Typ minimaal 2 tekens om te zoeken</div>' +
            '                                                </a>\n' +
            '                                            </div>';

        var inputVal = $('.relation_search').val();
        var resultDropdown = $('.relation_search_box');
        if (inputVal.length >= 2) {

            $.get("/controllers/search/contact_relation_search.php", {term: inputVal}).done(function (data) {
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else if (inputVal.length = 1) {
            resultDropdown.html(defaultInput1);
        } else {
            resultDropdown.html(defaultInput0);
        }
    });


    /**//**//**/


    $('#back_contact').on('click', function () {
        $('#activity_contact').load('/controllers/tables/activities/activities_contact_single.php?id=<?php echo $id; ?>', function () {
        });
    });
    $('.submit_activity_contact').on('click', function (event) {
        event.preventDefault();
        if ($('.relation_search').val() !== '') {
            $('.relation_search').removeClass('is-invalid');
            $('.relation_search').addClass('is-valid');
        }

        if ($('#status').val() == '') {
            $('#status').addClass('is-invalid');
        } else {
            $('#status').removeClass('is-invalid');
            $('#status').addClass('is-valid');
        }

        if ($('#gefactureerd').val() == '') {
            $('#gefactureerd').addClass('is-invalid');
        } else {
            $('#gefactureerd').removeClass('is-invalid');
            $('#gefactureerd').addClass('is-valid');
        }

        if ($('#userid').val() == '') {
            $('#userid').addClass('is-invalid');
        } else {
            $('#userid').removeClass('is-invalid');
            $('#userid').addClass('is-valid');
        }

        if (!$('.relation_search').val()) {
            $('#relation_id').val('');
            $('#relation_type').val('');
        }//

        if ($('#date input').val() == '') {
            $('#date input').addClass('is-invalid');
        } else {
            $('#date input').removeClass('is-invalid');
            $('#date input').addClass('is-valid');
        }
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save.php?id=<?php echo $id;?>', //Your form processing file URL
            data: {
                user: $('#userid').val(),
                relation: $('#relation_id').val(),
                type: $('#relation_type').val(),
                status: $('#status').val(),
                gefactureerd: $('#gefactureerd').val(),
                date: $('#date input').val(),
                from_time: $('#from_time input').val(),
                to_time: $('#to_time input').val(),
                traveltime: $('#traveltime').val(),
            }
            , //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#activity_contact').load('/controllers/tables/activities/activities_contact_single.php?id=<?php echo $activity->getData('id') ?>', function () {
                    });
                } else {
                    $(".alert_field").load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });
    });

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    };


</script>

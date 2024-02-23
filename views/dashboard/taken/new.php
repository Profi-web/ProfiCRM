<?php
/*Page Info*/
$page = 'Nieuwe taak';
$type = 'single_activity';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
//if(isset($_GET['id']) && ctype_digit($_GET['id'])){
//    $id = $_GET['id'];
//} else {
//    header('Location: /404');
//}
/**/


/*Classes*/
$user = new User();
$activity = new Activity();


$users = new Users();

$usertheme = new User();
/*CSS*/
?>
<?php

/*Header*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php';
?>
<link rel="stylesheet" href="/assets/css/dashboard.min.css">
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/header.php';
/**/
?>
<!--    HEADER-->

<div class="container-fluid justify-content-center" style="margin-top:-40px;">
    <div class="row px-3 px-md-5 justify-content-between">
        <div class="p-0 col-12 col-xl-9 pr-xl-4 mb-4">
            <div class="card shadow" id="activities_info">
                <div class="card-header border-0 bg-white rounded-top p-3">
                    <div class="row px-4 align-items-center justify-content-between">
                        <ol class="breadcrumb bg-white m-0 p-0">
                            <li class="breadcrumb-item active">Nieuwe taak</li>
                        </ol>
                    </div>
                </div>
                <div class="container-fluid  bg-light-second py-3 rounded-bottom">
                    <div class="row p-3">
                        <div class="col-12">
                            <div class="text-primary pb-3">Informatie</div>
                            <textarea rows="35" id="input_data"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3 pl-md-3 pr-md-3">
            <form class="row" novalidate>
                <div class="col-12 p-0">
                    <div class="card shadow " id="activities_contact">
                        <div class="card-header border-0 bg-light-second rounded-top p-3">
                            <div class="row px-4 align-items-center justify-content-between">
                                <div>Contactgegevens</div>
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
                                                        if ($_GET['id'] == $single_user['id']) {
                                                            ?>
                                                            <option selected
                                                                    value="<?php echo $single_user['id']; ?>"><?php echo $single_user['name']; ?></option>

                                                            <?php
                                                        } else {
                                                            if ($single_user['visible'] == 1) {
                                                                ?>
                                                                <option value="<?php echo $single_user['id']; ?>"><?php echo $single_user['name']; ?></option>
                                                                <?php
                                                            }
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

                                                <select class="custom-select rounded" id="facturering"
                                                        name="facturering">
                                                    <option <?php if ($activity->getData('facturering') == '1') {
                                                        echo 'selected';
                                                    } ?> value="1">Nee
                                                    </option>
                                                    <option <?php if ($activity->getData('facturering') == '2') {
                                                        echo 'selected';
                                                    } ?> value="2">Ja
                                                    </option>
                                                    <option <?php if ($activity->getData('facturering') == '3') {
                                                        echo 'selected';
                                                    } ?> value="3">Service / Garantie
                                                    </option>
                                                    <option <?php if ($activity->getData('facturering') == '4') {
                                                        echo 'selected';
                                                    } ?> value="4">Eigen gebruik
                                                    </option>
                                                    <option <?php if ($activity->getData('facturering') == '5') {
                                                        echo 'selected';
                                                    } ?> value="5">Contract
                                                    </option>
                                                </select>
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2 dateli">
                                            <label>Datum</label>
                                            <div class="input-group date" id="date" data-target-input="nearest">
                                                <div class="input-group-append" data-target="#date"
                                                     data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i
                                                                class="fad fa-calendar-alt pl-1"></i></div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-input"
                                                       data-target="#date" placeholder="Kies een datum en tijd"
                                                       value="<?php echo $activity->getData('date'); ?>"/>
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <label>Van</label>
                                            <div class="input-group date" id="from_time" data-target-input="nearest">
                                                <div class="input-group-append" data-target="#from_time"
                                                     data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i
                                                                class="fad fa-business-time  pl-1"></i></div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-input"
                                                       data-target="#from_time" placeholder="Kies een datum en tijd"
                                                       value="<?php echo $activity->getData('time_from'); ?>"/>
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <label>Tot</label>
                                            <div class="input-group date" id="to_time" data-target-input="nearest">
                                                <div class="input-group-append" data-target="#to_time"
                                                     data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i
                                                                class="fad fa-business-time  pl-1"></i></div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-input"
                                                       data-target="#to_time" placeholder="Kies een datum en tijd"
                                                       value="<?php echo $activity->getData('time_to'); ?>"/>
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <label>Reistijd</label>
                                            <div class="input-group date">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fad fa-clock pl-1"></i>
                                                    </div>
                                                </div>
                                                <input type="number" class="form-control"
                                                       placeholder="Vul het aantal minuten in" id="traveltime"
                                                       value="<?php echo $activity->getData('time_to'); ?>"/>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-0 mt-4">
                    <button class="w-100 btn btn-success text-white rounded shadow" id="save_data" type="submit">
                        Opslaan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="bottom_notes">Profi-crm versie <?php $versions = new Versions();
    echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script>
    $(document).ready(function () {
        var url = new URL(window.location.href);
        var resultDropdown = $('.relation_search_box');
        if (url.searchParams.get('relation')) {
            var relation = url.searchParams.get('relation');
            $.get("/controllers/search/contact_relation_search.php", {term: relation}).done(function (data) {
                // Display the returned data in browser
                resultDropdown.html(data);
                var relation_id = $('.relation_search_box').find('.search_item').attr('relationid');
                var relation_type = $('.relation_search_box').find('.search_item').attr('relationtype');
                var text = $('.relation_search_box').find('.relation_item_text').html();
                $('.relation_search').val(text);
                $('#relation_id').val(relation_id);
                $('#relation_type').val(relation_type);
            });

        }
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

        $('.dateli .datetimepicker-input').val(today);
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

    tinymce.init({
        plugins: "autolink link",
        selector: '#input_data',
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


    let loading = false;
    tinymce.triggerSave();
    $('form').submit(function (event) {
        if (loading) {
            return;
        }
        loading = true;
        $('#save_data').text('Laden...');
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

        if ($('#facturering').val() == '') {
            $('#facturering').addClass('is-invalid');
        } else {
            $('#facturering').removeClass('is-invalid');
            $('#facturering').addClass('is-valid');
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
            $('.relation_search').addClass('is-invalid');
        } else {
            $('.relation_search').removeClass('is-invalid');
            $('.relation_search').addClass('is-valid');
        }

        if ($('#date input').val() == '') {
            $('#date input').addClass('is-invalid');
        } else {
            $('#date input').removeClass('is-invalid');
            $('#date input').addClass('is-valid');
        }

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_save.php', //Your form processing file URL
            data: {
                text: tinymce.get('input_data').getContent(),
                relation: $('#relation_id').val(),
                user: $('#userid').val(),
                type: $('#relation_type').val(),
                status: $('#status').val(),
                facturering: $('#facturering').val(),
                date: $('#date input').val(),
                from_time: $('#from_time input').val(),
                to_time: $('#to_time input').val(),
                traveltime: $('#traveltime').val(),
            }, //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    window.location.href = '/taken';
                } else {
                    $(".alert_field").load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            },
            complete: function (data) {
                loading = false;
                $('#save_data').text('Opslaan');
            }
        });

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
            return pattern.test(emailAddress);
        };
    });

    // if ctrl + s is pressed
    $(document).keydown(function (e) {
        if ((e.ctrlKey && e.key === 's')) {
            e.preventDefault();
            $("#save_data").click();
            return false;
        }

        return true;
    });
</script>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/activities.js"></script>

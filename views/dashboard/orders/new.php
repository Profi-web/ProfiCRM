<?php
/*Page Info*/
$page = 'Nieuwe bestelling';
$type = 'single_order';
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
$order = new Order();

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
            <div class="card shadow" id="orders_info">
                <div class="card-header border-0 bg-white rounded-top p-3">
                    <div class="row px-4 align-items-center justify-content-between">
                        <ol class="breadcrumb bg-white m-0 p-0">
                            <li class="breadcrumb-item active">Nieuwe bestelling</li>
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
                    <div class="card shadow " id="orders_contact">
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
                                            <label>Afgesproken prijs</label>
                                            <div class="input-group mb-2 mr-sm-2 rounded">
                                                <div class="input-group-prepend rounded">
                                                    <div class="input-group-text" style="border-top-left-radius: 5px;

border-bottom-left-radius: 5px;"><i class="fad fa-euro-sign" style="margin-left: 2px;"></i></div>
                                                </div>
                                                <input type="text" class="form-control" style="border-bottom-right-radius 5px !important;border-bottom-left-radius 5px !important;" id="price" name="price" placeholder="Prijs">
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <label>Relatie</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control rounded relation_search"
                                                       placeholder="Typ om te zoeken.."
                                                       aria-label="Typ om te zoeken.."
                                                       name="foo" autocomplete="off"
                                                       value="<?php echo $order->getRelationName($order->getData('relation_id'), $order->getData('relation_type')); ?>">
                                                <input type="hidden" id="relation_id"
                                                       value="<?php echo $order->getData('relation_id'); ?>"/>
                                                <input type="hidden" id="relation_type"
                                                       value="<?php echo $order->getData('relation_type'); ?>"/>
                                                <div class="invalid-feedback">
                                                    Vul a.u.b een geldige keuze in
                                                </div>
                                                <!--                                   value="-->
                                                <?php //echo $order->getData('phonenumber'); ?><!--" -->

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
                                            <label>Besteld?</label>
                                            <div class="input-group">

                                                <select class="custom-select rounded" id="status" name="status">
                                                    <option <?php if($order->getData('status') == '1'){ echo 'selected'; }?> value="1">Nee</option>
                                                    <option <?php if($order->getData('status') == '2'){ echo 'selected'; }?> value="2">Ja</option>
                                                </select>
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <label>Gefactureerd</label>
                                            <div class="input-group">

                                                <select class="custom-select rounded" id="facturering" name="facturering">
                                                    <option <?php if($order->getData('facturering') == '1'){ echo 'selected'; }?> value="1">Nee</option>
                                                    <option <?php if($order->getData('facturering') == '2'){ echo 'selected'; }?> value="2">Ja</option>
                                                    <option <?php if($order->getData('facturering') == '3'){ echo 'selected'; }?> value="3">Service / Garantie</option>
                                                    <option <?php if($order->getData('facturering') == '4'){ echo 'selected'; }?> value="4">Eigen gebruik</option>
                                                    <option <?php if($order->getData('facturering') == '5'){ echo 'selected'; }?> value="5">Contract</option>
                                                </select>
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
<div class="bottom_notes">Profi-crm versie <?php $versions = new Versions(); echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script>
    $("#price").on("keypress keyup blur",function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    <?php
    if($order->getData("price") != '-'){
    ?>
    $("#price").val('<?php echo $order->getData("price"); ?>');
    <?php
    }
    ?>
    $(document).ready(function () {
        var url = new URL(window.location.href);
        var resultDropdown = $('.relation_search_box');
       if(url.searchParams.get('relation')){
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
        relative_urls : true,
        forced_root_block: "",
        paste_data_images: true,
        invalid_elements : "script,img,iframe",
        toolbar: " redo | undo | bold | italic | link | unlink",
        default_link_target: "_blank"
    });
    tinymce.triggerSave();
        $('form').submit(function (event) {
        event.preventDefault();
        var priceMatch = '/^\d+(\.\d{2})?$/';

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

        if ($('#price').val() == '') {
            $('#price').addClass('is-invalid');
        } else {
            $('#price').removeClass('is-invalid');
            $('#price').addClass('is-valid');
        }
        if ($('#price').val() == '' || $('#price').val().length > 10) {
            $('#price').addClass('is-invalid');
        } else {
            $('#price').removeClass('is-invalid');
            $('#price').addClass('is-valid');
        }



        if(!$('.relation_search').val()) {
            $('#relation_id').val('');
            $('#relation_type').val('');
            $('.relation_search').addClass('is-invalid');
        } else {
            $('.relation_search').removeClass('is-invalid');
            $('.relation_search').addClass('is-valid');
        }

        var price =  $('#price').val().trim();

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/orders/orders_save.php', //Your form processing file URL
            data: {
                text: tinymce.get('input_data').getContent(),
                relation: $('#relation_id').val(),
                type: $('#relation_type').val(),
                status: $('#status').val(),
                facturering: $('#facturering').val(),
                price: price,
            }, //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    window.location.href = '/bestellingen';
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

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
            return pattern.test(emailAddress);
        };
    });
    var currencyInput = document.querySelector('input[type="currency"]');
    var currency = 'EUR'; // https://www.currency-iso.org/dam/downloads/lists/list_one.xml

    currencyInput.addEventListener('focus', onFocus);
    currencyInput.addEventListener('blur', onBlur);

    function localStringToNumber( s ){
        return Number(String(s).replace(/[^0-9.-]+/g,""));
    }

    function onFocus(e){
        var value = e.target.value;
        e.target.value = value ? localStringToNumber(value) : '';
    }

    function onBlur(e){
        var value = e.target.value;

        const options = {
            maximumFractionDigits : 2,
            currency              : currency,
            style                 : "currency",
            currencyDisplay       : "symbol"
        }

        e.target.value = value
            ? localStringToNumber(value).toLocaleString(undefined, options)
            : ''
    }
</script>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/orders.js"></script>

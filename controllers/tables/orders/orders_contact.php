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

$order = new Order($id);
$users = new Users();


$employee = new User();

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
        <div class="row" id="contact">
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
                        <label>Status</label>
                        <div class="input-group">

                            <select class="custom-select rounded" id="status" name="status">
                                <option <?php if ($order->getData('status') == '1') {
                                    echo 'selected';
                                } ?> value="1">Nee
                                </option>
                                <option <?php if ($order->getData('status') == '2') {
                                    echo 'selected';
                                } ?> value="2">Ja
                                </option>
                            </select>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <label>Gefactureerd</label>
                        <div class="input-group">

                            <select class="custom-select rounded" id="gefactureerd" name="gefactureerd">
                                <option <?php if ($order->getData('facturering') == '1') {
                                    echo 'selected';
                                } ?> value="1">Nee
                                </option>
                                <option <?php if ($order->getData('facturering') == '2') {
                                    echo 'selected';
                                } ?> value="2">Ja
                                </option>
                                <option <?php if ($order->getData('facturering') == '3') {
                                    echo 'selected';
                                } ?> value="3">Service / Garantie
                                </option>
                                <option <?php if ($order->getData('facturering') == '4') {
                                    echo 'selected';
                                } ?> value="4">Eigen gebruik
                                </option>

                            </select>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row justify-content-end px-3">
            <button class="btn btn-success text-white rounded submit_order_contact">Opslaan</button>

        </div>
    </div>
</div>
<script>
    $("#price").on("keypress keyup blur",function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $(function() {
        // $('#price').maskMoney({ prefix: ' €'});

    })
    <?php
    if($order->getData("price") != '-'){
    ?>
    $("#price").val('<?php echo $order->getData("price"); ?>');
    <?php
    }
    ?>
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
        $('#order_contact').load('/controllers/tables/orders/orders_contact_single.php?id=<?php echo $id; ?>', function () {
        });
    });
    $('.submit_order_contact').on('click', function (event) {
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

        if ($('#gefactureerd').val() == '') {
            $('#gefactureerd').addClass('is-invalid');
        } else {
            $('#gefactureerd').removeClass('is-invalid');
            $('#gefactureerd').addClass('is-valid');
        }

        if ($('#price').val() == '' || $('#price').val().length > 10) {
            $('#price').addClass('is-invalid');
        } else {
            $('#price').removeClass('is-invalid');
            $('#price').addClass('is-valid');
        }

        if (!$('.relation_search').val()) {
            $('#relation_id').val('');
            $('#relation_type').val('');
        }//

        var price =  $('#price').val().trim();

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/orders/orders_contact_save.php?id=<?php echo $id;?>', //Your form processing file URL
            data: {
                relation: $('#relation_id').val(),
                type: $('#relation_type').val(),
                status: $('#status').val(),
                gefactureerd: $('#gefactureerd').val(),
                price:price,
            }
            , //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#order_contact').load('/controllers/tables/orders/orders_contact_single.php?id=<?php echo $order->getData('id') ?>', function () {
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

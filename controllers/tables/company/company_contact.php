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
<form class="p-0 m-0" id="company_contact_form" novalidate>
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
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fad fa-sign"></i></span>
                            </div>
                            <input type="tel" class="form-control" placeholder="Bedrijfsnaam" aria-label="Bedrijfsnaam"
                                   id="name" value="<?php echo $company->getData('name'); ?>" required>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fad fa-phone-office"></i></span>
                            </div>
                            <input type="tel" class="form-control" placeholder="Telefoonnummer"
                                   aria-label="Telefoonnummer"
                                   id="phonenumber" value="<?php echo $company->getData('phonenumber'); ?>" name="tel">
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fad fa-at"></i></span>
                            </div>
                            <input type="email" class="form-control" placeholder="Email" aria-label="Email" id="email" name="email"
                                   value="<?php echo $company->getData('email'); ?>">
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fad fa-road"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Adres" aria-label="Adres" id="address"
                                   value="<?php echo $company->getData('address'); ?>">
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fad fa-map"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Postcode" aria-label="Postcode"
                                   id="zipcode" value="<?php echo $company->getData('zipcode'); ?>">
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fad fa-city"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Stad" aria-label="Stad" id="city"
                                   value="<?php echo $company->getData('city'); ?>">
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fad fa-university"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="KvK" aria-label="KvK" id="kvk1"
                                   value="<?php echo $company->getData('kvk'); ?>">
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fad fa-money-check"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="IBAN" aria-label="IBAN" id="iban1"
                                   value="<?php echo $company->getData('iban'); ?>">
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row justify-content-end px-3">
            <button class="btn btn-success text-white rounded" id="save_data_contact" type="submit">Opslaan</button>

        </div>
    </div>
</form>
<script>
    $('#back_contact').on('click',function () {
        $('#company_contact').load('/controllers/tables/company/company_contact_single.php?id=<?php echo $id; ?>', function () {
        });
    });
    $('#company_contact_form').submit(function (event) {
        // alert(1);
        event.preventDefault();
        if ($('#name').val() === '') {
            $('#name').addClass('is-invalid');
        } else {
            $('#name').removeClass('is-invalid');
        }

        if ($('#phonenumber').val() !== '') {
            if (!$.isNumeric($('#phonenumber').val())) {
                $('#phonenumber').addClass('is-invalid');
            } else {
                $('#phonenumber').removeClass('is-invalid');
            }
        }

        if ($('#email').val() !== '') {
            if (!isValidEmailAddress($('#email').val())) {
                $('#email').addClass('is-invalid');
            } else {
                $('#email').removeClass('is-invalid');
            }
        }

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/company/company_contact_save.php?id=<?php echo $id;?>', //Your form processing file URL
            data: {
                name: $('#name').val(),
                phonenumber: $('#phonenumber').val(),
                email: $('#email').val(),
                address: $('#address').val(),
                zipcode: $('#zipcode').val(),
                city: $('#city').val(),
                kvk: $('#kvk1').val(),
                iban: $('#iban1').val()
            }
            , //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#company_contact').load('/controllers/tables/company/company_contact_single.php?id=<?php echo $id; ?>', function () {
                    });
                    $('#company_info').load('/controllers/tables/company/company_info_single.php?id=<?php echo $company->getData('id') ?>', function () {
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

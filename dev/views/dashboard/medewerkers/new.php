<?php
/*Page Info*/
$page = 'Nieuwe medewerker';
$type = 'employees_new';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/


/*Classes*/
$user = new User();
$users = new Users();
//

if ($user->data['role'] != 1) {
    header('Location: /medewerkers');
}

/*CSS*/


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
        <div class="p-0 col-12  pr-xl-4 mb-4">
            <div class="card shadow" id="company_info">
                <div class="card-header border-0 bg-light-second rounded-top p-3">
                    <div class="row px-4 align-items-center justify-content-between">
                        <div>Contactgegevens</div>
                        <a class="btn btn-dark rounded text-white btn-sm trigger_contact"
                           href="/medewerkers">Terug</a>
                    </div>
                </div>
                <div class="container-fluid p-4 rounded-bottom rounded-top">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="text-center mb-3">
                                <div class="text-center mb-3">
                                    <img src="/assets/media/bun.gif" width="50px" height="50px" class="spinner"
                                         style="display: none;"/>
                                </div>
                            </div>
                            <div class="alert_field">
                            </div>
                            <div id="profile_info">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Naam</label>
                                        <input type="text" class="form-control" id="name" placeholder="Naam"
                                               required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="role">Positie</label>
                                        <select class="form-control" id="role">

                                            <?php
                                           foreach ( $users->getRoles() as $role) {
?>
                                               <option value="<?php echo $role['id'];?>"><?php echo $role['name'];?>
                                               </option>
                                            <?php
                                           }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="password">Wachtwoord</label>
                                        <input type="password" class="form-control" id="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Adres</label>
                                    <input type="text" class="form-control" id="address">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="zipcode">Postcode</label>
                                        <input type="text" class="form-control" id="zipcode"
                                        >
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="city">Stad</label>
                                        <input type="text" class="form-control" id="city">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phonenumber">Telefoonnummer</label>
                                        <input type="text" class="form-control" id="phonenumber"
                                               value="<?php echo $user->data['phonenumber']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    Profiel plaatje
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="profile_image"
                                                   aria-describedby="profile_image" accept="image/*">
                                            <label class="custom-file-label rounded-left-15" for="profile_image">
                                                Kies een plaatje
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    Banner plaatje
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="banner_image"
                                                   aria-describedby="banner_image">
                                            <label class="custom-file-label rounded-left-15"
                                                   for="banner_image">
                                                Kies een plaatje
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="info">Informatie</label>
                                        <textarea class="form-control" id="info"
                                                  rows="3"></textarea>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <div class="container-fluid">
                        <div class="row justify-content-between">
                            <a class="btn btn-success float-right btn-sm text-white rounded"
                               id="new_profile">Opslaan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bottom_notes">Profi-crm versie <?php $versions = new Versions(); echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script>
    var $loading = $('.spinner').hide();
    $('#new_profile').on('click', function (event) {
        var error = 0;
        var error_message = '';

        $loading.show();


        var formData = new FormData();

        if ($('#name').val() === '') {
            $('#name').addClass('is-invalid');
        } else {
            $('#name').removeClass('is-invalid');
        }


        if ($('#name').val() === '') {
            $('#name').addClass('is-invalid');
            error++;
            error_message = error_message + 'Vul een naam in<br>';
        } else {
            $('#name').removeClass('is-invalid');
            formData.append('name', $('#name').val())
        }

        if ($('#role').val() === '') {
            $('#role').addClass('is-invalid');
            error++;
            error_message = error_message + 'Vul een geldige positie in<br>';
        } else {
            $('#role').removeClass('is-invalid');
            formData.append('role', $('#role').val())
        }

        if ($('#email').val() !== '') {
            if (!isValidEmailAddress($('#email').val())) {
                $('#email').addClass('is-invalid');
                error++;
                error_message = error_message + 'Vul een geldig email in<br>';
            } else {
                $('#email').removeClass('is-invalid');
                formData.append('email', $('#email').val())
            }
        } else {
            $('#email').addClass('is-invalid');
            error++;
            error_message = error_message + 'Vul een geldig email in<br>';
        }

        if ($('#password').val() === '') {
            $('#password').addClass('is-invalid');
            error++;
            error_message = error_message + 'Vul een wachtwoord in<br>';
        } else {
            $('#password').removeClass('is-invalid');
            formData.append('password', $('#password').val())
        }

        if ($('#address').val() !== '') {
            formData.append('address', $('#address').val())
        }
        if ($('#zipcode').val() !== '') {
            formData.append('zipcode', $('#zipcode').val())
        }

        if ($('#city').val() !== '') {
            formData.append('city', $('#city').val())
        }

        if ($('#phonenumber').val() !== '') {
            if (!$.isNumeric($('#phonenumber').val())) {
                $('#phonenumber').addClass('is-invalid');
                error++;
                error_message = error_message + 'Vul een geldig telefoonnummer in<br>';
            } else {
                $('#phonenumber').removeClass('is-invalid');
                formData.append('phonenumber', $('#phonenumber').val())
            }
        }

        if ($('#info').val() !== '') {
            formData.append('info', $('#info').val())
        }

        if ($('#profile_image').val()) {
            formData.append('picture', $('#profile_image')[0].files[0]);
        }

        if ($('#banner_image').val()) {
            formData.append('banner', $('#banner_image')[0].files[0]);
        }

        if (error < 1) {
            if (formData) {
                $.ajax({
                    url: '/controllers/profile/profile_contact_new.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (data) {
                        $loading.hide();
                        data = JSON.parse(data);

                        if (data.status === 'success') {
                            window.location.href = '/medewerkers';
                        } else {
                            $(".alert_field").load("/controllers/error.php", {
                                message: data.message,
                                class: data.class
                            }, function () {

                                $('.alert').fadeIn(1000);
                            });
                        }

                    },
                    error: function () {
                        $loading.hide();
                        $(".alert_field").load("/controllers/error.php", {
                            message: 'Oeps er ging iets mis!',
                            class: 'alert-danger'
                        }, function () {

                            $('.alert').fadeIn(1000);
                        });
                    }
                });
            } else {
                $loading.hide();
            }
        } else {
            $(".alert_field").load("/controllers/error.php", {
                message: error_message,
                class: 'alert-danger'
            }, function () {

                $('.alert').fadeIn(1000);
            });
            $loading.hide();
        }

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
            return pattern.test(emailAddress);
        };
    });
    $('#banner_image').on('change', function () {
        //get the file name
        var fileName = $(this).val();
        var cleanFileName = fileName.replace('C:\\fakepath\\', " ");
        //replace the "Choose a file" label
        $('#banner_image').next('.custom-file-label').html(cleanFileName);
    });
    $('#profile_image').on('change', function () {
        //get the file name
        var fileName = $(this).val();
        var cleanFileName = fileName.replace('C:\\fakepath\\', " ");
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(cleanFileName);
    });

</script>
<script src="/assets/js/dashboard/main.js"></script>
<!--<script src="/assets/js/dashboard/tables/company.js"></script>-->
<!--<script src="/assets/js/dashboard/tables/company/companies.js"></script>-->

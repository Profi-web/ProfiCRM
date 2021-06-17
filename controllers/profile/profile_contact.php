<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {


    /*Classes*/
    $upperuser = new User($_SESSION['userid']);
    $id = $_GET['id'];
    $user = new User($id);
    $profile_id = $id;
//
} else {
    /*Classes*/
    $user = new User();
    $profile_id = $user->data['id'];
//
}

$users = new Users();
$loggedinUser = new User();
//$company = new Company($id);


$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();
//
?>
<div class="card-header border-0 bg-light-second rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <div>Contactgegevens</div>
        <a class="btn btn-dark rounded text-white btn-sm trigger_contact"
           id="back_button">Terug</a>
    </div>
</div>
<div class="container-fluid p-4 rounded-bottom rounded-top">
    <div class="row">
        <div class="col-12 ">
            <div class="text-center mb-3">
                <div class="text-center mb-3">
                    <img src="/assets/media/bun.gif" width="50px" height="50px" class="spinner"/>
                </div>
            </div>
            <div class="alert_field">
            </div>
            <div id="profile_info">
                <div class="form-row">
                    <div class="form-group col-md-<?php if($loggedinUser->data['role'] == 1) {echo 6;} else {echo 12;} ?>">
                        <label for="name">Naam</label>
                        <input type="text" class="form-control" id="name" placeholder="Naam"
                               value="<?php echo $user->data['name']; ?>" required>
                    </div>
                    <?php
                    if($loggedinUser->data['role'] == 1) {
                        ?>
                        <div class="form-group col-md-6">
                            <label for="role">Positie</label>
                            <?php

                            ?>
                            <select class="form-control" id="role">
                                <?php
                                foreach ($users->getRoles() as $role) {
                                    if ($role['id'] === '1') {
                                        ?>
                                        <option value="<?php echo $role['id']; ?>" <?php if ($user->data['role'] === $role['id']) {
                                            echo 'selected';
                                        }
                                        if ($upperuser->data['role'] !== $role['id']) {
                                            echo 'disabled';
                                        } ?>><?php echo $role['name']; ?></option>

                                        <?php
                                    } else {

                                        ?>
                                        <option value="<?php echo $role['id']; ?>" <?php if ($user->data['role'] === $role['id']) {
                                            echo 'selected';
                                        } ?>><?php echo $role['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $user->data['email']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Wachtwoord</label>
                        <input type="password" class="form-control" id="password" value="******"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Adres</label>
                    <input type="text" class="form-control" id="address" value="<?php echo $user->data['address']; ?>">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="zipcode">Postcode</label>
                        <input type="text" class="form-control" id="zipcode"
                               value="<?php echo $user->data['zipcode']; ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="city">Stad</label>
                        <input type="text" class="form-control" id="city" value="<?php echo $user->data['city']; ?>">
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
                        <?php if ($user->data['picture']) { ?>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="remove_profile_image"><i
                                            class="fad fa-times pl-1"></i></span>
                            </div>
                        <?php } ?>
                        <div class="custom-file">
                            <input type="hidden" id="remove_profile_image_value" value="0"/>
                            <input type="file" class="custom-file-input" id="profile_image"
                                   aria-describedby="profile_image" accept="image/*">
                            <label class="custom-file-label <?php if (!$user->data['picture']) {
                                echo 'rounded-left-15';
                            } ?>" for="profile_image">
                                <?php if ($user->data['picture']) {
                                    echo $user->data['picture'];
                                } else {
                                    echo 'Kies een plaatje';
                                } ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    Banner plaatje
                    <div class="input-group">
                        <?php if ($user->data['banner']) { ?>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="remove_profile_banner"><i
                                            class="fad fa-times pl-1"></i></span>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="custom-file">
                            <input type="hidden" id="remove_profile_banner_value" value="0"/>
                            <input type="file" class="custom-file-input" id="banner_image"
                                   aria-describedby="banner_image">
                            <label class="custom-file-label <?php if (!$user->data['banner']) {
                                echo 'rounded-left-15';
                            } ?>" for="banner_image">
                                <?php if ($user->data['banner']) {
                                    echo $user->data['banner'];
                                } else {
                                    echo 'Kies een plaatje';
                                } ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label for="info">Informatie</label>
                        <textarea class="form-control" id="info"
                                  rows="3"><?php echo $user->data['info']; ?></textarea>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<div class="card-footer ">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <a class="btn btn-danger btn-sm text-white rounded" id="delete_profile">Verwijderen</a>
            <a class="btn btn-success float-right btn-sm text-white rounded" id="save_profile">Opslaan</a>
        </div>
    </div>
</div>
<script>
    alertify.defaults.transition = "fade";
    alertify.defaults.theme.ok = "btn btn-info btn-sm rounded";
    alertify.defaults.theme.cancel = "btn btn-danger btn-sm rounded";
    alertify.defaults.theme.input = "form-control";
    alertify.defaults.glossary.ok = "Oke";
    alertify.defaults.glossary.cancel = "Annuleren";

    $('#delete_profile').on('click', function () {
        var id = '<?php echo $user->data['id']; ?>';
        alertify.confirm('Verwijderen', "Weet je zeker dat je dit profiel wilt verwijderen?",
            function () {
                $.ajax({ //Process the form using $.ajax()
                    type: 'POST', //Method type
                    url: '/controllers/profile/profile_delete.php', //Your form processing file URL
                    data: {'id': id}, //Forms name
                    success: function (data) {
                        data = JSON.parse(data);

                        if (data.status === 'success') {
                            window.location.href = '/';
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
            },
            function () {
            });
    });

    $('#remove_profile_banner').on('click', function () {
        $('#remove_profile_banner_value').val(1);
        $('#banner_image').next('.custom-file-label').html('Kies een plaatje');
        $('#banner_image').next('.custom-file-label').addClass('rounded-left-15');
        $('#remove_profile_banner').hide();
    });

    $('#remove_profile_image').on('click', function () {
        $('#remove_profile_image_value').val(1);
        $('#profile_image').next('.custom-file-label').html('Kies een plaatje');
        $('#profile_image').next('.custom-file-label').addClass('rounded-left-15');
        $('#remove_profile_image').hide();
    });


    /*Storing current data*/
    var stored_name = $('#name').val();
    var stored_role = $('#role').val();
    var stored_email = $('#email').val();
    var stored_password = $('#password').val();
    var stored_address = $('#address').val();
    var stored_zipcode = $('#zipcode').val();
    var stored_city = $('#city').val();
    var stored_phonenumber = $('#phonenumber').val();
    var stored_info = $('#info').val();


    var $loading = $('.spinner').hide();
    $('#save_profile').on('click', function () {
        var error = 0;
        var error_message = '';

        $loading.show();

        //ERRORS


        var formData = new FormData();

        if ($('#remove_profile_banner_value').val() == 1) {
            formData.append('remove_profile_banner_value', 1)
        }

        if ($('#remove_profile_image_value').val() == 1) {
            formData.append('remove_profile_image_value', 1)
        }

        if ($('#profile_image').val()) {
            formData.append('picture', $('#profile_image')[0].files[0]);
        }

        if ($('#banner_image').val()) {
            formData.append('banner', $('#banner_image')[0].files[0]);
        }


        if (stored_name !== $('#name').val()) {
            if ($('#name').val() === '') {
                $('#name').addClass('is-invalid');
                error++;
                error_message = error_message + 'Vul een naam in<br>';
            } else {
                $('#name').removeClass('is-invalid');
                formData.append('name', $('#name').val())
            }
        }
        if (stored_role !== $('#role').val()) {
            if ($('#role').val() === '') {
                $('#role').addClass('is-invalid');
                error++;
                error_message = error_message + 'Vul een geldige positie in<br>';
            } else {
                $('#role').removeClass('is-invalid');
                formData.append('role', $('#role').val())
            }
        }
        if (stored_email !== $('#email').val()) {
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
        }
        if (stored_address !== $('#address').val()) {
            formData.append('address', $('#address').val())
        }
        if (stored_password !== $('#password').val()) {
            if ($('#password').val() !== '') {
                formData.append('password', $('#password').val())
            }
        }
        if (stored_zipcode !== $('#zipcode').val()) {
            formData.append('zipcode', $('#zipcode').val())
        }
        if (stored_city !== $('#city').val()) {
            formData.append('city', $('#city').val())
        }
        if (stored_phonenumber !== $('#phonenumber').val()) {
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
        }
        if (stored_info !== $('#info').val()) {
            formData.append('info', $('#info').val())
        }
        if (error < 1) {
            if (formData) {
                $.ajax({
                    url: '/controllers/profile/profile_contact_save.php?id=<?php echo $id;?>',
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (data) {
                        $loading.hide();
                        data = JSON.parse(data);

                        if (data.status === 'success') {
                            window.location.reload();
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


    $('#back_button').on('click', function () {
        $('#profile_contact').load('/controllers/profile/profile_contact_single.php?id=<?php echo $user->data['id']; ?>', function () {
        });
    });

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    };
</script>

<?php
/*Page Info*/
$page = 'Nieuw prospect';
$type = 'customerbase';
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
$usertheme = new User();

/*Classes*/
$user = new User();
$prospect = new Company();
//

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
        <div class="p-0 col-12 col-xl-9 pr-xl-4 mb-4">
            <div class="card shadow" id="prospect_info">
                <div class="card-header border-0 bg-white rounded-top p-3">
                    <div class="row px-4 align-items-center justify-content-between">
                        <ol class="breadcrumb bg-white m-0 p-0">
                            <li class="breadcrumb-item active">Nieuw prospect</li>
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
                    <div class="card shadow " id="prospect_contact">
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
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fad fa-sign"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Prospectsnaam"
                                                       aria-label="Prospectsnaam" id="name" required>
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class="fad fa-phone-office"></i></span>
                                                </div>
                                                <input type="tel" class="form-control" placeholder="Telefoonnummer"
                                                       aria-label="Telefoonnummer" id="phonenumber" name="tel">
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fad fa-at"></i></span>
                                                </div>
                                                <input type="email" class="form-control" placeholder="Email"
                                                       aria-label="Email" id="email" name="email">
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fad fa-road"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Adres"
                                                       aria-label="Adres" id="address">
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fad fa-map"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Postcode"
                                                       aria-label="Postcode"
                                                       id="zipcode">
                                            </div>
                                        </li>
                                        <li class="list-group-item p-0 py-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fad fa-city"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Stad"
                                                       aria-label="Stad" id="city">
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
            url: '/controllers/tables/prospect/prospect_save.php', //Your form processing file URL
            data: {
                text: tinymce.get('input_data').getContent(),
                name: $('#name').val(),
                phonenumber: $('#phonenumber').val(),
                email: $('#email').val(),
                address: $('#address').val(),
                zipcode: $('#zipcode').val(),
                city: $('#city').val(),
            }, //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    window.location.href = '/prospects';
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
</script>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/prospect.js"></script>
<script src="/assets/js/dashboard/tables/prospect/prospects.js"></script>

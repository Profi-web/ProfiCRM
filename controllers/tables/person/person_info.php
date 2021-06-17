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

$person = new Person($id);


$loginValidate = new validateLogin();
$loginValidate->securityCheck();
$usertheme = new User();
//
?>
<div class="card-header border-0 bg-white rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <ol class="breadcrumb bg-white m-0 p-0">
            <li class="breadcrumb-item"><a href="../../../index.php">Contacten</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $person->getData('name'); ?></li>
        </ol>
    </div>
</div>
<div class="container-fluid  bg-light-second py-3 rounded-bottom">
    <div class="row p-3">
        <div class="col-12">
            <div class="w-100 alert_field"></div>
            <div class="text-primary pb-3">Informatie</div>
            <textarea rows="35" id="input_data"><?php echo nl2br($person->getData('info')); ?></textarea>
            <div class="row justify-content-between mt-2 px-3">
                <a class="btn btn-dark text-white rounded mr-2" id="back_info">Terug</a>
                <a class="btn btn-success text-white rounded" id="save_data_info">Opslaan</a>
            </div>
        </div>

    </div>
</div>
</div>
<script>
    $(document).ready(function () {
        tinymce.remove();
        tinymce.init({
            plugins: "autolink link",
            selector: '#input_data',
            branding: false,
            body_class: "rounded bg-white text-dark",
            mobile: {
                theme: 'silver'
            },
            menubar: false,
            relative_urls: true,
            forced_root_block: "",
            paste_data_images: true,
            invalid_elements: "script,img,iframe",
            toolbar: " redo | undo | bold | italic | link | unlink",
            default_link_target: "_blank",
        });
        tinymce.triggerSave();


    });


    $('#back_info').on('click', function () {
        $('#person_info').load('/controllers/tables/person/person_info_single.php?id=<?php echo $id;?>', function () {

        });
    });

    $('#save_data_info').on('click', function (event) {

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/person/person_info_save.php?id=<?php echo $id;?>', //Your form processing file URL
            data: {text: tinymce.get('input_data').getContent()}, //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#person_info').load('/controllers/tables/person/person_info_single.php?id=<?php echo $id;?>', function () {

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
</script>

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
$usertheme = new User();
$procedure = new Procedure($id);
$usertheme = new User();

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

//
?>
<div class="card-header border-0 bg-white rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <ol class="breadcrumb bg-white m-0 p-0">
            <li class="breadcrumb-item"><a href="../../../index.php">Procedures</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $procedure->getData('title'); ?></li>
        </ol>
    </div>
</div>
<div class="container-fluid  bg-light-second py-3 rounded-bottom">
    <div class="row p-3">
        <div class="col-12">
            <div class="w-100 alert_field"></div>
            <div class="text-primary pb-3">Informatie</div>
            <textarea rows="35" id="input_data"><?php echo nl2br($procedure->getData('text')); ?></textarea>
            <div class="row justify-content-between mt-2 px-3">
                <a class="btn btn-dark text-white rounded mr-2" id="info_back">Terug</a>
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
            selector: '#input_data',
            menubar: false,
            branding: false,
            body_class: "rounded",
            mobile: {
                theme: 'silver'
            },
            forced_root_block: "",
            paste_data_images: true,
            invalid_elements : "script,img,iframe",
            toolbar: " redo | undo | bold | italic | ",
            remove_linebreaks : false
        });
        tinymce.triggerSave();
        });

    $('#info_back').on('click',function () {
        $('#procedures_info').load('/controllers/tables/procedure/procedures_info_single.php?id=<?php echo $procedure->getData('id') ?>', function () {
        });
    });

    tinymce.triggerSave();
        $('#save_data_info').on('click', function (event) {
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/procedure/procedures_info_save.php?id=<?php echo $id;?>', //Your form processing file URL
            data: {text: tinymce.get('input_data').getContent()}, //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#procedures_info').load('/controllers/tables/procedure/procedures_info_single.php?id=<?php echo $procedure->getData('id') ?>', function () {
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

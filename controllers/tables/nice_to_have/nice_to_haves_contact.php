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

$nice_to_haves = new Nice_to_have($id);


$loginValidate = new validateLogin();
$loginValidate->securityCheck();
//
?>
<form class="p-0 m-0" id="nice_to_haves_contact_form" novalidate>
    <div class="card-header border-0 bg-light-second rounded-top p-3">
        <div class="row px-4 align-items-center justify-content-between">
            <div>Gegevens</div>
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
                            <input type="tel" class="form-control" placeholder="Titel" aria-label="Titel"
                                   id="title" value="<?php echo $nice_to_haves->getData('title'); ?>" required>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <label>Status</label>
                        <div class="input-group">
                            <select class="custom-select rounded" id="status" name="status">
                                <option <?php if ($nice_to_haves->getData('status') == '1') {
                                    echo 'selected';
                                } ?> value="1">Open
                                </option>
                                <option <?php if ($nice_to_haves->getData('status') == '2') {
                                    echo 'selected';
                                } ?> value="2">Uitgevoerd
                                </option>
                            </select>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <label>Prioriteit</label>
                        <div class="input-group">
                            <select class="custom-select rounded" id="priority" name="priority">
                                <option <?php if ($nice_to_haves->getData('priority') == '1') {
                                    echo 'selected';
                                } ?> value="1">Laag
                                </option>
                                <option <?php if ($nice_to_haves->getData('priority') == '2') {
                                    echo 'selected';
                                } ?> value="2">Middel
                                </option>
                                <option <?php if ($nice_to_haves->getData('priority') == '3') {
                                    echo 'selected';
                                } ?> value="3">Hoog
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
            <button class="btn btn-success text-white rounded" id="save_data_contact" type="submit">Opslaan</button>
        </div>
    </div>
</form>
<script>
    $('#back_contact').on('click', function () {
        $('#nice_to_haves_contact').load('/controllers/tables/nice_to_have/nice_to_haves_contact_single.php?id=<?php echo $id; ?>', function () {
        });
    });
    $('#nice_to_haves_contact_form').submit(function (event) {
        if ($('#title').val() === '') {
            $('#title').addClass('is-invalid');
        } else {
            $('#title').removeClass('is-invalid');
        }

        if ($('#status').val() === '') {
            $('#status').addClass('is-invalid');
        } else {
            $('#status').removeClass('is-invalid');
        }


        if ($('#priority').val() === '') {
            $('#priority').addClass('is-invalid');
        } else {
            $('#priority').removeClass('is-invalid');
        }


        event.preventDefault();
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/nice_to_have/nice_to_haves_contact_save.php?id=<?php echo $id;?>', //Your form processing file URL
            data: {
                title: $('#title').val(),
                priority: $('#priority').val(),
                status: $('#status').val()
            }
            , //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#nice_to_haves_contact').load('/controllers/tables/nice_to_have/nice_to_haves_contact_single.php?id=<?php echo $id; ?>', function () {
                    });
                    $('#nice_to_haves_info').load('/controllers/tables/nice_to_have/nice_to_haves_info_single.php?id=<?php echo $nice_to_haves->getData('id') ?>', function () {
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

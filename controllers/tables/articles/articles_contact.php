<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];
} else {
//    header('Location: /404');
}
/**/

$article = new Article($id);


$loginValidate = new validateLogin();
$loginValidate->securityCheck();
//
?>
<form class="p-0 m-0" id="article_contact_form" novalidate>
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
                                <span class="input-group-text"><i class="fad fa-info-circle"></i></span>
                            </div>
                            <input type="tel" class="form-control" placeholder="Onderwerp" aria-label="Onderwerp"
                                   id="name" value="<?php echo $article->getData('name'); ?>" required>
                        </div>
                    </li>
                    <li class="list-group-item p-0 py-2">
                        <div class="input-group date" id="date" data-target-input="nearest">
                            <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fad fa-calendar-alt pl-1"></i></div>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" data-target="#date"
                                   placeholder="Kies een datum en tijd"
                                   value="<?php echo $article->getData('date'); ?>"/>
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
        $('#article_contact').load('/controllers/tables/articles/articles_contact_single.php?id=<?php echo $id; ?>', function () {
        });
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
            format: 'L'
        });
    });
    $('#article_contact_form').submit(function (event) {
        if ($('#name').val() === '') {
            $('#name').addClass('is-invalid');
        } else {
            $('#name').removeClass('is-invalid');
        }


        if ($('#date input').val() == '') {
            $('#date input').addClass('is-invalid');
        } else {
            $('#date input').removeClass('is-invalid');
        }



        event.preventDefault();
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/articles/articles_contact_save.php?id=<?php echo $id;?>', //Your form processing file URL
            data: {
                name: $('#name').val(),
                date: $('#date input').val(),
            }
            , //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#article_contact').load('/controllers/tables/articles/articles_contact_single.php?id=<?php echo $id; ?>', function () {
                    });
                    $('#article_info').load('/controllers/tables/articles/articles_info_single.php?id=<?php echo $article->getData('id') ?>', function () {
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

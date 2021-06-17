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
//
?>
<form class="p-0 m-0" id="person_contact_form" novalidate>
    <div class="card-header border-0 bg-light-second rounded-top p-3">
        <div class="row px-4 align-items-center justify-content-between">
            <div>Relaties</div>
            <a class="btn btn-dark rounded text-white btn-sm" id="back_relation">Terug</a>
        </div>
    </div>
    <div class="container-fluid px-4 py-2 rounded-bottom rounded-top">
        <div class="alert_field_relations pt-2">
        </div>
        <div class="row">
            <div class="col-12 ">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <ul class="list-group list-group-flush w-100">
                            <li class="list-group-item p-0 py-2">
                                <label>Relatie</label>
                                <div class="input-group">
                                    <input type="text" class="form-control rounded relation_search"
                                           placeholder="Typ om te zoeken.."
                                           aria-label="Typ om te zoeken.."
                                           name="foo" autocomplete="off">
                                    <input type="hidden" id="relation_id"/>
                                    <input type="hidden" id="relation_type"/>
                                    <div class="invalid-feedback">
                                        Vul a.u.b een geldige keuze in
                                    </div>
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
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row px-4 justify-content-end">
            <a class="btn btn-success btn-sm text-white rounded save_relation"
               id="<?php echo $person->getData('id'); ?>">Toevoegen</a>
        </div>

    </div>
</form>
<script>
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

            $.get("/controllers/search/contact_relation_search_person.php", {term: inputVal,relation:'<?php echo $id;?>'}).done(function (data) {
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


    $('#back_relation').on('click', function (event) {
        $('#person_relation').load('/controllers/tables/person/person_relations.php?id=<?php echo $person->getData('id') ?>', function () {
        });
    });
    $('.save_relation').on('click', function () {

        if ($('.relation_search').val() !== '') {
            $('.relation_search').removeClass('is-invalid');
            $('.relation_search').addClass('is-valid');
        }

        if(!$('.relation_search').val()) {
            $('#relation_id').val('');
            $('#relation_type').val('');
            $('.relation_search').addClass('is-invalid');
        } else {
            $('.relation_search').removeClass('is-invalid');
            $('.relation_search').addClass('is-valid');
        }

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/person/person_relations_save.php', //Your form processing file URL
            data: {
                person: $('.save_relation').attr('id'),
                relation: $('#relation_id').val(),
                type: $('#relation_type').val(),
            }
            , //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#person_relation').load('/controllers/tables/person/person_relations.php?id=' + $('.save_relation').attr('id'), function () {
                    });
                } else {
                    $(".alert_field_relations").load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });
    });

    $('.delete').on('click', function (event) {
        var current = $(this);
        event.preventDefault();
        alertify.confirm('Verwijderen', "Weet je zeker dat je deze relatie wilt verwijderen?",
            function () {
                $.ajax({ //Process the form using $.ajax()
                    type: 'POST', //Method type
                    url: '/controllers/tables/person/person_relations_delete.php?id=<?php echo $id;?>', //Your form processing file URL
                    data: {
                        id: current.attr('id'),
                    }
                    , //Forms name
                    success: function (data) {
                        data = JSON.parse(data);

                        if (data.status === 'success') {
                            window.location.reload();
                        } else {
                            $(".alert_field_relation").load("/controllers/error.php", {
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

</script>

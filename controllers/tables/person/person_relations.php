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
        <div class="alert_field_relation">
        </div>
        <div class="row">
            <div class="col-12 ">
                <div class="container-fluid">
                    <div class="row relations_edit">
                        <?php
                        $person->showEditRelations($id);
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row px-4 justify-content-end">
            <a class="btn btn-success btn-sm text-white rounded new_relation"
               id="<?php echo $person->getData('id'); ?>">Nieuwe relatie</a>
        </div>

    </div>
</form>
<script>
    $('#back_relation').on('click', function (event) {
        $('#person_relation').load('/controllers/tables/person/person_relation_single.php?id=<?php echo $person->getData('id') ?>', function () {
        });
    });
    $('.new_relation').on('click', function (event) {
        event.preventDefault();
        var id = $(this).attr('id');
        $('#person_relation').load('/controllers/tables/person/person_relations_new.php?id=' + id, function () {
        });
    });

    $('.delete').on('click', function (event) {
        var current = $(this);
        event.preventDefault();
        alertify.confirm('Verwijderen',"Weet je zeker dat je deze relatie wilt verwijderen?",
            function(){
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
                            $('#person_relation').load('/controllers/tables/person/person_relations.php?id=<?php echo $id;?>', function () {
                            });
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
            function(){
            });

    });

</script>

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
?>
<div class="card-header border-0 bg-light-second rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <div>Relaties</div>
        <a class="btn btn-info rounded text-white btn-sm trigger_relations"
           id="<?php echo $person->getData('id'); ?>">Bewerken</a>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 px-4 py-2">
            <div class="container-fluid">
                <div class="row relations mb-2">
                    <?php
                    $person->showRelations($id);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.trigger_relations').on('click', function () {
        var id = $(this).attr('id');
        $('#person_relation').load('/controllers/tables/person/person_relations.php?id=' + id, function () {
        });
    });
</script>

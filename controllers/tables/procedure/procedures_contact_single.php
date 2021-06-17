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

$procedures = new Procedure($id);


$loginValidate = new validateLogin();
$loginValidate->securityCheck();
//
?>
<div class="card-header border-0 bg-light-second rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <div>Gegevens</div>
        <a class="btn btn-info rounded text-white btn-sm trigger_contact"
           id="<?php echo $procedures->getData('id'); ?>">Bewerken</a>
    </div>
</div>
<div class="container-fluid p-4 rounded-bottom rounded-top">
    <div class="row">
        <div class="col-12 ">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i
                            class="fad fa-sign"></i> <?php echo $procedures->getData('title'); ?>
                </li>
            </ul>

        </div>
    </div>
</div>
<script>
    $('.trigger_contact').on('click', function () {
        $('#procedures_contact').load('/controllers/tables/procedure/procedures_contact.php?id=<?php echo $id; ?>', function () {
        });
    });
</script>

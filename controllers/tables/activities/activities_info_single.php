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

$activity = new Activity($id);


$loginValidate = new validateLogin();
$loginValidate->securityCheck();
//
?>
<div class="card-header border-0 bg-white rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <ol class="breadcrumb bg-white m-0 p-0">
            <li class="breadcrumb-item"><a href="/taken">Taken</a></li>
            <li class="breadcrumb-item active"
                aria-current="page">#<?php echo $activity->getData('id'); ?></li>
        </ol>
        <a class="btn btn-info rounded text-white btn-sm trigger_info"
           id="<?php echo $activity->getData('id'); ?>">Bewerken</a>
    </div>
</div>
<div class="container-fluid  bg-light-second py-3 rounded-bottom">
    <div class="row p-3">
        <div class="col-12">
            <div class="text-primary pb-3">Informatie</div>
            <div class="bg-white p-3 rounded">
                <?php echo nl2br($activity->getData('text')); ?>
            </div>

        </div>
    </div>
</div>
<script>
    $('.trigger_info').on('click', function () {
        $('#activity_info').load('/controllers/tables/activities/activities_info.php?id=<?php echo $id; ?>', function () {
        });
    });
</script>

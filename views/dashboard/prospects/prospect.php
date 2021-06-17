<?php
/*Page Info*/
$page = 'Prospect';
$type = 'customerbase';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

$pagination = 1;
if (isset($_GET['page'])) {
    $pagination = $_GET['page'];
}

$paginationOrders = 1;
if (isset($_GET['pageOrders'])) {
    $paginationOrders = $_GET['pageOrders'];
}

/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: /404');
}
/**/


/*Classes*/
$user = new User();
$prospect = new Prospect($id);
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
            <div class="card shadow" id="prospect_tasks" style="min-height: 100px;" data-page="<?php echo $pagination;?>">

            </div>

<!--            <div class="card shadow  mt-4" id="prospect_info" style="min-height: 100px;">-->
<!---->
<!--            </div>-->

        </div>
        <div class="col-12 col-xl-3 pl-md-3 pr-md-3">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="card shadow "id="prospect_contact" style="min-height: 404px;">

                    </div>
                </div>
                <?php
                if (!empty(trim($prospect->getData('address')))) {
                    ?>
                    <div class="col-12 p-0">
                        <div class="card shadow mt-4">
                            <div class="card-header border-0 bg-light-second rounded-top p-3">
                                <div class="row px-4 align-items-center justify-content-between">
                                    <div>Locatie</div>
                                </div>
                            </div>
                            <iframe class="rounded-bottom" width="100%" height="300"
                                    src="https://maps.google.com/maps?width=100%&height=600&hl=nl&q=<?php echo $prospect->getData('address', true) . '%20' . $prospect->getData('zipcode'); ?>&ie=UTF8&t=&z=14&iwloc=B&output=embed"
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="col-12 p-0">
                    <div class="card shadow mt-4">
                        <div class="card-header border-0 bg-light-second rounded-top p-3">
                            <div class="row px-4 align-items-center justify-content-between">
                                <div>Opties</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <a class="btn btn-danger text-white rounded btn-sm delete_prospect" id="<?php echo $prospect->getData('id') ?>"> Verwijderen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bottom_notes">Profi-crm versie <?php $versions = new Versions(); echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/prospect.js"></script>
<script src="/assets/js/dashboard/tables/prospects.js"></script>
<script>
    $(document).ready(function () {
        $('#prospect_contact').load('/controllers/tables/prospect/prospect_contact_single.php?id=<?php echo $prospect->getData('id') ?>', function () {
        });

        //$('#prospect_info').load('/controllers/tables/prospect/prospect_info_single.php?id=<?php //echo $prospect->getData('id') ?>//', function () {
        //});
        var page = $('#prospect_tasks').data('page');
        $('#prospect_tasks').load('/controllers/tables/prospect/prospect_activities.php?id=<?php echo $prospect->getData('id') ?>&page='+page, function () {
        });
    });
</script>
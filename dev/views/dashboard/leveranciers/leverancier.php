<?php
/*Page Info*/
$page = 'Leverancier';
$type = 'customerbase';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/


$pagination = 1;
if (isset($_GET['page'])) {
    $pagination = $_GET['page'];
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
$supplier = new Supplier($id);
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
            <div class="card shadow" id="supplier_info" style="min-height: 100px">

            </div>
            <div class="card shadow mt-4" id="supplier_tasks" style="min-height: 100px;" data-page="<?php echo $pagination; ?>">
            </div>
        </div>
        <div class="col-12 col-xl-3 pl-md-3 pr-md-3">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="card shadow " id="trigger_contact" style="min-height: 404px">

                    </div>
                </div>
                <?php
                if (!empty(trim($supplier->getData('address')))) {
                    ?>
                    <div class="col-12 p-0">
                        <div class="card shadow mt-4">
                            <div class="card-header border-0 bg-light-second rounded-top p-3">
                                <div class="row px-4 align-items-center justify-content-between">
                                    <div>Locatie</div>
                                </div>
                            </div>
                            <iframe class="rounded-bottom" width="100%" height="300"
                                    src="https://maps.google.com/maps?width=100%&height=600&hl=nl&q=<?php echo $supplier->getData('address', true) . '%20' . $supplier->getData('zipcode'); ?>&ie=UTF8&t=&z=14&iwloc=B&output=embed"
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
                            <a class="btn btn-danger text-white rounded btn-sm delete_supplier"
                               id="<?php echo $supplier->getData('id') ?>"> Verwijderen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bottom_notes">Profi-crm versie <?php $versions = new Versions();
    echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/supplier.js"></script>
<script src="/assets/js/dashboard/tables/suppliers.js"></script>
<script>
    $(document).ready(function () {
        $('#supplier_info').load('/controllers/tables/supplier/supplier_info_single.php?id=<?php echo $supplier->getData('id') ?>', function () {
        });

        $('#trigger_contact').load('/controllers/tables/supplier/supplier_contact_single.php?id=<?php echo $supplier->getData('id') ?>', function () {
        });

        var page = $('#supplier_tasks').data('page');
        $('#supplier_tasks').load('/controllers/tables/supplier/supplier_activities.php?id=<?php echo $supplier->getData('id') ?>&page=' + page, function () {
        });
    });
</script>
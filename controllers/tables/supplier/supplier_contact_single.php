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

$supplier = new Supplier($id);


$loginValidate = new validateLogin();
$loginValidate->securityCheck();
//
?>
<div class="card-header border-0 bg-light-second rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <div>Contactgegevens</div>
        <a class="btn btn-info rounded text-white btn-sm trigger_supplier"
           id="<?php echo $supplier->getData('id'); ?>">Bewerken</a>
    </div>
</div>
<div class="container-fluid p-4 rounded-bottom rounded-top">
    <div class="row">
        <div class="col-12 ">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i
                        class="fad fa-sign"></i> <?php echo $supplier->getData('name'); ?>
                </li>
                <li class="list-group-item"><i
                        class="fad fa-phone-office"></i> <?php echo $supplier->getData('phonenumber'); ?>
                </li>
                <li class="list-group-item"><i
                        class="fad fa-at"></i> <?php echo $supplier->getData('email'); ?>
                </li>
                <li class="list-group-item"><i
                        class="fad fa-road"></i> <?php echo $supplier->getData('address'); ?>
                </li>
                <li class="list-group-item"><i
                        class="fad fa-map"></i> <?php echo $supplier->getData('zipcode'); ?>
                </li>
                <li class="list-group-item"><i
                        class="fad fa-city"></i> <?php echo $supplier->getData('city') ?>
                </li>
            </ul>

        </div>
    </div>
</div>
<script>
    $('.trigger_supplier').on('click', function () {
        var id = $(this).attr('id');
        $('#trigger_contact').load('/controllers/tables/supplier/supplier_contact.php?id=' + id, function () {
        });
    });
</script>

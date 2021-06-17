<?php


/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: /404');
}
/**/

$prospect = new Prospect($id);


$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();
//
?>
<div class="card-header border-0 bg-light-second rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <div>Contactgegevens</div>
        <a class="btn btn-info rounded text-white btn-sm trigger_contact"
           id="<?php echo $prospect->getData('id'); ?>">Bewerken</a>
    </div>
</div>
<div class="container-fluid p-4 rounded-bottom rounded-top">
    <div class="row">
        <div class="col-12 ">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i
                            class="fad fa-sign"></i> <?php echo $prospect->getDataLine('name'); ?>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-phone-office"></i> <?php echo $prospect->getDataLine('phonenumber'); ?>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-at"></i> <?php echo $prospect->getDataLine('email'); ?>
                </li>
                <li class="list-group-item"><a class="text-dark" target="_blank" href="<?php echo $prospect->getDataLine('website'); ?>"><i
                                class="fad fa-browser"></i> <?php echo $prospect->getDataLine('website'); ?></a>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-user"></i> <?php echo $prospect->getDataLine('contactpersoon'); ?>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-road"></i> <?php echo $prospect->getDataLine('address'); ?>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-map"></i> <?php echo $prospect->getDataLine('zipcode'); ?>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-city"></i> <?php echo $prospect->getDataLine('city') ?>
                </li>
                <li class="list-group-item"><i
                            class="fad fa-cabinet-filing"></i> <?php echo $prospect->getDataLine('kvk') ?>
                </li>
            </ul>

        </div>
    </div>
</div>
<script>
    $('.trigger_contact').on('click', function () {
        $('#prospect_contact').load('/controllers/tables/prospect/prospect_contact.php?id=<?php echo $id; ?>', function () {
        });
    });
</script>

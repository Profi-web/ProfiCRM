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

$company = new Company($id);


$loginValidate = new validateLogin();
$loginValidate->securityCheck();
/**/
?>

<div class="card-header border-0 bg-light-second rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <div>Locatie</div>
    </div>
</div>
<iframe class="rounded-bottom" width="100%" height="300"
        src="https://maps.google.com/maps?width=100%&height=600&hl=nl&q=<?php echo $company->getData('address', true) . '%20' . $company->getData('zipcode'); ?>&ie=UTF8&t=&z=14&iwloc=B&output=embed"
        frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>

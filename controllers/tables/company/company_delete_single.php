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
        <div>Opties</div>
    </div>
</div>
<div class="card-body">
    <a class="btn btn-danger text-white rounded btn-sm delete_company"
       id="<?php echo $company->getData('id') ?>"> Verwijderen</a>
</div>

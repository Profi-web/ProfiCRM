<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];

    /*Classes*/
    $user = new User($id);
    $profile_id = $id;
//
}  else {
    /*Classes*/
    $user = new User();
    $profile_id = $user->data['id'];
//
}

//$company = new Company($id);


$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();
//

if($user->data['picture']){
    $image = $user->data['picture'];
} else {
    $image = 'placeholder.png';
}

?>
<div class="card-header bg-white border-0  rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-center">
        <img src="/uploads/picture/<?php echo $image;?>" class="rounded-circle profile_image" width="200px"
             height="200px" style="object-fit: cover"/>

    </div>
</div>
<div class="container-fluid pb-4 pt-2 rounded-bottom rounded-top">
    <div class="row">
        <div class="col-12 justify-content-center">
            <h3 class="text-center pt-0"><?php echo $user->data['name'];?></h3>
            <h5 class="text-muted text-center p-0 font-weight-light"><?php echo $user->getRole();?></h5>
            <hr class="w-75">
            <p class="text-center px-5 text-muted">
                <?php echo $user->data['info'];?>
            </p>
        </div>
    </div>
</div>

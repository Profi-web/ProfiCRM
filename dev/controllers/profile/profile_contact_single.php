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
    $id = $user->data['id'];
//
}

//$company = new Company($id);


$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();
//
?>
<div class="card-header border-0 bg-light-second rounded-top p-3">
    <div class="row px-4 align-items-center justify-content-between">
        <div>Contactgegevens</div>
        <a class="btn btn-info rounded text-white btn-sm trigger_profile"
           id="">Bewerken</a>
    </div>
</div>
<div class="container-fluid p-4 rounded-bottom rounded-top">
    <div class="row">
        <div class="col-12 ">
            <div class="alert_field"></div>
            <form id="profile_info">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Naam</label>
                        <input type="text" class="form-control" id="name" placeholder="Naam"
                               value="<?php echo $user->data['name'];?>" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="position">Positie</label>
                        <input type="text" class="form-control" id="position" value="<?php echo $user->getRole();?>"
                               readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $user->data['email'];?>" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Wachtwoord</label>
                        <input type="password" class="form-control" id="password" placeholder="**********"
                               readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Adres</label>
                    <input type="text" class="form-control" id="address" value="<?php echo $user->data['address'];?>" readonly>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="zipcode">Postcode</label>
                        <input type="text" class="form-control" id="zipcode" readonly value="<?php echo $user->data['zipcode'];?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="city">Stad</label>
                        <input type="text" class="form-control" id="city" readonly value="<?php echo $user->data['city'];?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phonenumber">Telefoonnummer</label>
                        <input type="text" class="form-control" id="phonenumber" readonly value="<?php echo $user->data['phonenumber'];?>">
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    $('.trigger_profile').on('click', function () {
        $('#profile_contact').load('/controllers/profile/profile_contact.php?id=<?php echo $id; ?>', function () {
        });
    });
</script>
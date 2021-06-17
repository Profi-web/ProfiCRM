<?php
/*Page Info*/
$page = 'Profiel';
$type = 'profile';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];

    /*Classes*/
    $user = new User('',true);
    $test = new User($id);
    $profile_id = $id;
//
}  else {
    /*Classes*/
    $user = new User();
    $profile_id = $user->data['id'];
//
}

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
    <div class="row px-3 px-md-5">
        <div class="col-12 col-lg-8 pl-0 pl-lg-0 mt-4 mt-lg-0 order-last order-lg-first mb-md-4">
            <div class="card shadow col-12 p-0" id="profile_contact" style="min-height: 100px">

            </div>
        </div>

        <div class="col-12 col-lg-4 pl-0 pl-lg-0 mt-lg-0 ">
            <div class="card shadow col-12 p-0 order-first order-lg-last" id="profile_info" style="min-height: 200px">

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
<script>


    $('#profile_contact').load('/controllers/profile/profile_contact_single.php?id=<?php echo $profile_id; ?>', function () {
    });

    $('#profile_info').load('/controllers/profile/profile_info_single.php?id=<?php echo $profile_id; ?>', function () {
    });
</script>
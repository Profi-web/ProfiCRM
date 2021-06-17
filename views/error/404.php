<?php
/*Page Info*/
$page = 'Pagina niet gevonden';
//$type ='profile';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
//

/*Classes*/
$user = new User();
/**/

/*CSS*/
?>
<link rel="stylesheet" href="/assets/css/dashboard.min.css">
<?php
//

/*Header*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/header.php';
/**/
?>
<!--    HEADER-->
<div class="container-fluid px-3 px-md-5 mb-5" style="margin-top:-40px;">
    <div class="card shadow p-5 text-center">
        <div class="row justify-content-center align-items-center">
            <img src="/assets/media/bunny.gif" class="p-4 col-8 col-md-4 col-lg-2" style="object-fit: contain"/>
            <div class="font-weight-bold col-12" style="font-size:25px;">De pagina is niet beschikbaar</div>
            <div class="col-12">De link die je volgde is misschien kapot, of de pagina is verwijderd</div>
            <div class="col-12 mt-4">
                <a href="/" class="btn btn-primary">Terug naar dashboard</a>
            </div>
        </div>
    </div>
</div>
<?php
/*Footer*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php';
/**/
?>
<script src="/assets/js/dashboard/main.js"></script>

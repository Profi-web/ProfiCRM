<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';

$gradient = 1;

require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <a class="row justify-content-center" href="/">
                        <img src="/assets/media/logo_black_blue.png" class="w-75 pt-3 pb-5" style="object-fit: contain"
                             height="100">
                    </a>
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center mt-0 text-center">
                            <img src="/assets/media/bunny.gif" class="col-6"/>
                            <div class="font-weight-bold col-12" style="font-size:25px;">2De pagina is niet beschikbaar
                            </div>
                            <div class="col-12">De link die je volgde is misschien kapot, of de pagina is verwijderd
                            </div>
                            <div class="col-12 mt-4 justify-content-center row">
                                <a href="/" class="btn btn-primary">Terug naar inlogscherm</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';

$gradient = 1;

require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-6 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <a class="row justify-content-center" href="/">
                        <img src="/assets/media/logo_black_blue.png" class="w-75 pt-3 pb-5" style="object-fit: contain"
                             height="100">
                    </a>
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center mt-0 text-center">
                            <img src="/assets/media/bun.gif" class="col-5"/>
                            <div class="font-weight-bold col-12" style="font-size:22px;">We zijn momenteel in onderhoud!
                            </div>
                            <div class="col-12">Willem Nijn rent zo snel als hij kan! Kijk straks nog eens!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>

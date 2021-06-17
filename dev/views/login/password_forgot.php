<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';

$user = new User(1);
$gradient = 1;
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="assets/media/logo_black_blue.png" class="w-75 pt-3 pb-5" style="object-fit: contain" height="100">
                    </div>
                    <h5 class="text-center" style="margin-top:-30px;" class="mb-1">Wachtwoord vergeten</h5>
                    <form class="form-signin needs-validation" novalidate>
                        <div class="alert_field"></div>
                        <div class="text-center mb-3">
                            <img src="/assets/media/bun.gif" width="50px" height="50px" class="spinner"/>
                        </div>

                        <div class="form-label-group">
                            <input type="email" id="inputEmail" class="form-control" placeholder="Email address"
                                   required autofocus name="email">
                            <div class="invalid-feedback px-3">
                                Vul aub een geldige email in
                            </div>
                            <label for="inputEmail">Email</label>
                        </div>

                        <button class="btn btn-lg btn-primary btn-block" type="submit">Aanvragen</button>
                        <hr class="my-4">

                    </form>
                    <div class="container">
                        <div class="row justify-content-center">
                            <a class="text-center op-50 w-100 font-italic" href="/">Terug</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script src="/assets/js/login/forgot.js"></script>
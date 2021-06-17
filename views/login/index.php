<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';

$loginError = new loginError();
$gradient = 1;

$loginError->check();
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <a class="row justify-content-center" href="/">
                            <img src="/assets/media/logo_black_blue.png" class="w-75 pt-3 pb-5" style="object-fit: contain" height="100">
                        </a>
                        <form class="form-signin needs-validation" novalidate>
                            <div class="alert_field">
                                <?php
                                    $loginError->showError();
                                ?>
                            </div>
                            <div class="text-center mb-3">
                                <img src="/assets/media/bun.gif" width="50px" height="50px" class="spinner" style="display: none;"/>
                            </div>
                            <div class="form-label-group">
                                <input type="email" id="inputEmail" class="form-control" placeholder="Email address"
                                       required autofocus name="email">
                                <div class="invalid-feedback px-3">
                                    Vul aub een geldige email in
                                </div>
                                <label for="inputEmail">Email</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="inputPassword" class="form-control" placeholder="Password"
                                       required name="password">
                                <div class="invalid-feedback px-3">
                                    Vul aub een geldig wachtwoord in
                                </div>
                                <label for="inputPassword">Wachtwoord</label>
                            </div>

                            <div class="custom-control custom-checkbox mb-3 mx-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" name="check" value="1">
                                <label class="custom-control-label" for="customCheck1">Wachtwoord onthouden</label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Inloggen</button>
                            <hr class="my-4">

                        </form>
                        <div class="container">
                            <div class="row justify-content-center">
                                <a class="text-center op-50 w-100 font-italic" href="/wachtwoord-vergeten">Wachtwoord
                                    vergeten?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script src="/assets/js/login/main.js"></script>
<script src="/assets/js/login/login.js"></script>
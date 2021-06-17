<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/core/init.php';

$user = new User(1);
$gradient = 1;

$resetcheck = new resetCheck($_GET['key']);


require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <img src="assets/media/logo_black_blue.png" class="w-75 pt-3 pb-5" style="object-fit: contain" height="100">
                    </div>
                    <h5 class="text-center" style="margin-top:-30px;" class="mb-1">Wachtwoord herstellen</h5>
                    <?php
                    if($resetcheck->validate()) {
                        ?>
                        <form class="form-signin needs-validation" novalidate>
                            <div class="alert_field"></div>
                            <div class="text-center mb-3">
                                <img src="/assets/media/bun.gif" width="50px" height="50px" class="spinner"/>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="inputPassword" class="form-control" placeholder="Wachtwoord"
                                       required autofocus name="password">
                                <div class="invalid-feedback px-3">
                                    Vul aub een geldige wachtwoord in
                                </div>
                                <label for="inputPassword">Wachtwoord</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" id="inputPassword1" class="form-control"
                                       placeholder="Wachtwoord nogmaals"
                                       required autofocus name="password1">
                                <div class="invalid-feedback px-3">
                                    Vul aub een geldige wachtwoord in
                                </div>
                                <label for="inputPassword1">Wachtwoord nogmaals</label>
                            </div>
                            <input type="hidden" value="<?php echo $_GET['key']?>" name="key">

                            <button class="btn btn-lg btn-primary btn-block" type="submit">Herstellen</button>
                            <hr class="my-4">

                        </form>
                        <?php
                    } else {
                        ?>
                    <div class="text-center">Code is verlopen of niet geldig</div>
                        <hr class="my-4">
                    <?php
                    }
                    ?>
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
<script src="/assets/js/login/reset.js"></script>
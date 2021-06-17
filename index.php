<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';

$validateLogin = new validateLogin();
$config = new Config();

$company = new Company();

if ($validateLogin->validate()) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}


$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

if ($config->getMaintenance() == 1) {
    require_once __DIR__ . '/views/error/maintenance.php';
    exit();
}
if (!$loggedIn) {
    switch ($request_uri[0]) {
        case '/' :
            require_once __DIR__ . '/views/login/index.php';
            break;
        case '' :
            require_once __DIR__ . '/views/login/index.php';
            break;
        case '/wachtwoord-vergeten' :
            require_once __DIR__ . '/views/login/password_forgot.php';
            break;
        case '/wachtwoord-herstellen' :
            require_once __DIR__ . '/views/login/password_reset.php';
            break;
        case '/404' :
            require_once __DIR__ . '/views/error/404pagee.php';
            break;
        default:
            require_once __DIR__ . '/views/login/index.php';
            break;
    }
} else {
    $usercheck = new User();
    if ($usercheck->data['role'] == 7) {
        switch ($request_uri[0]) {

            case '/prospects' :
                require_once __DIR__ . '/views/dashboard/prospects/index.php';
                break;
            case '/prospect' :
                require_once __DIR__ . '/views/dashboard/prospects/prospect.php';
                break;
            case '/prospects/nieuw' :
                require_once __DIR__ . '/views/dashboard/prospects/new.php';
                break;

            case '/' :
                require_once __DIR__ . '/views/dashboard/prospects/index.php';
                break;
            case '' :
                require_once __DIR__ . '/views/dashboard/prospects/index.php';
                break;
            case '/logout' :
                require_once __DIR__ . '/controllers/logout/logout.php';
                break;
            case '/darktheme' :
                require_once __DIR__ . '/controllers/theme/dark.php';
                break;
            case '/404' :
                require_once __DIR__ . '/views/error/404.php';
                break;
            default:
                require_once __DIR__ . '/views/error/404.php';
                break;

            case '/profiel' :
                require_once __DIR__ . '/views/dashboard/profile/index.php';
                break;

        }
    } else {
        switch ($request_uri[0]) {
            //Bedrijven
            case '/prospects' :
                require_once __DIR__ . '/views/dashboard/prospects/index.php';
                break;
            case '/prospect' :
                require_once __DIR__ . '/views/dashboard/prospects/prospect.php';
                break;
            case '/prospects/nieuw' :
                require_once __DIR__ . '/views/dashboard/prospects/new.php';
                break;

            case '/darktheme' :
                require_once __DIR__ . '/controllers/theme/dark.php';
                break;
            //Bedrijven
            case '/bedrijven' :
                require_once __DIR__ . '/views/dashboard/bedrijven/index.php';
                break;
            case '/bedrijf' :
                require_once __DIR__ . '/views/dashboard/bedrijven/bedrijf.php';
                break;
            case '/bedrijven/nieuw' :
                require_once __DIR__ . '/views/dashboard/bedrijven/new.php';
                break;

            case '/contacten' :
                require_once __DIR__ . '/views/dashboard/contacten/index.php';
                break;
            case '/contact' :
                require_once __DIR__ . '/views/dashboard/contacten/contact.php';
                break;
            case '/contacten/nieuw' :
                require_once __DIR__ . '/views/dashboard/contacten/new.php';
                break;

            case '/leveranciers' :
                require_once __DIR__ . '/views/dashboard/leveranciers/index.php';
                break;
            case '/leverancier' :
                require_once __DIR__ . '/views/dashboard/leveranciers/leverancier.php';
                break;
            case '/leveranciers/nieuw' :
                require_once __DIR__ . '/views/dashboard/leveranciers/new.php';
                break;

            //Kennisplein
            case '/kennisplein' :
                require_once __DIR__ . '/views/dashboard/kennisplein/index.php';
                break;
            case '/kennisplein/artikel' :
                require_once __DIR__ . '/views/dashboard/kennisplein/artikel.php';
                break;
            case '/kennisplein/nieuw' :
                require_once __DIR__ . '/views/dashboard/kennisplein/new.php';
                break;


            //Changelog
            case '/change-log' :
                require_once __DIR__ . '/views/dashboard/change-log/index.php';
                break;
            case '/change-log/nieuw' :
                require_once __DIR__ . '/views/dashboard/change-log/new.php';
                break;
            //nice-to-haves
            case '/nice-to-haves' :
                require_once __DIR__ . '/views/dashboard/nice-to-haves/index.php';
                break;
            case '/nice-to-haves/item' :
                require_once __DIR__ . '/views/dashboard/nice-to-haves/nice-to-have.php';
                break;
            case '/nice-to-haves/nieuw' :
                require_once __DIR__ . '/views/dashboard/nice-to-haves/new.php';
                break;

            //Procedures
            case '/procedures' :
                require_once __DIR__ . '/views/dashboard/procedures/index.php';
                break;
            case '/procedure' :
                require_once __DIR__ . '/views/dashboard/procedures/procedure.php';
                break;
            case '/procedures/nieuw' :
                require_once __DIR__ . '/views/dashboard/procedures/new.php';
                break;


            case '/acquisitie' :
                require_once __DIR__ . '/views/dashboard/acquisitie/index.php';
                break;

            case '/taken' :
                require_once __DIR__ . '/views/dashboard/taken/index.php';
                break;
            case '/taak' :
                require_once __DIR__ . '/views/dashboard/taken/taak.php';
                break;
            case '/taken/nieuw' :
                require_once __DIR__ . '/views/dashboard/taken/new.php';
                break;


            case '/bestellingen' :
                require_once __DIR__ . '/views/dashboard/orders/index.php';
                break;
            case '/bestelling' :
                require_once __DIR__ . '/views/dashboard/orders/bestelling.php';
                break;
            case '/bestellingen/nieuw' :
                require_once __DIR__ . '/views/dashboard/orders/new.php';
                break;


            case '/profiel' :
                require_once __DIR__ . '/views/dashboard/profile/index.php';
                break;

            case '/medewerkers' :
                require_once __DIR__ . '/views/dashboard/medewerkers/index.php';
                break;
            case '/medewerkers/nieuw' :
                require_once __DIR__ . '/views/dashboard/medewerkers/new.php';
                break;

            case '/' :
                require_once __DIR__ . '/views/dashboard/index.php';
                break;
            case '' :
                require_once __DIR__ . '/views/dashboard/index.php';
                break;
            case '/logout' :
                require_once __DIR__ . '/controllers/logout/logout.php';
                break;
            case '/404' :
                require_once __DIR__ . '/views/error/404.php';
                break;
            default:
                require_once __DIR__ . '/views/error/404.php';
                break;
        }
    }
}
?>


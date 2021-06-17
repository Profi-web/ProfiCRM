<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/libraries/Medoo.php';
if ($_SERVER['HTTP_HOST'] === 'crm.ontwikkeling') {
    $db = array(
        'database_type' => 'mysql',
        'database_name' => 'crm_dev',
        'server' => 'localhost',
        'username' => 'root',
        'password' => ''
    );
} elseif ($_SERVER['HTTP_HOST'] === 'dev.profi-crm.nl ') {
    $db = array(
        'database_type' => 'mysql',
        'database_name' => 'crm_dev',
        'server' => 'localhost',
        'username' => 'root',
        'password' => ''
    );
} else {
    $db = array(
        'database_type' => 'mysql',
        'database_name' => 'crm_main',
        'server' => 'localhost',
        'username' => 'crm_main',
        'password' => 'kVyu1pfXB'
    );
}

define("DB_INIT", $db);

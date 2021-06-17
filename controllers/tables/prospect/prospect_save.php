<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/


$prospect = new Prospect();

$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();

/**/

if(isset($_POST['name'])){
    $name = $_POST['name'];
} else {
    header('Location: /404');
}

if(isset($_POST['phonenumber'])){
    $phonenumber = $_POST['phonenumber'];
} else {
    header('Location: /404');
}

if(isset($_POST['email'])){
    $email = $_POST['email'];
} else {
    header('Location: /404');
}

if(isset($_POST['website'])){
    $website = $_POST['website'];
} else {
    header('Location: /404');
}
if(isset($_POST['address'])){
    $address = $_POST['address'];
} else {
    header('Location: /404');
}
if(isset($_POST['zipcode'])){
    $zipcode = $_POST['zipcode'];
} else {
    header('Location: /404');
}
if(isset($_POST['city'])){
    $city = $_POST['city'];
} else {
    header('Location: /404');
}
if(isset($_POST['kvk'])){
    $kvk = $_POST['kvk'];
} else {
    header('Location: /404');
}

if(isset($_POST['activityText'])){
    $activityText = $_POST['activityText'];
} else {
    header('Location: /404');
}


if(isset($_POST['contactpersoon'])){
    $contactpersoon = $_POST['contactpersoon'];
} else {
    header('Location: /404');
}

function return_data($status, $message, $error = null)
{
    if ($status === 'error') {
        $return =
            [
                "status" => "error",
                "class" => "alert-danger",
                "message" => $message,
                "error" => $error,
            ];
        echo json_encode($return);
        exit();

    }

    if ($status === 'success') {
        $return =
            [
                "status" => "success",
                "class" => "alert-success",
                "message" => $message,
                "error" => $error,
            ];
        echo json_encode($return);
        exit();
    }

    $return =
        [
            "status" => "unkown",
            "class" => "alert-warning",
            "message" => $message,
            "error" => $error,
        ];
    echo json_encode($return);
    exit();
}
$userSend = new User();
if($prospect->create($contactpersoon,$name,$phonenumber,$email,$website,$address,$zipcode,$city,$kvk,$activityText,$userSend->data['id'])){
    return_data('success','Gelukt!');
} else {
    return_data('error',$prospect->getError());
}

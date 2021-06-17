<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/


$activity = new Activity();

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/
if(isset($_POST['text'])){
    $text = $_POST['text'];
} else {
    header('Location: /404');
}

if(isset($_POST['user'])){
    $user = $_POST['user'];
} else {
    header('Location: /404');
}

if(isset($_POST['relation'])){
    $relation = $_POST['relation'];
} else {
    header('Location: /404');
}

if(isset($_POST['type'])){
    $type = $_POST['type'];
} else {
    header('Location: /404');
}

if(isset($_POST['status'])){
    $status = $_POST['status'];
} else {
    header('Location: /404');
}
if(isset($_POST['facturering'])){
    $facturering = $_POST['facturering'];
} else {
    header('Location: /404');
}
if(isset($_POST['date'])){
    $date = $_POST['date'];
} else {
    header('Location: /404');
}
if(isset($_POST['from_time'])){
    $from_time = $_POST['from_time'];
} else {
    header('Location: /404');
}
if(isset($_POST['to_time'])){
    $to_time = $_POST['to_time'];
} else {
    header('Location: /404');
}

if(isset($_POST['traveltime'])){
    $traveltime = $_POST['traveltime'];
} else {
    header('Location: /404');
}
$sentUser = new User();
$sentUserID = $sentUser->data['id'];

if(!isset($sentUserID)){
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

if($activity->create($text,$user,$relation,$type,$status,$facturering,$date,$from_time,$to_time,$traveltime,$sentUserID)){
    return_data('success','Gelukt!');
} else {
    return_data('error',$activity->getError());
}

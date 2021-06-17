<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/


$order = new Order();

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/
if(isset($_POST['text'])){
    $text = $_POST['text'];
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
if(isset($_POST['price'])){
    $price = $_POST['price'];
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
$date = date("Y-m-d");

if($order->create($text,$relation,$price,$type,$status,$facturering,$date)){
    return_data('success','Gelukt!');
} else {
    return_data('error',$order->getError());
}

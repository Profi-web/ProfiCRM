<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    header('Location: /404');
}

if(isset($_GET['facturering'])){
    $facturering = $_GET['facturering'];
} else {
    header('Location: /404');
}


$order = new Order($id);

$loginValidate = new validateLogin();
$loginValidate->securityCheck();


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

if($order->update_facturering($id,$facturering)){
    return_data('success','Gelukt!');
} else {
    return_data('error',$order->getError());
}

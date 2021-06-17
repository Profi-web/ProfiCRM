<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/


$procedure = new Procedure();

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/
if(isset($_POST['text'])){
    $text = $_POST['text'];
} else {
    header('Location: /404');
}

if(isset($_POST['title'])){
    $title = $_POST['title'];
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

if($procedure->create($text,$title)){
    return_data('success','Gelukt!');
} else {
    return_data('error',$procedure->getError());
}

<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if(isset($_POST['id'])){
    $id = $_POST['id'];
} else {
    header('Location: /404');
}

$file = new Files(null,'company_files');


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
if($file->delete($id)){
    return_data('success','Verwijderd!');
} else {
    return_data('error',$file->getError());
}

<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

$user = new User();
if(isset($_POST['id'])){
    $id = $_POST['id'];
} else {
    header('Location: /404');
}

if($user->data['role'] == 1 || $user->data['role'] == 4) {

} else {
    header('Location: /404');
}

$version = new Version($id);


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
if($version->delete($id)){
    return_data('success','Verwijderd!');
} else {
    return_data('error',$version->getError());
}

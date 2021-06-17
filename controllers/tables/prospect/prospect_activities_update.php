<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/


$ProspectActivities = new ProspectActivities();

$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();

/**/


if(isset($_POST['id'])){
    $id = $_POST['id'];
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
$date = date("d-m-Y");

if($ProspectActivities->update($_POST['status'],$_POST['info'],$id,$date,$_POST['date'])){
    return_data('success','Gelukt!');
} else {
    return_data('error',$ProspectActivities->getError());
}

<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/


$ProspectActivities = new ProspectActivities();

$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();

$user = new User();

/**/

if(isset($_POST['status'])){
    $status = $_POST['status'];
} else {
    header('Location: /404');
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
} else {
    header('Location: /404');
}


if(isset($_POST['info'])){
    $info = $_POST['info'];
} else {
    $info = '';
}


if(isset($_POST['date'])){
    $activity_date = $_POST['date'];
} else {
    $activity_date = '';
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

if($ProspectActivities->create($status,$info,$id,$date,$activity_date,$user->data['id'])){
    return_data('success','Gelukt!');
} else {
    return_data('error',$ProspectActivities->getError());
}

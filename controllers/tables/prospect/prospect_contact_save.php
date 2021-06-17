<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    header('Location: /404');
}


$prospect = new Prospect($id);

$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
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

if($prospect->update_contact($id,$_POST['phonenumber'],$_POST['email'],$_POST['website'],$_POST['address'],$_POST['zipcode'],$_POST['city'],$_POST['kvk'],$_POST['name'],$_POST['contactpersoon'])){
    return_data('success','Gelukt!');
} else {
    return_data('error',$prospect->getError());
}

<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if(isset($_POST['person'])){
    $person_id = $_POST['person'];
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
$person = new Person();


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
if($person->saveRelation($person_id,$type,$relation)){
    return_data('success','Gelukt!');
} else {
    return_data('error',$person->getError());
}

<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if(isset($_POST['id'])){
    $id = $_POST['id'];
} else {
    header('Location: /404');
}

$user = new User($id);

$usersession = new User($_SESSION['userid']);


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
if($id == $_SESSION['userid']){
    return_data('error','Je kan niet je eigen account verwijderen!');
}
if($usersession->data['role'] == '1') {
    if ($user->delete($id)) {
        return_data('success', 'Verwijderd!');
    } else {
        return_data('error', $user->getError());
    }
} else {
    return_data('error','Alleen de eigenaar kan andere medewerkers verwijderen!');

}

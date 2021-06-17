<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

$login = new Login();

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

//Check email & password
if ($login->checkFields($_POST['email'], $_POST['password'])) {
    //Validate password
    if ($login->validatePassword()) {
        //Setcookie
        if (isset($_POST['check'])) {
            if ($login->setLoginCookie()) {
                $login->saveLogin();
                return_data('success', 'Gelukt!');
            } else {
                return_data('error', $login->getError());
            }
        } else {
            $login->saveLogin();
            return_data('success', 'Gelukt!');
        }


    } else {
        return_data('error', $login->getError());
    }
} else {
    return_data('error', $login->getError());
}

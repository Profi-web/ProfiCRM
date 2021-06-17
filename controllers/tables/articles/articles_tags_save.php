<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if(isset($_POST['tag'])){
    $tag_id = $_POST['tag'];
} else {
    header('Location: /404');
}

if(isset($_POST['choice'])){
    $choice_id = $_POST['choice'];
} else {
    header('Location: /404');
}

$article = new Article();


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
if($article->saveRelation($tag_id,$choice_id )){
    return_data('success','Verwijderd!');
} else {
    return_data('error',$article->getError());
}

<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/


$article = new Article();

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/
if(isset($_POST['text'])){
    $text = $_POST['text'];
} else {
    header('Location: /404');
}

if(isset($_POST['name'])){
    $name = $_POST['name'];
} else {
    header('Location: /404');
}

if(isset($_POST['date'])){
    $date = $_POST['date'];
} else {
    header('Location: /404');
}
$newTag= '';
$alreadyTag = '';
if(isset($_POST['newTag']) || isset($_POST['alreadyTag'])){
    if(isset($_POST['newTag']) && $_POST['newTag']){
        $newTag = $_POST['newTag'];
    }
    if(isset($_POST['alreadyTag']) && $_POST['alreadyTag']){
        $alreadyTag = $_POST['alreadyTag'];
    }
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

if($article->createNew($text,$name,$date,$newTag,$alreadyTag)){
    return_data('success','Gelukt!');
} else {
    return_data('error',$article->getError());
}

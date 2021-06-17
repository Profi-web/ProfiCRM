<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

if(!isset($_GET['url'])){
    header('location:/');
} else {
    $url = urldecode($_GET['url']);
}

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

$error = '';

$user = new User();
echo json_encode($user->data);
switch($user->data['theme']){
    case 1:
        $user->db->update('users',['theme'=> 2],['id'=>$user->data['id']]);
        if($user->db->error()[2]){
            $error .= 'error1';
        }
        break;
    case 2:
        $user->db->update('users',['theme'=> 1],['id'=>$user->data['id']]);
        if($user->db->error()[2]){
            $error .= 'error2';
        }
        break;
}
if($error == ''){
    header('location:'.$url);
} else {
    header('location:'.$url.'?=error=oeps');
}

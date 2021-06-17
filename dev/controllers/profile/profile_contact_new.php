<?php
/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Get DB config*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
/**/


/*Include Medoo*/

use Medoo\Medoo;

/**/
$db = new Medoo(DB_INIT);
/**/

//ERROR
$error = '';


$loginValidate = new validateLogin();
$loginValidate->securityCheck();

$currentuser = new User($_SESSION['userid']);

if ($currentuser->data['role'] != 1) {
    header('Location: /medewerkers');
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


$update_array = [];
if (!isset($_POST['name']) || empty($_POST['name'])) {
    $error .= 'Vul een naam in<br>';
}

if (!isset($_POST['role']) || empty($_POST['role'])) {
    $error .= 'Vul een positie in<br>';
}

if (!isset($_POST['email']) || empty($_POST['email'])) {
    $error .= 'Vul een email in<br>';
}

if (!isset($_POST['password']) || empty($_POST['password'])) {
    $error .= 'Vul een wachtwoord in<br>';
}

if (!empty($error)) {
    return_data('error', $error);
}

foreach ($_POST as $key => $value) {
    switch ($key) {
        case 'name';
            if ($value) {
                $update_array[$key] = strip_tags($value);
            } else {
                $error .= 'Vul een geldige naam in<br>';
            }
            break;

        case 'role';
            if ($value == 1 || $value == 2 || $value == 3 || $value == 4 || $value == 5 || $value == 6 || $value == 7) {
                if ($value == 1) {
                    $user = $db->select('users', '*', ['id' => $_SESSION['userid']]);
                    if (!$db->error()[2]) {
                        if ($user[0]['role'] == 1) {
                            $update_array[$key] = strip_tags($value);
                        } else {
                            $error .= 'Oeps niet genoeg rechten!<br>';
                        }
                    } else {
                        $error .= 'Oeps er ging iets mis met de gebruikers!<br>';
                    }
                } else {
                    $update_array[$key] = strip_tags($value);
                }

            } else {
                $error .= 'Vul een geldige positie in<br>';
            }
            break;

        case 'email';
            if ($value) {
                if (filter_var($value, FILTER_VALIDATE_EMAIL)) {

                    if ($db->count('users', ['email' => $value]) > 0) {
                        $error .= 'Dit email bestaat al<br>';
                    } else {
                        $update_array[$key] = strip_tags($value);
                    }
                } else {
                    $error .= 'Vul een geldige email in<br>';
                }

            } else {
                $error .= 'Vul een geldige email in<br>';
            }
            break;
        case 'password';
            if ($value) {

                if (strlen($value) < 8) {
                    $error .= 'Uw wachtwoord moet minimaal 8 tekens lang zijn<br>';
                }
                if ($value == $_POST['email']) {
                    $error .= 'Uw wachtwoord mag niet gelijk staan aan uw email<br>';
                }

                if ($error == '') {
                    $options = [
                        'cost' => 12,
                    ];

                    $update_array[$key] = password_hash($value, PASSWORD_BCRYPT, $options);
                }

            } else {
                $error .= 'Vul een geldige wachtwoord in<br>';
            }
            break;

        case 'address';
            if ($value) {
                $update_array[$key] = strip_tags($value);
            } else {
                $error .= 'Vul een geldig adres in<br>';
            }
            break;

        case 'city';
            if ($value) {
                $update_array[$key] = strip_tags($value);
            } else {
                $error .= 'Vul een geldige stad in<br>';
            }
            break;

        case 'zipcode';
            if ($value) {
                $update_array[$key] = strip_tags($value);
            } else {
                $error .= 'Vul een geldige postcode in<br>';
            }
            break;

        case 'phonenumber';
            if ($value) {
                if (ctype_digit($value)) {
                    $update_array[$key] = strip_tags($value);
                } else {
                    $error .= 'Vul een geldig telefoonnummer in<br>';
                }
            } else {
                $error .= 'Vul een geldig telefoonnummer in<br>';
            }
            break;

        case 'info';
            if ($value) {
                $update_array[$key] = strip_tags($value);
            } else {
                $error .= 'Vul een geldige informatie in<br>';
            }
            break;

        case 'remove_profile_banner_value';
            if ($value == 1) {
                $update_array['banner'] = '';
            }
            break;

        case 'remove_profile_image_value';
            if ($value == 1) {
                $update_array['picture'] = '';
            }
            break;


    }
}

foreach ($_FILES as $key => $value) {
    switch ($key) {
        case 'picture';
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/picture/";
            $target_file = $target_dir . basename($value["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
            $check = getimagesize($value["tmp_name"]);
            if ($check === false) {
                $error .= 'Vul een plaatje in bij profiel plaatje<br>';
            }
            if (file_exists($target_file)) {
                $error .= 'Sorry dit profielplaatje bestaat al<br>';
            }
            if ($value["size"] > 50000000) {
                $error .= 'Sorry dit profielplaatje is te groot<br>';
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $error .= 'Sorry bij profielplaatje worden alleen JPG, PNG, JPEG en gif geaccepteerd<br>';
            }

            if (empty($error)) {
                if (!move_uploaded_file($value["tmp_name"], $target_file)) {
                    $error .= 'Sorry bij het uploaden van het profielplaatje ging iets mis<br>';
                } else {
                    $update_array[$key] = strip_tags($value['name']);
                }
            }
            break;

        case 'banner';
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/banner/";
            $target_file = $target_dir . basename($value["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
            $check = getimagesize($value["tmp_name"]);
            if ($check === false) {
                $error .= 'Vul een plaatje in bij banner plaatje<br>';
            }
            if (file_exists($target_file)) {
                $error .= 'Sorry deze banner bestaat al, verzin en nieuwe naam<br>';
            }
            if ($value["size"] > 50000000) {
                $error .= 'Sorry deze banner is te groot<br>';
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $error .= 'Sorry bij de banner worden alleen JPG, PNG, JPEG geaccepteerd<br>';
            }

            if (empty($error)) {
                if (!move_uploaded_file($value["tmp_name"], $target_file)) {
                    $error .= 'Sorry bij het uploaden van de banner ging iets mis<br>';
                } else {
                    $update_array[$key] = strip_tags($value['name']);
                }
            }
            break;
    }
}

if (empty($error)) {

    $db->insert('users', $update_array);
    return_data('success', $error);
} else {
    return_data('error', $error);
}

//if($id){
//    return_data('success','Aangepast!');
//} else {
//    return_data('error',$company->getError());
//}

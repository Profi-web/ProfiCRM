<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if (isset($_POST['relation'])) {
    $relation = $_POST['relation'];
    $relation = intval($relation);
    if (is_numeric($relation)) {
        if ($relation < 1) {
            header('Location: /404');
        }
    } else {
        header('Location: /404');
    }
} else {
    header('Location: /404');
}

$company = new Company();
$file = new Files(null, 'company_files');

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

$error = '';
$total = count($_FILES['filename']['name']);

if (!file_exists( $_SERVER['DOCUMENT_ROOT'].'/uploads/company/'.$relation)) {
    mkdir( $_SERVER['DOCUMENT_ROOT'].'/uploads/company/'.$relation, 0755, true);
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/company/".$relation.'/';
} else {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/company/".$relation.'/';
}
if ($total > 0) {

    for ($i = 0; $i < $total; $i++) {
//Get the temp file path
        $tmpFilePath = $_FILES['filename']['tmp_name'][$i];
        $fileName = $_FILES['filename']['name'][$i];
        $fileSize = $_FILES['filename']['size'][$i];

        //Make sure we have a file path
        if ($tmpFilePath != "") {
            //Setup our new file path
            $target_file = $target_dir . basename($fileName);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            //Upload the file into the temp dir
            if ($fileSize < 1) {
                $error .= 'Geen bestanden gevonden' . '<br>';
            }
            if (file_exists($target_file)) {
                $error .= 'Sorry dit bestand bestaat al, verzin een nieuwe naam' . '<br>';
            }
            if ($fileSize > 10000000) {
                $error .= 'Sorry dit bestand is te groot<br>';
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" &&$imageFileType != "pdf") {
                $error .= 'Sorry momenteel worden alleen JPG, PNG, JPEG, PDF geaccepteerd<br>';
            }

        } else {
            $error .= 'Geen bestanden gevonden.' . '<br>';
        }
    }
    if ($error == '') {
        $uploadError = '';
        $uploadPaths = [];
        $uploadNames = [];
        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES['filename']['tmp_name'][$i];
            $fileName = $_FILES['filename']['name'][$i];
            $fileSize = $_FILES['filename']['size'][$i];
            $target_file = $target_dir . basename($fileName);
            $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if ($error == '') {
                $uploadNames[] = [$fileName,$imageFileType,$fileSize];
                $uploadPaths[] = $target_file;
                if (!move_uploaded_file($tmpFilePath, $target_file)) {
                    $uploadError .= 'Sorry bij het uploaden van het bestand ging iets mis<br>';
                }
            }
        }
    } else {
        return_data('error', $error);
    }

    if ($uploadError == '') {
        $databaseError = '';
        $date = date("Y-m-d");
        foreach ($uploadNames as $uName) {
            $file->create($uName[0], $relation, $uName[1], $date,$uName[2]);
            if ($file->db->error()[2]) {
                $databaseError .= 'Error met: ' . $uName[0];
            }
        }
        if ($databaseError) {
            foreach ($uploadPaths as $uPath) {
                if (!unlink($uPath)) {
                    $tmpError .= 'Oeps met ' . $uPath;
                }
            }
            return_data('error', 'Oeps er ging iets met met het opslaan in de database.'.$databaseError.$file->db->error()[2]);
        } else {
            return_data('success', 'Gelukt!');
        }
    } else {
        foreach ($uploadPaths as $uPath) {
            if (!unlink($uPath)) {
                $tmpError .= 'Oeps met ' . $uPath;
            }
        }
        return_data('error', $error . $tmpError . 'oeps');
    }

} else {
    $error .= 'Geen bestanden gevonden' . '<br>';
}




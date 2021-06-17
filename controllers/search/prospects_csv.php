<?php
header('Content-type: text/csv');
header('Content-disposition: attachment;filename=prospects.csv');
/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
$pagination = 1;
if (isset($_GET['page'])) {
    $pagination = $_GET['page'];
}
/**/


/*Classes*/
$table = new Table($pagination, 'prospects', 'prospects');
$prospects = new Prospects('', $table->limit);

$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();

/**/
if (isset($_GET['city']) && $_GET['city']) {
    if (!empty($_GET['city'])) {
        $citysort = $_GET['city'];
    } else {
        $citysort = '';
    }
} else {
    $citysort = '';
}

if (isset($_GET['from_date']) && $_GET['from_date']) {
    if (!empty($_GET['from_date'])) {
        $from_datesort = $_GET['from_date'];
        $from_datesort = strtotime($from_datesort);
        $from_datesort = date('Y-m-d', $from_datesort);
    } else {
        $from_datesort = '';
    }
} else {
    $from_datesort = '';
}

if (isset($_GET['to_date']) && $_GET['to_date']) {
    if (!empty($_GET['to_date'])) {
        $to_datesort = $_GET['to_date'];
        $to_datesort = strtotime($to_datesort);
        $to_datesort = date('Y-m-d', $to_datesort);
    } else {
        $to_datesort = '';
    }
} else {
    $to_datesort = '';
}



/*Variables*/
/**/
$search = $prospects->findAllCSV('', $citysort, $from_datesort, $to_datesort);
//echo $prospects->db->last();

function htmlToPlainText($str){
    $str = str_replace('<br>', ' ', $str);
    $str = str_replace('nee', 'Geen', $str);
    $str = str_replace('<br />', ' ', $str);
    $str = str_replace('<br/>', ' ', $str);
    $str = str_replace('&nbsp;', ' ', $str);
    $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
    $str = html_entity_decode($str);
    $str = htmlspecialchars_decode($str);
    $str = strip_tags($str);

    return $str;
}
//exit();
?>
"sep=,"
ID,Text,Naam,Email,Telefoonnummer,Website,Stad,KvK,Status,Datum<?php
if ($search) {
    foreach ($search as $prospect) {
        $kvk = $prospect['kvk'];
        if (!$kvk) {
            $kvk = '';
        } else{
            if(strlen($kvk) == 7){
                $kvk = "0".$kvk;
                switch(strlen($kvk)){
                    case 8:
                        $kvk = $kvk.'0000';
                        break;
                    case 9:
                        $kvk = $kvk.'000';
                        break;
                    case 10:
                        $kvk = $kvk.'00';
                        break;
                    case 11:
                        $kvk = $kvk.'0';
                        break;
                }
            } else {
                switch(strlen($kvk)){
                    case 8:
                        $kvk = $kvk.'0000';
                        break;
                    case 9:
                        $kvk = $kvk.'000';
                        break;
                    case 10:
                        $kvk = $kvk.'00';
                        break;
                    case 11:
                        $kvk = $kvk.'0';
                        break;
                }
            }
        }
        foreach($prospect as $potentie){
            str_replace(',', '.', $potentie);
        }
        $prospectActivity = new ProspectActivities();
        $find = $prospectActivity->findAllId(0,999999,$prospect['id']);
        $text = '';
        foreach($find as $activty){
            $text .= $activty['info'].' | ';
        }
        ?>

<?php echo $prospect['id'] ?>,<?php echo htmlToPlainText($text);?>,<?php echo $prospect['name'] ?>,<?php echo $prospect['email'] ?>,<?php echo $prospect['phonenumber'] ?>,<?php echo $prospect['website'] ?>,<?php echo $prospect['city'] ?>,<?php echo $kvk ?>,<?php echo $prospects->getStatusClean($prospect['status']); ?>,<?php if ($prospect['date'] != '0000-00-00') {$date = strtotime($prospect['date']);$date = date('d-m-Y', $date);echo $date;} else {echo '-';} ?><?php
    }
}
?>


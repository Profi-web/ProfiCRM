<?php


/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

$notifications = new Notification();
$activityHolder = new Activities();
$loginValidate = new validateLogin();
$loginValidate->securityCheck();

$user = new User();

if (isset($user->data['id'])) {
    $userid = $user->data['id'];
} else {
    header('Location: /');
}
/**/
$msg = [
//        NIEUWE TAAK
    1 =>
        [
            1 => [
                'color' => 'orangered',
                'icon' => 'building',
                'message' => 'Taak nieuw: #{number}!'
            ],
                2 => [
                    'color' => 'orange',
                    'icon' => 'user',
                    'message' => 'Taak nieuw: #{number}!'
                ]

        ],
    /*TAAK GEKOPPELD*/
    2 =>
        [
            1 => [
                'color' => 'orangered',
                'icon' => 'building',
                'message' => 'Taak update: #{number}!'
            ],
            2 => [
                'color' => 'orange',
                'icon' => 'user',
                'message' => 'Taak update: #{number}!'
            ]

        ],
];

/*Variables*/
/**/
if (!$notifications->findAllUser($userid)) {
    ?>
    <div class="row flex-column h-100 justify-content-center align-items-center text-center">
        <i class="fad fa-smile-beam fa-3x pb-2"></i>
        Geen notificaties gevonden.
    </div>
    <?php
}
foreach ($notifications->findAllUser($userid) as $noti) {
    $notiID = $noti['relation'];
    $data =  $activityHolder->findBoolean($notiID);

    if ($data['relation_type'] == 1) {
        $connectedID = 1;
    } elseif ($data['relation_type']== 2) {
        $connectedID = 2;
    }

    $date = strtotime($noti['datetime']);
    $datenow = time();
    $time = $datenow - $date;
    $seconden = $time;
    if ($seconden == 1) {
        $secondentext = $seconden . ' seconde geleden';
    } else {
        $secondentext = $seconden . ' secondes geleden';
    }


    $minutes = floor($time / 60);
    if ($minutes == 1) {
        $minutestext = $minutes . ' minuut geleden';
    } else {
        $minutestext = $minutes . ' minuten geleden';
    }

    $hours = floor($time / 3600);
    if ($hours == 1) {
        $hourstext = $hours . ' uur geleden';
    } else {
        $hourstext = $hours . ' uren geleden';
    }

    $dagen = floor($time / 86400);
    if ($dagen == 1) {
        $dagentext = $dagen . ' dag geleden';
    } else {
        $dagentext = $dagen . ' dagen geleden';
    }

    $finalmsg = '';
    if ($dagen > 0) {
        $finalmsg = $dagentext;
    } elseif ($hours > 0) {
        $finalmsg = $hourstext;
    } elseif ($minutes > 0) {
        $finalmsg = $minutestext;
    } else {
        $finalmsg = $secondentext;
    }
    ?>
    <li id="<?php echo $noti['id'] ?>">
        <div class="container-fluid" onclick="window.location.href = '/taak?id=<?php echo $noti['relation']; ?>';">
            <div class="row justify-content-between <?php if ($noti['viewed'] == 1) {
                echo 'font-weight-bold';
            } else {
                echo 'op-75';
            } ?>">
                <div class=" col-3 p-0">
                    <div class="notification_icon_li bg-<?php echo $msg[$noti['type']][$connectedID]['color']; ?>">
                        <div class="row justify-content-center align-items-center h-100">
                            <i class="fa fa-<?php echo $msg[$noti['type']][$connectedID]['icon']; ?> text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="notification-text col-9 p-0">
                    <a class="row flex-column">
                        <div><?php echo str_replace('{number}', $noti['relation'], $msg[$noti['type']][$connectedID]['message']); ?></div>
                        <div class="text-muted" style="font-size:12px;"><?php echo $finalmsg; ?></div>
                    </a>
                </div>
            </div>
        </div>
    </li>
    <?php
}
?>


<!--SIDENAV-->
<?php

$menu = new Menu();
$company_count = new Company();
$contact_count = new Person();
$prospect_count = new Prospect();
$supplier_count = new Supplier();
$notifications = new Notification();

if($user->data['picture']){
    $image = $user->data['picture'];
} else {
    $image = 'placeholder.png';
}
$notificationboolean = true;
$notificationsamount = $notifications->countUser($user->data['id']);
if($notificationsamount > 0){
    $notiicon = 'bell-regularred.svg';
    $noticlass = 'bounce';
} else {
    $notiicon = 'bell-regular.svg';
    $noticlass = '';
}
?>
<div class="position-fixed  notification_holder">
    <div class="notification_board shadow">
        <div class="notification_top p-3 w-100">
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <div class="mt-1">Je hebt <?php echo $notificationsamount; ?> notificaties.</div>
                    <div class="close_notification"><i class="fa fa-window-minimize"></i></div>
                </div>
            </div>
        </div>
        <ul class="notification_content px-3 pb-3">
<li>
                <div class="container-fluid">
                    <div class="row justify-content-between">
                        <div class=" col-3 p-0">
                            <div class="notification_icon_li" style="background:#cccccc;">
                                <div class="row justify-content-center align-items-center h-100">
                                    <i class="fad fa-spinner text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="notification-text col-9 p-0">
                            <a class="row flex-column">
                                <div style="background: #cccccc;color:#cccccc; width:70%;height:13px;border-radius: 10px;margin-top:4px;"></div>
                                 <div style="background: #d9d9d9;color:#d9d9d9; width:40%;height:10px;border-radius: 10px; margin-top:5px;"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
    <li>
                <div class="container-fluid">
                    <div class="row justify-content-between">
                        <div class=" col-3 p-0">
                            <div class="notification_icon_li" style="background:#cccccc;">
                                <div class="row justify-content-center align-items-center h-100">
                                    <i class="fad fa-spinner text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="notification-text col-9 p-0">
                            <a class="row flex-column">
                                  <div style="background: #cccccc;color:#cccccc; width:70%;height:13px;border-radius: 10px;margin-top:4px;"></div>
                                 <div style="background: #d9d9d9;color:#d9d9d9; width:40%;height:10px;border-radius: 10px; margin-top:5px;"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="container-fluid">
                    <div class="row justify-content-between">
                        <div class=" col-3 p-0">
                            <div class="notification_icon_li" style="background:#cccccc;">
                                <div class="row justify-content-center align-items-center h-100">
                                    <i class="fad fa-spinner text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="notification-text col-9 p-0">
                            <a class="row flex-column">
                    <div style="background: #cccccc;color:#cccccc; width:70%;height:13px;border-radius: 10px;margin-top:4px;"></div>
                                 <div style="background: #d9d9d9;color:#d9d9d9; width:40%;height:10px;border-radius: 10px; margin-top:5px;"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="d-flex justify-content-center align-items-center notification_icon shadow <?php echo $noticlass; ?>" style="align-self: flex-end;">
<!--        <i class="far fa-bell" style="font-size:22px;"></i>-->
           <img src="/assets/media/<?php echo $notiicon;?>"  width="22px"/>
    </div>

</div>

<div id="sidenav" class="position-fixed bg-white p-4 d-none d-md-block">
    <div class="container-fluid mt-2 mb-4 pb-3">
        <a class="justify-content-center row" href="/">
            <img src="/assets/media/logo.png"
                 class=" col-12 col-md-12 col-lg-12" height="40" style="object-fit: contain">
        </a>
    </div>
    <div class="row sidenav_menu pl-4 pr-3">
        <?php
        foreach ($menu->getMenuCats() as $cat) {
            $count = 0;
            if ($cat['visible'] === '1') {
                echo "
     <div class='col-12 w-100 divider mt-3 mb-1'></div>
        <div class='divider_text pr-3 pt-3'>{$cat['title']}</div>
    ";
            }
            $userMenu = new User();
            foreach ($menu->getMenu($cat['id']) as $item) {
                if($userMenu->data['role'] !== $item['role']){
                    $count ++;
                echo "
        <a class='col-12 item py-3' href='{$item['url']}'>
            <div class='row align-items-baseline'>
                <div class='col-25 text-center'><i class='{$item['icon']} text-{$item['color']}'></i></div>
                <div class='col-7 text'>{$item['name']}</div>
                ";
                if (isset($page)) {
                    if ($item['name'] === $page) {
                        echo "<div class='col-2'><i class='fad fa-caret-right pl-2 text-{$item['color']}'></i></div>";
                    }
                }
                echo "
            </div> 
        </a>
        ";
            }
                }
            if($count == 0){
            ?>
             <a class='col-12 item py-3'>
            <div class='row align-items-baseline'>
                <div class='col-25 text-center'><i class='fad fa-empty-set text-green'></i></div>
                <div class='col-7 text'>-</div>
            </div>
        </a>
            <?php
            }
        }
        ?>
    </div>




</div>
<!---->

<!--CONTENT-->
<div class="content position-relative">

    <!--    MOBILE BAR-->
    <div class="d-md-none bg-white mobile">

        <!--MOBILE TOP BAR-->
        <div class="row justify-content-between py-3 m-0 mobile_bar" style="height:100px;">
            <a class="col-3 col-sm-2 toggler" data-toggle="collapse" data-target="#navbarSupportedContent"
               href="#navbarSupportedContent">
                <div class="row h-100 justify-content-center align-items-center">
                    <i class="fad fa-bars fa-2x"></i>
                </div>
            </a>
            <div class="col-5 col-sm-3">
                <a class="justify-content-center h-100 align-items-center row" href="/">
                    <img src="/assets/media/logo.png"
                         class=" col-12 col-md-12 col-lg-12" style="object-fit: contain">
                </a>
            </div>
            <div class="col-4 col-sm-2 profile_mobile align-items-center justify-content-center row mr-0">
                <div class="row justify-content-end align-items-center m-0">
                    <img src="/uploads/picture/<?php echo $image; ?>" width="50px" height="50px" class=" mpr-3 mr-sm-5 rounded-circle" style="object-fit: cover
                    ">
                </div>
                <div class="profile_box_mobile">
                    <ul class="m-0 pl-4">
                        <li><a href="/profiel" class="row"><span>Profiel</span>
                                <div class="icon_holder_small"><i class="fad fa-user text-primary"></i></div>
                            </a></li>
                        <li><a href="/logout" class="row last"><span>Uitloggen</span>
                                <div class="icon_holder_small"><i class="fad fa-sign-out-alt text-primary"></i></div>
                            </a></li>
                    </ul>
                </div>
            </div>

        </div>
        <!--MOBILE DROPDOWN BAR-->
        <div class="collapse navbar-collapse col-12 d-lg-none" id="navbarSupportedContent">
            <div class="row justify-content-center">
                <div class="col-11">
                    <div class="row align-items-center mobile_search_area">
                                        <?php
                    $userSearch = new User();
                    if($userSearch->data['role'] != 7){
                   ?>
                        <div class="col-12 mt-4 mb-2">
                            <form class=" px-0 position-relative mobile_search">
                                <div class="input-group input-group-rounded input-group-merge">
                                    <input type="search"
                                           class="form-control form-control-rounded form-control-prepended"
                                           placeholder="Zoeken" aria-label="Search">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fad fa-search"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-12 ">
                                <div class="row justify-content-center mobile_search_box">
                                    <a class="col-12 py-2 px-4 search_item muted">
                                        <div class="row align-items-center">
                                            <i class="fad fa-search text-primary search_icon"></i>
                                            <div class="pl-2 search_text">Typ om te zoeken</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php
} else {
                        ?>
                        <?php

}
 ?>

                        <?php
                        foreach ($menu->getMenuCats() as $cat) {
                            if ($cat['visible'] === '1') {
                                echo "
                         <div class='col-12 w-100 divider mt-3 mb-1'></div>
                            <div class='divider_text px-3 pt-3'>{$cat['title']}</div>
                        ";
                            }
                            foreach ($menu->getMenu($cat['id']) as $item) {

                                echo "
                            <a class='col-12 item py-3' href='{$item['url']}'>
                                <div class='row align-items-baseline'>
                                    <div class='col-2 col-sm-1 text-center'><i class='{$item['icon']} text-{$item['color']}'></i></div>
                                    <div class='col-5 text'>{$item['name']}</div>
                                </div>
                            </a>
                            ";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--    BAR-->
    <div id="navbar_main" class="position-absolute d-none d-md-block py-3 px-3 px-md-5">
        <div class="row justify-content-between py-3 align-items-center">
            <div class="col-3 d-none d-lg-flex">
                <div class="">
                    <span class="text-white font-size-20"><?php echo $page; ?></span>
                </div>
            </div>
            <div class="col-12 col-lg-8 col-xl-6 navbar-search">
                <div class="row justify-content-between">
                    <div class="col-6 col-lg-6 col-xl-8">
                    <?php
                    $userSearch = new User();
                    if($userSearch->data['role'] != 7){
                   ?>
                        <div class="form-group mb-0 h-100">
                            <div class="input-group input-group-alternative h-100 search_area">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fad fa-search"></i></span>
                                </div>
                                <input class="form-control h-100" placeholder="Zoeken" type="text">
                                <div class="search_box shadow">
                                    <div class="container-fluid">
                                        <div class="row justify-content-center result">
                                            <a class="col-12 py-2 px-4 search_item muted">
                                                <div class="row align-items-center">
                                                    <i class="fad fa-search text-primary search_icon"></i>
                                                    <div class="pl-2 search_text">Typ om te zoeken</div>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                            <?php
}
 ?>
                    </div>
                    <div class="col-6 col-lg-6 col-xl-4 position-relative profile">
                        <div class="row justify-content-end align-items-center">
                            <img src="/uploads/picture/<?php echo $image; ?>" width="50px" height="50px" style="object-fit: cover"
                                 class="profile_img rounded-circle">
                            <div class="col-6 text-white text"><?php echo $user->data['name']; ?></div>
                        </div>
                        <div class="profile_box">
                            <ul class="m-0 pl-4">
                                <li>
                                <a href="/profiel" class="row"><span>Profiel</span>
                                        <div class="icon_holder_small"><i class="fad fa-user text-primary"></i></div>
                                    </a>
                                </li>
                                <li>
                                <?php
$uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
 ?>
                                <a href="/controllers/theme/dark.php?url=<?Php echo urlencode($uri); ?>" class="row">Dark Theme
                                        <div class="icon_holder_small"><i class="<?php if($usertheme->data['theme'] == 2) {
                                            echo 'fas';
                                        } else {
                                            echo 'far';
                                        }
    ?> fa-square text-primary"></i>
                                        </div>
                                    </a>
                                </li>
                               <li>
                                       <a href="/logout" class="row last"><span>Uitloggen</span>
                                    <div class="icon_holder_small"><i class="fad fa-sign-out-alt text-primary"></i>
                                    </div>
                                </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
    if(isset($type)){
        switch($type){
            case 'customerbase':
                            $userBase = new User();

    ?>
    <div class="header gradient">
        <div class="container-fluid px-3 px-md-5 frame">
            <div class="row justify-content-between">
            <?php
                         if($userBase->data['role'] != 7){
 ?>
                <div class="col-12 col-lg-3 pb-3">
                    <a class="card" href="/bedrijven">
                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="col-9">
                                    <div class="card-title text-muted mb-0">Bedrijven</div>
                                    <span class="h5 font-weight-bold mb-0"><?php echo $company_count->countAmount(); ?></span>
                                </div>
                                <div class="col-3">
                                    <div class="row justify-content-center">
                                        <div class="rounded-circle bg-orangered icon_holder row justify-content-center align-items-center">
                                            <i class="fad fa-building text-white fa-1x"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-lg-3 pb-3">
                    <a class="card" href="/leveranciers">
                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="col-9">
                                    <div class="card-title text-muted mb-0">Leveranciers</div>
                                    <span class="h5 font-weight-bold mb-0"><?php echo $supplier_count->countAmount(); ?></span>
                                </div>
                                <div class="col-3">
                                    <div class="row justify-content-center">
                                        <div class="rounded-circle bg-cyan icon_holder row justify-content-center align-items-center">
                                            <i class="fad fa-truck-loading text-white fa-1x"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-lg-3 pb-3">
                    <a class="card" href="/contacten">
                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="col-9">
                                    <div class="card-title text-muted mb-0">Contacten</div>
                                    <span class="h5 font-weight-bold mb-0"><?php echo $contact_count->countAmount(); ?></span>
                                </div>
                                <div class="col-3">
                                    <div class="row justify-content-center">
                                        <div class="rounded-circle bg-orange icon_holder row justify-content-center align-items-center">
                                            <i class="fad fa-user-tie text-white fa-1x"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-lg-3 pb-3">
                    <a class="card" href="/prospects">
                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="col-9">
                                    <div class="card-title text-muted mb-0">Prospects</div>
                                    <span class="h5 font-weight-bold mb-0"><?php echo $prospect_count->countAmount(); ?> <span class="text-muted" style="font-size:13px;">(<?php echo $prospect_count->countAmountKvK(); ?>)</span></span>
                                </div>
                                <div class="col-3">
                                    <div class="row justify-content-center">
                                        <div class="rounded-circle bg-danger icon_holder row justify-content-center align-items-center">
                                            <i class="fad fa-user-headset text-white fa-1x"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                            <?php
    }
 ?>
            </div>

        </div>
    </div>
    <?php

        break;
    case 'profile':
        $user_profile = new User($profile_id);
        if($user_profile->data['banner']){
        ?>
<style>
        .profile_gradient{
        background-image: url("/uploads/banner/<?php echo $user_profile->data['banner'];?>")!important;
        }
</style>
<?php
}
 ?>
<div class="header profile_gradient">
        <div class="container-fluid pt-3 px-md-5 frame">
            <div class="row justify-content-between">
                <div class="col-12  py-5 text-white">
                   <h1 class="font-weight-bold">Hallo <?php echo $user_profile->data['name'];?></h1>
                   <h5>Dit is je profielpagina. Hier kunt u uw gegevens bijwerken en beheren </h5>
                </div>
            </div>
        </div>
    </div>

    <?php
      break;
       case 'employees':
        ?>
<div class="header employee_gradient">
        <div class="container-fluid pt-3 px-md-5 frame">
            <div class="row justify-content-between px-3">
                <div class="col-12  py-5 text-white text-center text-md-left px-5 px-md-0">
                   <h1 class="font-weight-bold">Jouw team! </h1>
                   <h5>Samen met deze mensen sta jij voor het team! Hier kun je alles met betrekkingen tot het team inzien en bewerken! </h5>
                </div>
            </div>
        </div>
    </div>

    <?php
      break;
        case 'articles':
        ?>
<div class="header article_gradient">
        <div class="container-fluid pt-3 px-md-5 frame">
            <div class="row justify-content-between px-3">
                <div class="col-12  py-5 text-white text-center text-md-left px-5 px-md-0">
                   <h1 class="font-weight-bold">Welkom op het kennisplein! </h1>
                   <h5>Vind hier allerlei informatie artikelen met betrekking tot Profi-Web, Service-ICT en CallProfit </h5>
                </div>
            </div>
        </div>
    </div>

    <?php
      break;
      case 'article':
        ?>
<div class="header article_gradient">
        <div class="container-fluid pt-3 px-md-5 frame">
            <div class="row justify-content-between px-3">
                <div class="col-12  py-2 text-white text-center text-md-left px-5 px-md-0">
<!--                   <h1 class="font-weight-bold">Welkom op het kennisplein! </h1>-->
<!--                   <h5>Vind hier allerlei informatie artikelen met betrekking tot Profi-Web, Service-ICT en CallProfit </h5>-->
                </div>
            </div>
        </div>
    </div>
<?php
      break;
      case 'activities':

          $employees = new Users();
          $activitiesEmployees = new Activities();
        ?>
<div class="header employee_gradient">
    <div class="container-fluid pt-3 px-md-5 frame">
        <div class="row justify-content-between px-3">
            <div class="col-12  pt-5 pb-2 text-white text-center text-md-left px-5 px-md-0">
                <div class="container-fluid">
                    <div class="row justify-content-center justify-content-md-start">
                    <?php
                        foreach($employees->findAll() as $employee){
                                      $count = $activitiesEmployees->getCount($employee['id']);
                            if($current_employee->all === false){

                                if($employee['id'] == $current_employee->data['id']){
                                         ?>
                                             <img src="/uploads/picture/<?php echo $employee['picture'];?>" width="50px" height="50px" style="object-fit: cover;border:2px solid white;" class="shadow active rounded-circle  employee_image" onclick="location.href = '/taken?id=<?php echo $employee['id'];?>';">
                                                                                                 <div style="" class="mr-3 shadow emploNoti"><?php echo $count;?></div>

                                     <?php
                                } else {
                         ?>
                                             <img src="/uploads/picture/<?php echo $employee['picture'];?>" width="50px" height="50px" style="object-fit: cover;border:2px solid white;" class="shadow rounded-circle  employee_image" onclick="location.href = '/taken?id=<?php echo $employee['id'];?>';">
                                                                                                 <div style="" class="mr-3 shadow emploNoti"><?php echo $count;?></div>
                                     <?php
                                     }
                        } else {            ?>
                                             <img src="/uploads/picture/<?php echo $employee['picture'];?>" width="50px" height="50px" style="object-fit: cover;border:2px solid white;" class="shadow rounded-circle  employee_image" onclick="location.href = '/taken?id=<?php echo $employee['id'];?>';">
                                                                                                 <div style="" class="mr-3 shadow emploNoti"><?php echo $count;?></div>
                                     <?php

                        }
                        }
                         ?>
                                                                      <img  src="/assets/media/Icon_CRM.svg" width="50px" height="50px" style="object-fit: cover;border:2px solid white;" class="shadow rounded-circle mr-3 employee_image <?php if($current_employee->all){ echo 'active';}?>" onclick="location.href = '/taken?id=all';">
                    </div>
                </div>
        </div>
        </div>
    </div>
</div>

    <?php
      break;

            case 'orders':

        ?>
<div class="header article_gradient">
        <div class="container-fluid pt-3 px-md-5 frame">
            <div class="row justify-content-between px-3">
                <div class="col-12  py-3 text-white text-center text-md-left px-5 px-md-0">
<!--                   <h1 class="font-weight-bold">Welkom op het kennisplein! </h1>-->
<!--                   <h5>Vind hier allerlei informatie artikelen met betrekking tot Profi-Web, Service-ICT en CallProfit </h5>-->
                </div>
            </div>
        </div>
    </div>
    <?php
      break;

      case 'single_activity':
          $activitiesEmployees = new Activities();
          $employees = new Users();
        ?>
<div class="header employee_gradient">
    <div class="container-fluid pt-3 px-md-5 frame">
        <div class="row justify-content-between px-3">
            <div class="col-12  pt-5 pb-2 text-white text-center text-md-left px-5 px-md-0">
                <div class="container-fluid">
                    <div class="row justify-content-center justify-content-md-start">
                    <?php
                        foreach($employees->findAll() as $employee){
                             $count = $activitiesEmployees->getCount($employee['id']);
?>
                                             <img src="/uploads/picture/<?php echo $employee['picture'];?>" width="50px" height="50px" style="object-fit: cover;border:2px solid white;" class="shadow rounded-circle employee_image" onclick="location.href = '/taken?id=<?php echo $employee['id'];?>';">
                                                                                                 <div style="" class="mr-3 shadow emploNoti"><?php echo $count;?></div>

                                     <?php

                        }
                         ?>
                                                                      <img  src="/assets/media/Icon_CRM.svg" width="50px" height="50px" style="object-fit: cover;border:2px solid white;" class="shadow rounded-circle mr-3 employee_image <?php if($current_employee->all){ echo 'active';}?>" onclick="location.href = '/taken?id=all';">
                    </div>
                </div>
        </div>
        </div>
    </div>
</div>

        <?php
      break;

         case 'single_order':
          $ordersEmployees = new Orders();
          $employees = new Users();
        ?>
<div class="header article_gradient">
        <div class="container-fluid pt-3 px-md-5 frame">
            <div class="row justify-content-between px-3">
                <div class="col-12  py-3 text-white text-center text-md-left px-5 px-md-0">
<!--                   <h1 class="font-weight-bold">Welkom op het kennisplein! </h1>-->
<!--                   <h5>Vind hier allerlei informatie artikelen met betrekking tot Profi-Web, Service-ICT en CallProfit </h5>-->
                </div>
            </div>
        </div>
    </div>
        <?php
      break;

             case 'employees_new':
        ?>
<div class="header employee_gradient">
        <div class="container-fluid pt-3 px-md-5 frame">
            <div class="row justify-content-between">
                <div class="col-12  py-5 text-white">
                   <h1 class="font-weight-bold">Versterking bij jouw team! </h1>
                   <h5>Een sterk team is een opbouw van een sterk bedrijf! Nieuwe werknemers zijn hiervoor essentieel! </h5>
                </div>
            </div>
        </div>
    </div>
<?php
      break;
             case 'procedures':
        ?>
<div class="header procedures_gradient">
        <div class="container-fluid pt-3 px-md-5 frame">
            <div class="row justify-content-between">
                <div class="col-12  py-5 text-white">
                   <h1 class="font-weight-bold">Onze procedures! </h1>
                   <h5>Hier kan je alle procedures terug vinden en toevoegen! </h5>
                </div>
            </div>
        </div>
    </div>
    <?php
      break;
             case 'changelog':
        ?>
<div class="header procedures_gradient">
        <div class="container-fluid pt-3 px-md-5 frame">
            <div class="row justify-content-between">
                <div class="col-12  py-5 text-white">
                   <h1 class="font-weight-bold">Changelog (Updates & versies)! </h1>
                   <h5>Hier kan je alle updates & versies terug vinden! </h5>
                </div>
            </div>
        </div>
    </div>
<?php
      break;
             case 'nicetohaves':
        ?>
<div class="header nice_to_have_gradient">
        <div class="container-fluid pt-3 px-md-5 frame">
            <div class="row justify-content-between">
                <div class="col-12  py-5 text-white">
                   <h1 class="font-weight-bold">Puntjes voor in de toekomst! </h1>
                   <h5>Vergeet je ideeën niet! Noteer ze en zo kun je er altijd op terug vallen in de toekomst! </h5>
                </div>
            </div>
        </div>
    </div>

    <?php
      break;
}
} else {
        $userBase = new User();
        ?>
    <div class="header gradient">
        <div class="container-fluid px-3 px-md-5 frame">
            <div class="row justify-content-between">
                        <?php
                         if($userBase->data['role'] != 7){
 ?>
                <div class="col-12 col-lg-4 pb-3">
                    <a class="card" href="/bedrijven">
                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="col-9">
                                    <div class="card-title text-muted mb-0">Bedrijven</div>
                                    <span class="h5 font-weight-bold mb-0"><?php echo $company_count->countAmount(); ?></span>
                                </div>
                                <div class="col-3">
                                    <div class="row justify-content-center">
                                        <div class="rounded-circle bg-orangered icon_holder row justify-content-center align-items-center">
                                            <i class="fad fa-building text-white fa-1x"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-lg-4 pb-3">
                    <a class="card" href="/leveranciers">
                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="col-9">
                                    <div class="card-title text-muted mb-0">Leveranciers</div>
                                    <span class="h5 font-weight-bold mb-0"><?php echo $supplier_count->countAmount(); ?></span>
                                </div>
                                <div class="col-3">
                                    <div class="row justify-content-center">
                                        <div class="rounded-circle bg-cyan icon_holder row justify-content-center align-items-center">
                                            <i class="fad fa-truck-loading text-white fa-1x"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-lg-4 pb-3">
                    <a class="card" href="/contacten">
                        <div class="card-body">
                            <div class="row justify-content-around">
                                <div class="col-9">
                                    <div class="card-title text-muted mb-0">Contacten</div>
                                    <span class="h5 font-weight-bold mb-0"><?php echo $contact_count->countAmount(); ?></span>
                                </div>
                                <div class="col-3">
                                    <div class="row justify-content-center">
                                        <div class="rounded-circle bg-orange icon_holder row justify-content-center align-items-center">
                                            <i class="fad fa-user text-white fa-1x"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
}
 ?>
            </div>
        </div>
    </div>
    <?php
}
?>
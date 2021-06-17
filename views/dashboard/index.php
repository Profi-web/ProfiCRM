<?php
/*Page Info*/
$page = 'Dashboard';
$type = 'customerbase';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
//

/*Classes*/
$user = new User();
/**/

/*CSS*/
?>
<link rel="stylesheet" href="/assets/css/dashboard.min.css">

<?php
//

/*Header*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php';
require_once 'header.php';
/**/
?>
<!--    HEADER-->
<?php

?>
<div class="container-fluid justify-content-center" style="margin-top:-65px;">
    <div class="row px-3 px-md-5">
        <div class="col-12  px-0 mt-4  order-last order-lg-first mb-md-4">
            <div class="card shadow col-12 p-0" id="profile_contact" style="min-height: 100px">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 p-4">
                            <div class="container-fluid">
                                <div class="row justify-content-between">
                                    <h3 id="day_message">Goede middag!</h3><span id="weather"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    <div class="row px-0" id="quickactions" style="margin-top:25px">
                        <div class="col-12">
                            <div class="container-fluid">
                                <div class="row justify-content-between">
                                    <div class="col-12 col-lg-2 pb-3 pr-0 pl-0 pr-lg-2">
                                        <a class="card shadow" href="/taken/nieuw">
                                            <div class="card-body">
                                                <div class="row justify-content-around">
                                                    <div class="col-9 align-items-center d-flex">
                                                        <div class="card-title text-muted mb-0">Nieuwe taak</div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="row justify-content-center pr-2">
                                                            <div style="background-color:rgb(60, 179, 113)!important;" class="rounded-circle bg-green icon_holder row justify-content-center align-items-center">
                                                                <i class="fad fa-list-ul text-white fa-1x"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                        <div class="col-12 col-lg-2 pb-3 px-0 px-lg-2">
                                            <a class="card shadow" href="/bedrijven/nieuw">
                                                <div class="card-body">
                                                    <div class="row justify-content-around">
                                                        <div class="col-9 align-items-center d-flex">
                                                            <div class="card-title text-muted mb-0">Nieuw bedrijf</div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="row justify-content-center pr-2">
                                                                <div class="rounded-circle bg-orangered icon_holder row justify-content-center align-items-center">
                                                                    <i class="fad fa-building text-white fa-1x"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-12 col-lg-2 pb-3 px-0 px-lg-2">
                                            <a class="card shadow" href="/leveranciers/nieuw">
                                                <div class="card-body">
                                                    <div class="row justify-content-around">
                                                        <div class="col-9 align-items-center d-flex">
                                                            <div class="card-title text-muted mb-0">Nieuwe leveranciers</div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="row justify-content-center pr-2">
                                                                <div class="rounded-circle bg-cyan icon_holder row justify-content-center align-items-center">
                                                                    <i class="fad fa-truck-loading text-white fa-1x"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-12 col-lg-2 pb-3 px-0 px-lg-2">
                                            <a class="card shadow" href="/contacten/nieuw">
                                                <div class="card-body">
                                                    <div class="row justify-content-around">
                                                        <div class="col-9 align-items-center d-flex">
                                                            <div class="card-title text-muted mb-0">Nieuw contact</div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="row justify-content-center pr-2">
                                                                <div class="rounded-circle bg-orange icon_holder row justify-content-center align-items-center">
                                                                    <i class="fad fa-user-tie text-white fa-1x"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-12 col-lg-2 pb-3 px-0 pr-lg-0">
                                            <a class="card shadow" href="/prospects/nieuw">
                                                <div class="card-body">
                                                    <div class="row justify-content-around">
                                                        <div class="col-9 align-items-center d-flex">
                                                            <div class="card-title text-muted mb-0">Nieuw prospect</div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="row justify-content-center pr-2">
                                                                <div class="rounded-circle bg-danger icon_holder row justify-content-center align-items-center">
                                                                    <i class="fad fa-user-headset text-white fa-1x"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                </div>
                            </div>
                        </div>
            </div>
        </div>

    </div>
</div>

<div class="bottom_notes">Profi-crm versie <?php $versions = new Versions(); echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php
/*Footer*/
require_once 'footer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php';
/**/
?>
<script src="/assets/js/dashboard/main.js"></script>
<script>
    var url = "https://openweathermap.org/data/2.5/weather?q=Slagharen,nl&appid=b6907d289e10d714a6e88b30761fae22&lang=nl";
    $.getJSON(url, function (data) {
        // switch (data['weather'][0]['description']) {
            // case 'clear sky':
            //     $('#weather').html('<i class="fad fa-sun fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
            // case 'few clouds':
            //     $('#weather').html('<i class="fad fa-cloud-sun fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
            // case 'scattered clouds':
            //     $('#weather').html('<i class="fad fa-cloud fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
            // case 'broken clouds':
            //     $('#weather').html('<i class="fad fa-clouds fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
            // case 'shower rain':
            //     $('#weather').html('<i class="fad fa-cloud-showers fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
            // case 'moderate rain':
            //     $('#weather').html('<i class="fad fa-cloud-showers fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
            // case 'rain':
            //     $('#weather').html('<i class="fad fa-cloud-sun-rain fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
            // case 'thunderstorm':
            //     $('#weather').html('<i class="fad fa-thunderstorm fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
            // case 'snow':
            //     $('#weather').html('<i class="fad fa-cloud-snow fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
            // case 'mist':
            //     $('#weather').html('<i class="fad fa-fog fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
            // case 'fog':
            //     $('#weather').html('<i class="fad fa-fog fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
            //     break;
        //     default:
        //         $('#weather').html('<i class="fad fa-cloud fa-1x"></i> Slagharen ' + data['main']['temp'] + '°');
        //         break;
        // }
        $('#weather').html('<img src="https://openweathermap.org/img/w/'+data['weather'][0]['icon']+'.png" width="30" height="30"/> Slagharen '+ Math.round(data['main']['temp'])+ '°');
    })
    ;

    var currentday = new Date().getDay();


    if(currentday==5){
        var currenthour = new Date().getHours();
        if (currenthour >= 18 && currenthour <= 23) {
            $('#day_message').html('Fijn weekend!')
        } else {
            dayMessage();
        }
    } else if(currentday == 6 || currentday == 7){
        $('#day_message').html('Fijn weekend!')
    } else{
        dayMessage();
    }

    function dayMessage(){
        var currenthour = new Date().getHours();
        if (currenthour >= 0 && currenthour <= 5) {
            $('#day_message').html('Goede nacht!')
        } else if (currenthour >= 6 && currenthour <= 11) {
            $('#day_message').html('Goede ochtend!')
        } else if (currenthour >= 12 && currenthour <= 17) {
            $('#day_message').html('Goede middag!')
        } else if (currenthour >= 18 && currenthour <= 24) {
            $('#day_message').html('Goede avond!')
        } else {
            $('#day_message').html('Hallo!')
        }
    }

</script>

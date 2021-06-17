$(document).ready(function () {
    var toggle = true;
    $('#print_hider').on('click', function () {
       if(toggle){
           $('.content').css('margin-left',0);
           $('.content').css('margin-top','75px');
           $('#sidenav').removeClass('d-md-block');
           $('#navbar_main').removeClass('d-md-block');
           $('.header').addClass('d-none');
           $('.card').removeClass('shadow');
           $('.card-header').addClass('d-none');
           toggle = false;
       } else {
           $('.content').css('margin-left','280px');
           $('.content').css('margin-top',0);
           $('#sidenav').addClass('d-md-block');
           $('#navbar_main').addClass('d-md-block');
           $('.header').removeClass('d-none');
           $('.card').addClass('shadow');
           $('.card-header').removeClass('d-none');
           toggle = true;
       }

    });

    var url = new URL(window.location.href);
    if (url.searchParams.get('gefactureerd')) {
        var gefactureerd = url.searchParams.get('gefactureerd');
        if (gefactureerd === "asc" || gefactureerd === "desc") {
            var gefactureerdsearch = '&gefactureerd=' + gefactureerd;
        }
    } else {
        var gefactureerdsearch = '';
    }

    if (url.searchParams.get('status')) {
        var status = url.searchParams.get('status');
        if (status === "asc" || status === "desc") {
            var statussearch = '&status=' + status;
        }
    } else {
        var statussearch = '';
    }

    if (url.searchParams.get('datum')) {
        var datum = url.searchParams.get('datum');
        if (datum === "asc" || datum === "desc") {
            var datumsearch = '&datum=' + datum;
        }
    } else {
        var datumsearch = '';
    }

    var id = $('.activities_table').attr('id');
    var user = $('.currentuser').attr('id');
    $('.activities_table').load('/controllers/tables/activities/activities.php?page=' + id + '&user=' + user + gefactureerdsearch + statussearch + datumsearch, function () {
    });


});
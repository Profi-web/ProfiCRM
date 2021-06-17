$(document).ready(function () {
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

    var id = $('.orders_table').attr('id');
    $('.orders_table').load('/controllers/tables/orders/orders.php?page=' + id + gefactureerdsearch +statussearch + datumsearch, function () {
    });



});
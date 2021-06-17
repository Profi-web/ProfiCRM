$(document).ready(function () {
    var url = new URL(window.location.href);

    if (url.searchParams.get('status')) {
        var status = url.searchParams.get('status');
        if (status === "asc" || status === "desc") {
            var statussearch = '&status=' + status;
        }
    } else {
        var statussearch = '';
    }

    if (url.searchParams.get('city')) {
        var city = url.searchParams.get('city');
        if (city !== "") {
            var citysearch = '&city=' + city;
        }
    } else {
        var citysearch = '';
    }

    if (url.searchParams.get('from_date')) {
        var from_date = url.searchParams.get('from_date');
        if (from_date !== "") {
            var from_dateseearch = '&from_date=' + from_date;
        }
    } else {
        var from_dateseearch = '';
    }

    if (url.searchParams.get('to_date')) {
        var to_date = url.searchParams.get('to_date');
        if (to_date !== "") {
            var to_datesearch = '&to_date=' + to_date;
        }
    } else {
        var to_datesearch = '';
    }

  var id =  $('.prospects_table').attr('id')
   $('.prospects_table').load('/controllers/tables/prospect/prospects.php?page='+id+ statussearch + citysearch + from_dateseearch + to_datesearch,function () {
   });
});
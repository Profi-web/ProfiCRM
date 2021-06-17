
$(document).ready(function () {
    var url = new URL(window.location.href);
    if (url.searchParams.get('datum')) {
        var datum = url.searchParams.get('datum');
        if (datum === "asc" || datum === "desc") {
            var datumsearch = '&datum=' + datum;
        }
    } else {
        var datumsearch = '';
    }

    var id =  $('.nice_to_haves_table').attr('id');
    $('.nice_to_haves_table').load('/controllers/tables/nice_to_have/nice_to_haves.php?page='+id+datumsearch,function () {
    });



});
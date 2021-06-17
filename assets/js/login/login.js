var url = new URL(window.location.href);
if(url.searchParams.get('reset')){
    var reset = url.searchParams.get('reset');
    if(reset == 'true'){
        $(".alert_field").load("/controllers/error.php", {
            message:'Uw aanvraag is verwerkt, er is een email naar het emailadres gestuurd',
            class: 'alert-success'
        }, function () {

            $('.alert').fadeIn(1000);
        });
    }
}


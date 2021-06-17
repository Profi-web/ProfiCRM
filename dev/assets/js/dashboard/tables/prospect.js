$(document).ready(function () {
    alertify.defaults.transition = "fade";
    alertify.defaults.theme.ok = "btn btn-info btn-sm rounded";
    alertify.defaults.theme.cancel = "btn btn-danger btn-sm rounded";
    alertify.defaults.theme.input = "form-control";
    alertify.defaults.glossary.ok = "Oke";
    alertify.defaults.glossary.cancel = "Annuleren";


    $('.delete_prospect').on('click',function () {
        var id = $(this).attr('id');
        alertify.confirm('Verwijderen',"Weet je zeker dat je dit prospect wilt verwijderen?",
            function(){
                $.ajax({ //Process the form using $.ajax()
                    type: 'POST', //Method typee
                    url: '/controllers/tables/prospect/prospect_delete.php', //Your form processing file URL
                    data: {'id': id}, //Forms name
                    success: function (data) {
                        data = JSON.parse(data);

                        if (data.status === 'success') {
                          window.location.reload();
                        }
                    }
                });
            },
            function(){
            });
    });
});
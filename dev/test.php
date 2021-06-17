<script>
    $('#factureringList .list-group-item').on('click', function () {
        var factureringsID = $(this).data('uid');
        var facturering = $(this).data('facturering');

        var page = $('.activities_table').attr('id');
        var id = $('.currentid').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save_facturering.php?id=' + factureringsID + '&facturering=' + facturering, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering' + factureringsID).modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();

                    $('#company_tasks').load('/controllers/tables/company/company_activities.php?page=' + page + '&id=' + id, function () {
                    });
                } else {
                    $(".alert_field_" + factureringsID).load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

    });

</script>
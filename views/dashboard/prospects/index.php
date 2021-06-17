<?php
/*Page Info*/
$page = 'Prospects';
$type = 'customerbase';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
$pagination = 1;
if (isset($_GET['page'])) {
    $pagination = $_GET['page'];
}
/**/

/*Classes*/
$user = new User();
$table = new Table($pagination, 'prospects', $page);
//

/*CSS*/

$usertheme = new User();
/*Header*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php';
?>
<link rel="stylesheet" href="/assets/css/dashboard.min.css">
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/header.php';
/**/
?>
<!--    HEADER-->

<div class="container-fluid justify-content-center" style="margin-top:-40px;">
    <div class="row px-3 px-md-5">
        <div class="card shadow col-12 p-0">
            <div class="card-header border-0 bg-white rounded-top p-0">
                <div class="px-4">
                    <div class="row p-4 align-items-center justify-content-between">
                        <h5 class="mb-0 ">Alle prospects</h5>
                        <a class="btn btn-info rounded text-white d-block" data-toggle="modal"
                           data-target="#prospectModal">Nieuw prospect</a>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row py-2 px-4 align-items-center justify-content-center justify-content-lg-end prospect_top">
                        <div class="alertField"></div>
                        <div class="pl-4 mt-2 mt-lg-0 list-group position-relative">
                            <div class="input-group">
                                <input type="text" class="form-control relation_search"
                                       placeholder="Plaats zoeken.."
                                       aria-label="Plaats zoeken.."
                                       name="foo" autocomplete="off"
                                       value="" style="border-radius: 15px;width: 300px;">
                                <input type="hidden" id="relation_id"
                                       value=""/>
                                <input type="hidden" id="relation_type"
                                       value=""/>
                                <div class="invalid-feedback">
                                    Vul a.u.b een geldige keuze in
                                </div>
                            </div>
                            <div class="relation_box container position-absolute shadow rounded"
                                 style="z-index: 500;max-height: 500px;overflow: auto;margin-top:40px;">
                                <div class="rounded row bg-light p-2 relation_search_box">
                                    <div class="col-12 py-2 px-4 search_item muted">
                                        <a class="row align-items-center">
                                            <i class="fad fa-search text-primary search_icon"></i>
                                            <div class="pl-2 search_text">Typ om te zoeken</div>
                                        </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-3 mt-2 mt-lg-0  list-group">
                            <div class="input-group date" id="from_date" data-target-input="nearest">
                                <div class="input-group-append" data-target="#from_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fad fa-calendar-alt pl-1"></i></div>
                                </div>
                                <input type="text" class="form-control datetimepicker-input" data-target="#from_date"
                                       placeholder="Start datum"
                                       value=""/>
                            </div>
                        </div>
                        <div class="pl-3 mt-2 mt-lg-0  list-group">
                            <div class="input-group date" id="to_date" data-target-input="nearest">
                                <div class="input-group-append" data-target="#to_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fad fa-calendar-alt pl-1"></i></div>
                                </div>
                                <input type="text" class="form-control datetimepicker-input" data-target="#to_date"
                                       placeholder="Eind datum"
                                       value=""/>
                            </div>
                        </div>
                        <div class="pl-3  mt-2 mt-lg-0 ">
                            <i class="fad fa-search text-grey fahover filterSearch" style="font-size: 24px;"></i>
                            <i class="fad pl-3 fa-file-export text-grey fahover filterExport"
                               style="font-size: 24px;"></i>
                            <input type="hidden" id="exportValue"
                                   value=""/>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="prospectModal" tabindex="-1" role="dialog" aria-labelledby="prospectModal"
                 aria-hidden="true">
                <div class="modal-dialog model-lg" role="document">
                    <div class="modal-content rounded prospectFocus">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nieuwe prospect</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert_field_prospects">

                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item p-0 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-sign"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Prospectsnaam"
                                               aria-label="Prospectsnaam" id="name">
                                    </div>
                                </li>
                                <li class="list-group-item p-0 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                                class="fad fa-phone-office"></i></span>
                                        </div>
                                        <input type="tel" class="form-control" placeholder="Telefoonnummer"
                                               aria-label="Telefoonnummer" id="phonenumber" name="tel">
                                    </div>
                                </li>
                                <li class="list-group-item p-0 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-at"></i></span>
                                        </div>
                                        <input type="email" class="form-control" placeholder="Email"
                                               aria-label="Email" id="email" name="email">
                                    </div>
                                </li>
                                <li class="list-group-item p-0 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-browser"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Website"
                                               aria-label="Website" id="Website" name="Website">
                                    </div>
                                </li>
                                <li class="list-group-item p-0 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Contactpersoon"
                                               aria-label="Contactpersoon" id="contactpersoon">
                                    </div>
                                </li>
                                <li class="list-group-item p-0 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-road"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Adres"
                                               aria-label="Adres" id="address">
                                    </div>
                                </li>
                                <li class="list-group-item p-0 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-map"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Postcode"
                                               aria-label="Postcode"
                                               id="zipcode">
                                    </div>
                                </li>
                                <li class="list-group-item p-0 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-city"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Stad"
                                               aria-label="Stad" id="city">
                                    </div>
                                </li>
                                <li class="list-group-item p-0 py-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-cabinet-filing"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="KvK"
                                               aria-label="KvK" id="kvk">
                                    </div>
                                </li>
                            </ul>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlTextarea1">Activiteit</label>
                                <textarea class="form-control rounded" id="activityText" name="activityText"
                                          rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success rounded text-white" id="saveProspect">
                                Toevoegen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush mb-0 table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Naam</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefoonnummer</th>
                        <th scope="col">Website</th>
                        <th scope="col">Plaats</th>
                        <?php
                        if (isset($_GET['status']) && $_GET['status']) {
                            if ($_GET['status'] == 'asc') {
                                $statusicon = ' <i class="fad fa-sort-alpha-up"></i>';
                            } elseif ($_GET['status'] == 'desc') {
                                $statusicon = ' <i class="fad fa-sort-alpha-down"></i>';
                            } else {
                                $statusicon = '';
                            }
                        } else {
                            $statusicon = '';
                        }
                        ?>
                        <th scope="col">KvK</th>
                        <th scope="col" id="status">Laatste activiteit <?php echo $statusicon; ?></i></th>
                        <th scope="col">Opvolg datum</th>
                        <th scope="col">Acties</th>
                    </tr>
                    </thead>
                    <tbody class="prospects_table" id="<?php echo $table->currentpage; ?>">
                    </tbody>
                </table>
            </div>
            <div class="card-footer py-4 bg-white rounded-bottom">
                <nav aria-label="...">
                    <ul class="pagination justify-content-center justify-content-md-end mb-0">

                        <?php
                        $table->showPagination();
                        ?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="bottom_notes">Profi-crm versie <?php $versions = new Versions();
    echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/prospects.js"></script>
<style>
    .alertField #alert {
        margin-bottom: 0px !important;
    }
</style>
<script>
    alertify.defaults.transition = "fade";
    alertify.defaults.theme.ok = "btn btn-info btn-sm rounded";
    alertify.defaults.theme.cancel = "btn btn-danger btn-sm rounded";
    alertify.defaults.theme.input = "form-control";
    alertify.defaults.glossary.ok = "Oke";
    alertify.defaults.glossary.cancel = "Annuleren";
    var url = new URL(window.location.href);

    if (url.searchParams.get('export')) {
        if (url.searchParams.get('export') == 'true') {
            var alertifyObject = alertify.notify('', 'success');
            alertifyObject.setContent("<img src='/assets/media/bun.gif' width='50px' height='50px' class='spinner'/> Bezig met downloaden");
            //
            var to_date = '';
            if (url.searchParams.get('to_date')) {
                to_date = url.searchParams.get('to_date');
            }
            var city = '';
            if (url.searchParams.get('city')) {
                city = url.searchParams.get('city');
            }
            var from_date = '';
            if (url.searchParams.get('from_date')) {
                from_date = url.searchParams.get('from_date')
            }
            var d = new Date();
            fetch('https://profi-crm.nl/controllers/search/prospects_csv.php?city=' + city + '&from_date=' + from_date + '&to_date=' + to_date)
                .then(resp => resp.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    // the filename you want
                    a.download = 'prospects_' + city + '_' + d.getDay() + '-' + d.getMonth() + '-' + d.getFullYear() + '.csv';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    alertifyObject.dismiss();
                    var alertifyObject1 = alertify.notify('', 'success');
                    alertifyObject1.setContent("Gedownload!");
                    //
                })
                .catch((er) => dismissError(er));
            //

            url.searchParams.delete('export');
            window.history.pushState('', '', url);

        }
    }

    function dismissError(er) {
        alertifyObject.dismiss();
        var alertifyObject2 = alertify.notify('', 'error');
        alertifyObject2.setContent("Oeps!!"+er);
    }

    tinymce.init({
        plugins: "autolink link",
        selector: '#activityText',
        branding: false,
        body_class: "rounded",
        mobile: {
            theme: 'silver'
        },
        menubar: false,
        relative_urls: true,
        forced_root_block: "",
        paste_data_images: true,
        invalid_elements: "script,img,iframe",
        toolbar: " redo | undo | bold | italic | link | unlink",
        default_link_target: "_blank"
    });
    tinymce.triggerSave();
    $(function () {
        var url = new URL(window.location.href);
        var city = '';
        if (url.searchParams.get('city')) {
            city = url.searchParams.get('city');
        }
        $('.relation_search').val(city);

        var from_date = '';
        if (url.searchParams.get('from_date')) {
            from_date = url.searchParams.get('from_date');
        }
        $('#from_date input').val(from_date);

        var to_date = '';
        if (url.searchParams.get('to_date')) {
            to_date = url.searchParams.get('to_date');
        }
        $('#to_date input').val(to_date);


        $('#from_date').datetimepicker({
            locale: 'nl',
            icons: {
                time: "fad fa-clock",
                date: "fad fa-calendar",
                up: "fad fa-arrow-up",
                down: "fad fa-arrow-down"
            },
            format: 'L',
            useCurrent: true
        });

        $('#to_date').datetimepicker({
            locale: 'nl',
            icons: {
                time: "fad fa-clock",
                date: "fad fa-calendar",
                up: "fad fa-arrow-up",
                down: "fad fa-arrow-down"
            },
            format: 'L',
            useCurrent: true
        });
    });

    $(window).click(function () {

        /*WERKZAAMHEID*/
        $('.relation_box').hide();
        /**/
    });

    /*WERKZAAMHEDEN*/
    $('.relation_search').on('click', function (event) {
        event.stopPropagation();
        $('.relation_box').show();
    });
    /****************/


    /*SEARCH*/

    $('.relation_search').on("keyup input", function (e) {
        var defaultInput0 = '<div class="col-12 py-2 px-4 search_item muted">\n' +
            '                                                <a class="row align-items-center">\n' +
            '                                                    <i class="fad fa-search text-primary search_icon"></i>\n' +
            '                                                    <div class="pl-2 search_text">Typ om te zoeken</div>' +
            '                                                </a>\n' +
            '                                            </div>';
        var defaultInput1 = '<div class="col-12 py-2 px-4 search_item muted">\n' +
            '                                                <a class="row align-items-center">\n' +
            '                                                    <i class="fad fa-search text-primary search_icon"></i>\n' +
            '                                                    <div class="pl-2 search_text">Typ minimaal 2 tekens om te zoeken</div>' +
            '                                                </a>\n' +
            '                                            </div>';

        var inputVal = $('.relation_search').val();
        var resultDropdown = $('.relation_search_box');
        if (inputVal.length >= 2) {

            $.get("/controllers/search/place_search.php", {term: inputVal}).done(function (data) {
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else if (inputVal.length = 1) {
            resultDropdown.html(defaultInput1);
        } else {
            resultDropdown.html(defaultInput0);
        }
    });


    /**//**//**/
    $(".filterSearch").on('click', function () {
        var url = new URL(window.location.href);
        var relation_search = '';
        if ($('.relation_search').val()) {
            relation_search = $('.relation_search').val();
            url.searchParams.set('city', relation_search);
        } else {
            url.searchParams.delete('city');
        }

        var from_date = '';
        if ($('#from_date input').val()) {
            from_date = $('#from_date input').val();
            url.searchParams.set('from_date', from_date);
        } else {
            url.searchParams.delete('from_date');
        }

        var to_date = '';
        if ($('#to_date input').val()) {
            to_date = $('#to_date input').val();
            url.searchParams.set('to_date', to_date);
        } else {
            url.searchParams.delete('to_date');
        }
        if (to_date != '' || from_date != '') {
            if (to_date != '' && from_date != '') {
                window.location.href = url;
            } else {
                $(".alertField").load("/controllers/error.php", {
                    message: 'Je moet beide datums in vullen',
                    class: 'alert-danger'
                }, function () {

                    $('.alert').fadeIn(1000);
                });
            }
        } else {
            window.location.href = url;
        }
    });


    $(".filterExport").on('click', function () {
        var url = new URL(window.location.href);
        var relation_search = '';
        if ($('.relation_search').val()) {
            relation_search = $('.relation_search').val();
            url.searchParams.set('city', relation_search);
        } else {
            url.searchParams.delete('city');
        }


        var from_date = '';
        if ($('#from_date input').val()) {
            from_date = $('#from_date input').val();
            url.searchParams.set('from_date', from_date);
        } else {
            url.searchParams.delete('from_date');
        }

        var to_date = '';
        if ($('#to_date input').val()) {
            to_date = $('#to_date input').val();
            url.searchParams.set('to_date', to_date);
        } else {
            url.searchParams.delete('to_date');
        }
        if (relation_search) {
            if (to_date != '' || from_date != '') {
                if (to_date != '' && from_date != '') {

                    url.searchParams.set('export', 'true');
                    window.location.href = url;
                } else {
                    $(".alertField").load("/controllers/error.php", {
                        message: 'Je moet beide datums in vullen voor exporteren',
                        class: 'alert-danger'
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            } else {
                url.searchParams.set('export', 'true');
                window.location.href = url;
            }

        } else {
            if (to_date != '' || from_date != '') {
                if (to_date == '' || from_date == '') {
                    $(".alertField").load("/controllers/error.php", {
                        message: 'Je moet een van de twee in vullen',
                        class: 'alert-danger'
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                } else {
                    url.searchParams.set('export', 'true');
                    window.location.href = url;
                }
            } else {
                url.searchParams.set('export', 'true');
                window.location.href = url;
            }

        }
    });


    $('#status').on('click', function () {
        var url = new URL(window.location.href);
        if (url.searchParams.get('status')) {
            var status = url.searchParams.get('status');
            if (status === 'desc') {

                url.searchParams.set('status', 'asc');
            } else {
                url.searchParams.set('status', 'desc');
            }
        } else {
            url.searchParams.set('status', 'desc');
        }
        window.location.href = url;
    });

    $('#saveProspect').on("click", function (e) {
        sendNewProspect();
    });


    function sendNewProspect() {

        if ($('#name').val() === '') {
            $('#name').addClass('is-invalid');
        } else {
            $('#name').removeClass('is-invalid');
        }

        if ($('#phonenumber').val() !== '') {
            if (!$.isNumeric($('#phonenumber').val())) {
                $('#phonenumber').addClass('is-invalid');
            } else {
                $('#phonenumber').removeClass('is-invalid');
            }
        }

        if ($('#email').val() !== '') {
            if (!isValidEmailAddress($('#email').val())) {
                $('#email').addClass('is-invalid');
            } else {
                $('#email').removeClass('is-invalid');
            }
        }
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/prospect/prospect_save.php', //Your form processing file URL
            data: {
                name: $('#name').val(),
                phonenumber: $('#phonenumber').val(),
                email: $('#email').val(),
                website: $('#Website').val(),
                address: $('#address').val(),
                activityText: tinymce.get('activityText').getContent(),
                zipcode: $('#zipcode').val(),
                city: $('#city').val(),
                kvk: $('#kvk').val(),
                contactpersoon: $('#contactpersoon').val(),
            }, //Forms name
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
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

                    var id = $('.prospects_table').attr('id')
                    $('.prospects_table').load('/controllers/tables/prospect/prospects.php?page=' + id + statussearch + citysearch + from_dateseearch + to_datesearch, function () {
                    });
                    $('#prospectModal').modal('hide');
                    $('#name').val("");
                    $('#name').removeClass('is-invalid');
                    $('#phonenumber').val("");
                    $('#phonenumber').removeClass('is-invalid');
                    $('#email').val("");
                    $('#email').removeClass('is-invalid');
                    $('#website').val("");
                    $('#website').removeClass('is-invalid');
                    $('#address').val("");
                    $('#address').removeClass('is-invalid');
                    $('#zipcode').val("");
                    $('#zipcode').removeClass('is-invalid');
                    $('#city').val("");
                    $('#city').removeClass('is-invalid');
                    $('#contactpersoon').val("");
                    $('#contactpersoon').removeClass('is-invalid');
                } else {
                    $(".alert_field_prospects").load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });
    }

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    };
</script>
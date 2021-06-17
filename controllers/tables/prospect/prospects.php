<?php

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
$table = new Table($pagination, 'prospects', 'prospects');
$prospects = new Prospects('', $table->limit);

$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();

/**/

if (isset($_GET['status']) && $_GET['status']) {
    if ($_GET['status'] === "desc" || $_GET['status'] === "asc") {
        $statussort = strtoupper($_GET['status']);
    } else {
        $statussort = '';
    }
} else {
    $statussort = '';
}

if (isset($_GET['city']) && $_GET['city']) {
    if (!empty($_GET['city'])) {
        $citysort = $_GET['city'];
    } else {
        $citysort = '';
    }
} else {
    $citysort = '';
}

if (isset($_GET['from_date']) && $_GET['from_date']) {
    if (!empty($_GET['from_date'])) {
        $from_datesort = $_GET['from_date'];
        $from_datesort = strtotime($from_datesort);
        $from_datesort = date('Y-m-d', $from_datesort);
    } else {
        $from_datesort = '';
    }
} else {
    $from_datesort = '';
}

if (isset($_GET['to_date']) && $_GET['to_date']) {
    if (!empty($_GET['to_date'])) {
        $to_datesort = $_GET['to_date'];
        $to_datesort = strtotime($to_datesort);
        $to_datesort = date('Y-m-d', $to_datesort);
    } else {
        $to_datesort = '';
    }
} else {
    $to_datesort = '';
}

if (!$to_datesort || !$from_datesort) {
    $to_datesort = '';
    $from_datesort = '';
}

/*Variables*/
/**/
$search = $prospects->findAll($table->startfrom, $table->limit, $statussort, $citysort, $from_datesort, $to_datesort);
if ($search) {
    foreach ($search as $prospect) {
        ?>
        <tr id="<?php echo $prospect['id'] ?>">
            <td scope="row" class="clickable">
                <?php echo $prospect['name'] ?> <span class="text-muted op-50"> #<?php echo $prospect['id'] ?></span>
            </td>
            <td class="clickable">
                <?php echo $prospect['email'] ?>
            </td>
            <td class="clickable">
                <?php echo $prospect['phonenumber'] ?>
            </td>
            <td <?php if($prospect["website"] ){ ?> onclick="window.open( '<?php echo $prospect["website"] ?>','_blank');"<?php } ?> class="fahover">
                <?php echo $prospect['website'] ?>
            </td>
            <td clas="clickable">
                <?php echo $prospect['city'] ?>
            </td>
            <td clas="clickable">
                <?php echo $prospect['kvk'] ?>
            </td>
            <td class="clickable">
                <?php echo $prospects->getStatus($prospect['status']); ?>
            </td>
            <td class="clickable">
                <?php
                if ($prospect['date'] != '0000-00-00') {
                    $date = strtotime($prospect['date']);
                    $date = date('d-m-Y', $date);

                    echo $date;
                } else {
                    echo '-';
                } ?>
            </td>
            <td class="">
                <!--                <i class="fad fa-exchange-alt text-purple fahover"></i>-->
                <i class="fad fa-trash-alt text-danger fahover deleteProspect" id="<?php echo $prospect['id']; ?>"></i>
            </td>
        </tr>
        <?php
    }
} else {
    ?>
    <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    <?php
}
?>

<script>

    function openInNewTab(url) {
        var win = window.open(url, '_blank');
        win.focus();
    }
    $('body').mousedown(function(e){if(e.button==1)return false});
    $('tbody .clickable').on("mousedown", function (e) {
        if (e.which <= 2) {
            if (e.which == 1) {
                window.location.href = '/prospect?id=' + $(this).parent().attr('id');
            } else if (e.which == 2) {
                openInNewTab('/prospect?id=' + $(this).parent().attr('id'));
            }
        }
    });
    alertify.defaults.transition = "fade";
    alertify.defaults.theme.ok = "btn btn-info btn-sm rounded";
    alertify.defaults.theme.cancel = "btn btn-danger btn-sm rounded";
    alertify.defaults.theme.input = "form-control";
    alertify.defaults.glossary.ok = "Oke";
    alertify.defaults.glossary.cancel = "Annuleren";
    $('.deleteProspect').on('click', function () {

        var id = $(this).attr('id');
        alertify.confirm('Verwijderen', "Weet je zeker dat je dit wilt verwijderen?",
            function () {
                $.ajax({ //Process the form using $.ajax()
                    type: 'POST', //Method type
                    url: '/controllers/tables/prospect/prospect_delete.php', //Your form processing file URL
                    data: {'id': id}, //Forms name
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
                        }
                    }
                });
            },
            function () {
            });
    });

</script>

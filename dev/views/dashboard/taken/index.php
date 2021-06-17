<?php
/*Page Info*/
$page = 'Taken';
$type = 'activities';
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


if (isset($_GET['id'])) {
    if ($_GET['id'] === 'all') {
        $current_employee = new User();
        $id = 'all';
        $current_employee->all = true;
    } else {
        $current_employee = new User($_GET['id']);
        $id = $current_employee->data['id'];
    }
} else {
    $current_employee = new User();
    $id = $current_employee->data['id'];
}


$table = new TableActivity($pagination, 'activities', $page, $id);
//

/*CSS*/
?>
<?php

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
            <div class="card-header border-0 bg-white rounded-top p-4">
                <div class="row px-4 align-items-center justify-content-between">
                    <?php

                    if ($current_employee->all) {
                        ?>
                        <h5 class="mb-0 ">Alle taken</h5>
                        <?php
                    } else {
                        if (!isset($_GET['id'])) {
                            ?>
                            <h5 class="mb-0 ">Jouw taken</h5>
                            <?php
                        } else {
                            if ($_GET['id'] == $_SESSION['userid']) {
                                ?>
                                <h5 class="mb-0 ">Jouw taken</h5>
                                <?php
                            } else {
                                ?>
                                <h5 class="mb-0 "><?php echo $current_employee->data['name']; ?> taken</h5>
                                <?php
                            }
                        }
                    }


                    ?>
                    <a class="btn btn-info rounded text-white newActivity"
                       id="<?php echo $current_employee->data['id']; ?> ">Nieuwe taak</a>

                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush mb-0 table-hover">
                    <thead class="thead-light">
                    <tr>
                        <?php
                        if (isset($_GET['datum']) && $_GET['datum']) {
                            if ($_GET['datum'] == 'asc') {
                                $datumicon = ' <i class="fad fa-sort-alpha-up"></i>';
                            } elseif ($_GET['datum'] == 'desc') {
                                $datumicon = ' <i class="fad fa-sort-alpha-down"></i>';
                            } else {
                                $datumicon = '';
                            }
                        } else {
                            $datumicon = '';
                        }
                        ?>
                        <th scope="col" id="datumColumn">Datum<?php echo $datumicon; ?></th>
                        <th scope="col">ID</th>
                        <?php
                        if (isset($_GET['id']) && $_GET['id'] === 'all') {
                            ?>
                            <th scope="col">Medewerker</th>
                            <?php
                        }
                        ?>
                        <th scope="col">Info</th>
                        <th scope="col">Relatie</th>
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
                        <th scope="col" id="status">Status <?php echo $statusicon; ?></i></th>
                        <?php
                        if (isset($_GET['gefactureerd']) && $_GET['gefactureerd']) {
                            if ($_GET['gefactureerd'] == 'asc') {
                                $gefactureerdicon = ' <i class="fad fa-sort-alpha-up"></i>';
                            } elseif ($_GET['gefactureerd'] == 'desc') {
                                $gefactureerdicon = ' <i class="fad fa-sort-alpha-down"></i>';
                            } else {
                                $gefactureerdicon = '';
                            }
                        } else {
                            $gefactureerdicon = '';
                        }
                        ?>
                        <th scope="col" id="gefactureerd">Gefactureerd<?php echo $gefactureerdicon; ?></th>
                        <th scope="col">Acties</th>
                    </tr>
                    </thead>
                    <tbody class="activities_table" id="<?php echo $table->currentpage; ?>">
                    </tbody>
                    <input type="hidden" class="currentuser" id="<?php echo $id; ?>"/>
                </table>
            </div>
            <div class="card-footer py-4 bg-white rounded-bottom">
                <div class="d-flex justify-content-between">
                    <div id="print_hider"><i class="fa fahover fa-print fa-2x"></i></div>
                    <nav aria-label="...">
                        <ul class="pagination justify-content-center justify-content-md-end mb-0">

                            <?php
                            $table->showPaginationId($id);
                            ?>

                        </ul>
                    </nav>
                </div>
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
<script src="/assets/js/dashboard/tables/activities.js"></script>
<script>
    $('#gefactureerd').on('click', function () {
        var url = new URL(window.location.href);
        if (url.searchParams.get('gefactureerd')) {
            ;
            var status = url.searchParams.get('gefactureerd');
            if (status === 'desc') {

                url.searchParams.set('gefactureerd', 'asc');
                url.searchParams.delete('status');
                url.searchParams.delete('datum');
            } else {
                url.searchParams.set('gefactureerd', 'desc');
                url.searchParams.delete('status');
                url.searchParams.delete('datum');
            }
        } else {
            url.searchParams.set('gefactureerd', 'desc');
            url.searchParams.delete('status');
            url.searchParams.delete('datum');
        }
        window.location.href = url;
    });

    $('.newActivity').on('click', function () {
        var id = $(this).attr('id');
        window.location.href = '/taken/nieuw?id=' + id;
    });
    $('#status').on('click', function () {
        var url = new URL(window.location.href);
        if (url.searchParams.get('status')) {
            ;
            var status = url.searchParams.get('status');
            if (status === 'desc') {

                url.searchParams.set('status', 'asc');
                url.searchParams.delete('gefactureerd');
                url.searchParams.delete('datum');
            } else {
                url.searchParams.set('status', 'desc');
                url.searchParams.delete('gefactureerd');
                url.searchParams.delete('datum');
            }
        } else {
            url.searchParams.set('status', 'desc');
            url.searchParams.delete('gefactureerd');
            url.searchParams.delete('datum');
        }
        window.location.href = url;
    });
    $('#datumColumn').on('click', function () {
        var url = new URL(window.location.href);
        if (url.searchParams.get('datum')) {
            ;
            var status = url.searchParams.get('datum');
            if (status === 'desc') {

                url.searchParams.set('datum', 'asc');
                url.searchParams.delete('gefactureerd');
                url.searchParams.delete('status');
            } else {
                url.searchParams.set('datum', 'desc');
                url.searchParams.delete('gefactureerd');
                url.searchParams.delete('status');
            }
        } else {
            url.searchParams.set('datum', 'desc');
            url.searchParams.delete('gefactureerd');
            url.searchParams.delete('status');
        }
        window.location.href = url;
    });
</script>

<?php
/*Page Info*/
$page = 'Procedures';
$type = 'procedures';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
$pagination = 1;
if(isset($_GET['page'])){
    $pagination = $_GET['page'];
}
/**/

/*Classes*/
$user = new User();
$table = new Table($pagination,'procedures',$page);
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
                    <h5 class="mb-0 ">Alle procedures!</h5>
                    <a class="btn btn-info rounded text-white" href="/procedures/nieuw">Nieuwe procedures</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush mb-0 table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Titel</th>
                        <th scope="col">Tekst</th>
                    </tr>
                    </thead>
                    <tbody class="procedures_table" id="<?php echo $table->currentpage; ?>">
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
<div class="bottom_notes">Profi-crm versie <?php $versions = new Versions(); echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/procedures.js"></script>
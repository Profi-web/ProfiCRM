<?php
/*Page Info*/
$page = 'Werkzaamheden';
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
    if($_GET['id'] === 'all'){
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


$table = new Table($pagination, 'users', $page);
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

                    if($current_employee->all){
                        ?>
                        <h5 class="mb-0 ">Alle werkzaamheden</h5>
                        <?php
                    } else {
                        if (!isset($_GET['id'])) {
                            ?>
                            <h5 class="mb-0 ">Jouw werkzaamheden</h5>
                            <?php
                        } else {
                            if ($_GET['id'] == $_SESSION['userid']) {
                                ?>
                                <h5 class="mb-0 ">Jouw werkzaamheden</h5>
                                <?php
                            } else {
                                ?>
                                <h5 class="mb-0 "><?php echo $current_employee->data['name']; ?> werkzaamheden</h5>
                                <?php
                            }
                        }
                    }


?>
                        <a class="btn btn-info rounded text-white" href="/werkzaamheden/nieuw" id="<?php echo $current_employee->data['id']; ?> ">Nieuwe werkzaamheid</a>

                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush mb-0 table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col"  id="datumColumn">Datum</th>
                        <th scope="col">ID</th>
                        <?php
                        if(isset($_GET['id']) && $_GET['id'] === 'all'){
                            ?>
                            <th scope="col">Medewerker</th>
                            <?php
                        }
                        ?>
                        <th scope="col">Info</th>
                        <th scope="col">Relatie</th>
                        <th scope="col" id="statusColumn">Status</th>
                    </tr>
                    </thead>
                    <tbody class="activities_table" id="<?php echo $table->currentpage; ?>">
                    </tbody>
                    <input type="hidden" class="currentuser" id="<?php echo $id;?>"/>
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
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/activities.js"></script>
<script>
    $('#statusColumn').on('click',function () {
        var url = new URL(window.location.href);
        if(url.searchParams.get('status')){
            console.log(1);
            var status = url.searchParams.get('status');
            if(status === 'desc'){
                console.log(status);
                url.searchParams.set('status','asc');
            } else {
                url.searchParams.set('status','desc');
            }
        } else{
            url.searchParams.set('status','desc');
        }
        window.location.href= url;
    });
    $('#datumColumn').on('click',function () {
        var url = new URL(window.location.href);
        if(url.searchParams.get('datum')){
            console.log(1);
            var status = url.searchParams.get('datum');
            if(status === 'desc'){
                console.log(status);
                url.searchParams.set('datum','asc');
            } else {
                url.searchParams.set('datum','desc');
            }
        } else{
            url.searchParams.set('datum','desc');
        }
        window.location.href= url;
    });
</script>

<?php
/*Page Info*/
$page = 'Changelog';
$type = 'changelog';
/**/
setlocale(LC_ALL, 'nl_NL');
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
$table = new Table($pagination, 'companies', $page);
//

$versions = new Versions();

/*CSS*/


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
                    <h5 class="mb-0 ">Changelog</h5>
                    <?php
                    if($user->data['role'] == 1 || $user->data['role'] == 4){
                        ?>
                        <a class="btn btn-info rounded text-white" href="/change-log/nieuw">Nieuwe versie</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush mb-0 table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Versie</th>
                            <th scope="col">Datum</th>
                            <th scope="col">Info</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($versions->findAll() as $version) {
                            ?>
                            <tr data-toggle="modal" data-target="#version<?php echo $version['id'];?>">
                                <td style="width:10%"><?php echo $version['version']; ?></td>
                                <td style="width:20%"><?php echo strftime("%e %B %Y", strtotime($version['date'])); ?></td>
                                <td> <?php echo $versions->getExcerpt($version['short-description']); ?></td>
                                <div class="modal fade" id="version<?php echo $version['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content rounded">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="">Versie: <?php echo $version['version']; ?>  <span class="text-muted" style="font-size:15px;"><?php echo strftime("%e %B %Y", strtotime($version['date'])); ?></span></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo $version['description'];?>
                                            </div>
                                            <div class="modal-footer">
                                                <?php
                                                if($user->data['role'] == 1 || $user->data['role'] == 4) {
                                                    ?>
                                                    <button type="button" class="btn btn-danger rounded delete_version"
                                                            data-dismiss="modal" id="<?php echo $version['id']; ?>">
                                                        Verwijderen
                                                    </button>
                                                    <?php
                                                }
                                                ?>
                                                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Sluiten</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4 bg-white rounded-bottom">
                <div class="bottom_notes">Profi-crm versie <?php echo $versions->findLatest()[0]['version']; ?>
                    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
                    <a href="/change-log">Wat is er nieuw?</a></div>
            </div>
        </div>
    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/version.js"></script>


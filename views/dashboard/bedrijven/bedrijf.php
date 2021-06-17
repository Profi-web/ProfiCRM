<?php
/*Page Info*/
$page = 'Bedrijf';
$type = 'customerbase';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

$pagination = 1;
if (isset($_GET['page'])) {
    $pagination = $_GET['page'];
}

$paginationOrders = 1;
if (isset($_GET['pageOrders'])) {
    $paginationOrders = $_GET['pageOrders'];
}
$files = new Files(null, 'company_files');

/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: /404');
}
/**/


/*Classes*/
$user = new User();
$company = new Company($id);
//
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
    <div class="row px-3 px-md-5 justify-content-between">
        <div class="p-0 col-12 col-xl-9 pr-xl-4 mb-4">
            <div class="card shadow" id="company_info" style="min-height: 100px;">
                <div class="card-header border-0 bg-white rounded-top p-3">
                    <div class="row px-4 align-items-center justify-content-between">
                        <div class="d-flex">
                            <div style="width:95px;height:25px;background:#3082c1;opacity:0.05; border-radius: 5px;"
                                 class="mr-2"></div>
                            <div style="width:140px;height:25px;background:#fafafa; border-radius: 5px;"></div>
                        </div>
                        <div style="width:82px;height:31px;background:#3082c1;opacity:0.05; border-radius: 5px;"></div>
                    </div>
                </div>
                <div class="container-fluid  bg-light-second py-3 rounded-bottom">
                    <div class="row p-3">
                        <div class="col-12">
                            <div class="text-primary pb-3">
                                <div style="width:80px;height:20px;background:#3082c1;opacity:0.08; border-radius: 5px;"></div>
                            </div>
                            <div class="bg-white p-3 rounded" style="min-height: 75px">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-4" id="company_files" style="min-height: 100px;">
                <div class="card-header border-0 bg-white rounded-top p-4">
                    <div class="row px-4 align-items-center justify-content-between">
                        <div style="width:95px;height:25px;background:#fafafa; border-radius: 5px;"></div>
                        <div style="width:82px;height:31px;background:#3082c1;opacity:0.05; border-radius: 5px;"></div>
                    </div>
                </div>
                <div class="container-fluid  bg-light-second py-3 rounded-bottom">
                    <div class="row p-3">
                        <?php
                        $count = $files->db->count('company_files',['relation'=> $id ]);
                        if ($count > 0) {
                            for ($i = 0; $i < $count; $i++) {
                                ?>
                                <div class="col-6 col-md-4 col-lg-3 py-3">
                                    <div class="bg-white rounded p-3 ">
                                        <div class="row">
                                            <div class="col-12 text-center py-2 openFile d-flex justify-content-center">
                                                <div style="width:25%;height:60px;background:#fcfcfc;border-radius:5px;"></div>
                                            </div>
                                            <div class="col-12 text-center d-flex justify-content-center pb-2">
                                                <div style="border-radius:5px;background:#fafafa;width:60%;height:15px;"></div>
                                            </div>
                                            <div class="col-12 text-center d-flex justify-content-center  text-muted"
                                                 style="font-size:13px;">
                                                <div style="border-radius:5px;background:#fafafa;width:20%;height:15px;"></div>
                                            </div>
                                            <div class="col-12 text-center pt-2 d-flex justify-content-center">
                                                <div style="border-radius:5px;background:#fcfcfc;width:10%;height:15px;margin:0px 2px;"></div>
                                                <div style="border-radius:5px;background:#fcfcfc;width:10%;height:15px;margin:0px 2px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="col-12">
                                <div class="bg-white rounded p-3 ">
                                    <div class="row">
                                        <div class="col-12 text-muted">
                                            <div style="border-radius:5px;background:#fcfcfc;width:10%;height:15px;margin:0px 2px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-4" id="company_tasks" style="min-height: 100px;"
                 data-page="<?php echo $pagination; ?>">
                <!--COMPANY TASKTS-->


                <div class="card-header border-0 bg-white rounded-top p-4">
                    <div class="row px-4 align-items-center justify-content-between">
                        <div style="width:95px;height:25px;background:#fafafa; border-radius: 5px;"></div>
                        <div style="width:82px;height:31px;background:#3082c1;opacity:0.05; border-radius: 5px;"></div>
                    </div>
                </div>
                <div class="container-fluid  bg-white p-0 rounded-bottom">
                    <div class="row p-0">
                        <div class="col-12">
                            <div class="w-100"></div>
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush mb-0 table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">
                                            <div style="width:70%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                        <th scope="col">
                                            <div style="width:70%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                        <th scope="col">
                                            <div style="width:30%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                        <th scope="col">
                                            <div style="width:50%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                        <th scope="col">
                                            <div style="width:50%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                        <th scope="col">
                                            <div style="width:90%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="">
                                        <?php
                                        $skeletonTable = '<div style="width:90%;height:25px;background:#fcfcfc; border-radius: 5px;"></div>';
                                        ?>
                                        <td valign="middle" width="10%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                        <td valign="middle" width="10%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                        <td valign="middle" width="30%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                        <td valign="middle" width="12%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                        <td valign="middle" width="12%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                        <td valign="middle" width="6%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-4 bg-white rounded-bottom d-flex justify-content-end">
                    <div style="width:82px;height:31px;background:#fafafa; border-radius: 5px;" class="mr-2"></div>
                </div>


                <!--___________________-->
            </div>
            <div class="card shadow mt-4" id="company_orders" style="min-height: 100px;"
                 data-page="<?php echo $paginationOrders; ?>">

                <!--COMPANYT OORDER-->

                <div class="card-header border-0 bg-white rounded-top p-4">
                    <div class="row px-4 align-items-center justify-content-between">
                        <div style="width:95px;height:25px;background:#fafafa; border-radius: 5px;"></div>
                        <div style="width:82px;height:31px;background:#3082c1;opacity:0.05; border-radius: 5px;"></div>
                    </div>
                </div>
                <div class="container-fluid  bg-white p-0 rounded-bottom">
                    <div class="row p-0">
                        <div class="col-12">
                            <div class="w-100"></div>
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush mb-0 table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">
                                            <div style="width:70%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                        <th scope="col">
                                            <div style="width:70%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                        <th scope="col">
                                            <div style="width:30%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                        <th scope="col">
                                            <div style="width:50%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                        <th scope="col">
                                            <div style="width:50%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                        <th scope="col">
                                            <div style="width:90%;height:25px;background:#f0f3f6; border-radius: 5px;"></div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="">
                                        <?php
                                        $skeletonTable = '<div style="width:90%;height:25px;background:#fcfcfc; border-radius: 5px;"></div>';
                                        ?>
                                        <td valign="middle" width="10%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                        <td valign="middle" width="10%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                        <td valign="middle" width="30%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                        <td valign="middle" width="12%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                        <td valign="middle" width="12%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                        <td valign="middle" width="6%">
                                            <?php echo $skeletonTable; ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-4 bg-white rounded-bottom d-flex justify-content-end">
                    <div style="width:82px;height:31px;background:#fafafa; border-radius: 5px;" class="mr-2"></div>
                </div>

                <!------------->
            </div>
        </div>
        <div class="col-12 col-xl-3 pl-md-3 pr-md-3">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="card shadow " id="company_contact" style="min-height: 404px;">

                        <div class="card-header border-0 bg-light-second rounded-top p-3">
                            <div class="row px-4 align-items-center justify-content-between">
                                <div style="width:95px;height:25px;background:#f4f4f4; border-radius: 5px;"></div>
                                <div style="width:82px;height:31px;background:#3082c1;opacity:0.05; border-radius: 5px;"></div>
                            </div>
                        </div>
                        <div class="container-fluid p-4 rounded-bottom rounded-top">
                            <div class="row">
                                <div class="col-12 ">
                                    <ul class="list-group list-group-flush">
                                        <?php
                                        for($i = 0;$i < 6; $i++) {
                                            ?>
                                            <li class="list-group-item" style="border-color: rgba(170,170,170,0.12);">
                                                <div class="pl-1 row">
                                                    <div style="width:25px;height:25px;background:#fbfbfb; border-radius: 5px;margin-right: 7px;"></div>
                                                    <div style="width:95px;height:25px;background:#fbfbfb; border-radius: 5px;"></div>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>

                                </div>
                            </div>


                        </div>
                    </div>
                    <?php
                    if (!empty(trim($company->getData('address')))) {
                        ?>
                        <div class="col-12 p-0">
                            <div class="card shadow mt-4" id="company_address">
                                <div class="card-header border-0 bg-light-second rounded-top p-3">
                                    <div class="row px-4 align-items-center justify-content-between">
                                        <div style="width:95px;height:25px;background:#f4f4f4; border-radius: 5px;"></div>
                                    </div>
                                </div>
                                <div style="height:300px;width: 100%;"></div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-12 p-0">
                        <div class="card shadow mt-4" id="company_delete_single">
                            <div class="card-header border-0 bg-light-second rounded-top p-3">
                                <div class="row px-4 align-items-center justify-content-between">
                                    <div style="width:95px;height:25px;background:#f4f4f4; border-radius: 5px;"></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="width:82px;height:31px;background:#c11d31;opacity:0.05; border-radius: 5px;"></div>
                            </div>
                        </div>
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
    <script src="/assets/js/dashboard/tables/company.js"></script>
    <script src="/assets/js/dashboard/tables/companies.js"></script>
    <script>
        $(document).ready(function () {
            $('#company_contact').load('/controllers/tables/company/company_contact_single.php?id=<?php echo $company->getData('id') ?>', function () {
            });

            $('#company_address').load('/controllers/tables/company/company_address.php?id=<?php echo $company->getData('id') ?>', function () {
            });

            $('#company_delete_single').load('/controllers/tables/company/company_delete_single.php?id=<?php echo $company->getData('id') ?>', function () {
            });

            $('#company_info').load('/controllers/tables/company/company_info_single.php?id=<?php echo $company->getData('id') ?>', function () {
            });

            $('#company_files').load('/controllers/tables/company/company_files.php?id=<?php echo $company->getData('id') ?>', function () {
            });
            var page = $('#company_tasks').data('page');
            $('#company_tasks').load('/controllers/tables/company/company_activities.php?id=<?php echo $company->getData('id') ?>&page=' + page, function () {
            });
            var page = $('#company_orders').data('page');
            $('#company_orders').load('/controllers/tables/company/company_orders.php?id=<?php echo $company->getData('id') ?>&pageOrders=' + page, function () {
            });
        });
    </script>
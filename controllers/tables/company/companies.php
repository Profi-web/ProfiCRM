<?php


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
$table = new Table($pagination,'companies','bedrijven');
$companies = new Companies('',$table->limit);
$loginValidate = new validateLogin();
$loginValidate->securityCheck();
/**/

/*Variables*/
/**/

foreach($companies->findAll($table->startfrom,$table->limit) as $company) {
    ?>
    <tr id="<?php echo $company['id'] ?>" class="<?php if($company['status'] == 2){ echo 'suspended-class';}?>">
        <td scope="row">
            <?php echo $company['name'] ?> <span class="text-muted op-50"> #<?php echo $company['id'] ?></span>
        </td>
        <td>
            <?php echo $company['email'] ?>
        </td>
        <td>
            <?php echo $company['phonenumber'] ?>
        </td>
    </tr>
    <?php
}
?>

<script>
    $('tbody tr').on('click',function () {
       window.location.href = '/bedrijf?id='+$(this).attr('id');
    });
</script>

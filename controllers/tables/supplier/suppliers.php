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
$table = new Table($pagination,'suppliers','leveranciers');
$suppliers = new Suppliers('',$table->limit);

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/

/*Variables*/
/**/

foreach($suppliers->findAll($table->startfrom,$table->limit) as $supplier) {
    ?>
    <tr id="<?php echo $supplier['id'] ?>">
        <td scope="row">
            <?php echo $supplier['name'] ?> <span class="text-muted op-50"> #<?php echo $supplier['id'] ?></span>
        </td>
        <td>
            <?php echo $supplier['email'] ?>
        </td>
        <td>
            <?php echo $supplier['phonenumber'] ?>
        </td>
    </tr>
    <?php
}
?>

<script>
    $('tbody tr').on('click',function () {
       window.location.href = '/leverancier?id='+$(this).attr('id');
    });
</script>

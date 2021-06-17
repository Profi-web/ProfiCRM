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
$table = new Table($pagination,'persons','contacten');
$persons = new Persons('',$table->limit);

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/

/*Variables*/
/**/

foreach($persons->findAll($table->startfrom,$table->limit) as $person) {
    ?>
    <tr id="<?php echo $person['id'] ?>" class="<?php if($person['status'] == 2){ echo 'suspended-class';}?>">
        <td scope="row">
            <?php echo $person['name'] ?> <span class="text-muted op-50"> #<?php echo $person['id'] ?></span>
        </td>
        <td>
            <?php echo $person['email'] ?>
        </td>
        <td>
            <?php echo $person['phonenumber'] ?>
        </td>
    </tr>
    <?php
}
?>

<script>
    $('tbody tr').on('click',function () {
       window.location.href = '/contact?id='+$(this).attr('id');
    });
</script>

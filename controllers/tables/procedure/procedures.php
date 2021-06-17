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
$table = new Table($pagination,'procedures','Procedures');
$procedures = new Procedures('',$table->limit);

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/

/*Variables*/
/**/

foreach($procedures->findAll($table->startfrom,$table->limit) as $procedure) {
    ?>
    <tr id="<?php echo $procedure['id'] ?>">
        <td scope="row">
            <?php echo $procedure['title'] ?> <span class="text-muted op-50"> #<?php echo $procedure['id'] ?></span>
        </td>
        <td>
            <?php echo $procedures->getExcerpt( $procedure['text']); ?>
        </td>
    </tr>
    <?php
}
?>

<script>
    $('tbody tr').on('click',function () {
       window.location.href = '/procedure?id='+$(this).attr('id');
    });
</script>

<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
$pagination = 1;
if (isset($_GET['page']) && $_GET['page'] && $_GET['page'] !== 'null') {
    $pagination = $_GET['page'];
}
/**/

/*Classes*/
if (isset($_GET['tag']) && $_GET['tag'] && $_GET['tag'] !== null) {
    $tag = $_GET['tag'];
} else {
    $tag = '';
}

if (isset($_GET['search']) && $_GET['search'] && $_GET['search'] !== null) {
    $search = $_GET['search'];
} else {
    $search = '';
}

$table = new TableArticles($pagination, 'articles', 'bedrijven', $tag, $search);

$articles = new Articles('', $table->limit);

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/

/*Variables*/
/**/
$find = $articles->findAll($table->startfrom, $table->limit, $tag,$search);
if (!is_array($find) || !$find || $find === '') {

    ?>
    <tr id="none">
        <td colspan="3">Niks gevonden</td>
    </tr>

    <?php
} else {
    foreach ($find as $article) {
        ?>
        <tr id="<?php echo $article['id'] ?>">
            <td scope="row">
                <?php echo $article['name'] ?>
            </td>
            <td>
                <?php
                echo $articles->getTags($article['id']);
                ?>
            </td>
            <td>
                <?php echo $article['date'] ?>
            </td>
        </tr>
        <?php
    }
}
?>
<input type="hidden" value="<?php echo $table->total; ?>" id="total_pages"/>

<script>
    $('tbody tr').on('click', function () {
        if ($(this).attr('id') === 'none') {

        } else {
            window.location.href = '/kennisplein/artikel?id=' + $(this).attr('id');
        }
    });
</script>

<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if (isset($_GET['tag']) && $_GET['tag'] && $_GET['tag'] !== 'null') {
    $tags = $_GET['tag'];
} else {
    $tags = '';
}
if (isset($_GET['page']) && $_GET['page'] && $_GET['page'] !== 'null') {
    $page = $_GET['page'];
} else {
    $page = 1;
}

if (isset($_GET['search']) && $_GET['search'] && $_GET['search'] !== null) {
    $search = $_GET['search'];
} else {
    $search = '';
}

$table = new TableArticles($page, 'articles', 'Kennisplein', $tags, $search);
$table->showPagination();
?>
<script>
    $('.loc_button').on('click', function () {
        var clickedItem = $(this);


        var location = clickedItem.data('location');

        var url = getUrl();
        url = setParam('page', location);
        window.history.pushState("null", "Kennisplein", "/kennisplein" + url.search);
        $('.articles_table').load('/controllers/tables/articles/articles.php' + url.search, function () {
        });
        $('.pagination').load('/controllers/tables/articles/articles_pagination.php' + url.search, function () {
        });
    });
</script>

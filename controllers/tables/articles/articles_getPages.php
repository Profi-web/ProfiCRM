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

$table = new TableArticles($pagination, 'articles', 'bedrijven', $tag,$search);

echo json_encode([
    'pages' => $table->total
]);

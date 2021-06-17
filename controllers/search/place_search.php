<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if (isset($_REQUEST["term"])) {
    $term = $_REQUEST["term"];
} else {
    header('Location: /404');
}

$prospect = new Prospects();

$userValidation = new User();
$loginValidate = new validateLogin([$userValidation->data['role']]);
$loginValidate->securityCheck();
$prospect->findTerm($term);
$usedterm = [];
if ($prospect->dataTerms) {
    foreach ($prospect->dataTerms as $key => $value) {
        switch ($key) {
            case 'prospects':
                foreach ($value as $item) {
                    if(!in_array($item['city'],$usedterm)) {
                        ?>
                        <a class="col-12 py-2 px-4 search_item relation_item">
                            <div class="row align-items-center">
                                <i class="fad fa-city text-primary search_icon" aria-hidden="true"></i>
                                <div class="pl-2 search_text"><span
                                            class="relation_item_text"><?php echo $item['city']; ?></span></div>
                            </div>
                        </a>
                        <?php
                    }
                    $usedterm[] = $item['city'];
                }
                break;
        }
    }

} else {
    ?>
    <a class="col-12 py-2 px-4 search_item muted">
        <div class="row align-items-center">
            <i class="fad fa-ban text-primary search_icon"></i>
            <div class="pl-2 search_text">Geen resultaten</div>
        </div>
    </a>
    <?php
}
?>
<script>
    $('.relation_item').on('click', function () {
        var text = $(this).find('.relation_item_text').html();
        $('.relation_search').val(text);
    });

</script>

<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if (isset($_REQUEST["term"])) {
    $term = $_REQUEST["term"];
} else {
    header('Location: /404');
}

if (isset($_REQUEST["relation"])) {
    $relation = $_REQUEST["relation"];
} else {
    header('Location: /404');
}

$person = new SearchContact($term,$relation);

$loginValidate = new validateLogin();
$loginValidate->securityCheck();


if ($person->data) {
    foreach ($person->data as $key => $value) {
        switch ($key) {
            case 'companies':
                foreach ($value as $item) {
                    ?>
                    <a class="col-12 py-2 px-4 search_item relation_item  <?php if($item['status'] ==2 ){echo 'suspended-class';}?>" relationid="<?php echo $item['id']; ?>"
                       relationtype="1">
                        <div class="row align-items-center">
                            <i class="fad fa-building text-orangered search_icon"></i>
                            <div class="pl-2 search_text"><span
                                        class="relation_item_text"><?php echo $item['name']; ?></span> <span
                                        class="op-50">(#<?php echo $item['id']; ?>)</span></div>
                        </div>
                    </a>
                    <?php
                }
                break;
            case 'suppliers':
                foreach ($value as $item) {
                    ?>
                    <a class="col-12 py-2 px-4 search_item relation_item  <?php if($item['status'] ==2 ){echo 'suspended-class';}?>" relationid="<?php echo $item['id']; ?>"
                       relationtype="3">
                        <div class="row align-items-center">
                            <i class="fad fa-truck-loading text-cyan search_icon"></i>
                            <div class="pl-2 search_text relation_item_text"><?php echo $item['name']; ?> </div> <span
                                        class="op-50">(#<?php echo $item['id']; ?>)</span>
                        </div>
                    </a>
                    <?php
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
    <a class="col-12 py-2 px-4 search_item muted" href="/bedrijven/nieuw" target="_blank">
        <div class="row align-items-center">
            <i class="fad fa-building text-orangered search_icon"></i>
            <div class="pl-2 search_text">Nieuw bedrijf</div>
        </div>
    </a>
    <a class="col-12 py-2 px-4 search_item muted" href="/contacten/nieuw" target="_blank">
        <div class="row align-items-center">
            <i class="fad fa-user text-orange search_icon"></i>
            <div class="pl-2 search_text">Nieuw contact</div>
        </div>
    </a>
    <a class="col-12 py-2 px-4 search_item muted" href="/leveranciers/nieuw" target="_blank">
        <div class="row align-items-center">
            <i class="fad fa-truck-loading text-cyan search_icon"></i>
            <div class="pl-2 search_text">Nieuw leverancier</div>
        </div>
    </a>

    <?php
}
?>
<script>
    $('.relation_item').on('click', function () {
        var relation_id = $(this).attr('relationid');
        var relation_type = $(this).attr('relationtype');
        var text = $(this).find('.relation_item_text').html();
        $('.relation_search').val(text);
        $('#relation_id').val(relation_id);
        $('#relation_type').val(relation_type);

    });
</script>

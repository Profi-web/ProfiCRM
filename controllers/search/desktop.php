<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/
if (isset($_REQUEST["term"])) {
    $term = $_REQUEST["term"];
} else {
    header('Location: /404');
}

$person = new Search($term);

$loginValidate = new validateLogin();
$loginValidate->securityCheck();



if ($person->data) {
    foreach ($person->data as $key => $value) {
        switch ($key) {
            case 'companies':
                foreach($value as $item){
                    ?>
                    <a class="col-12 py-2 px-4 search_item <?php if($item['status'] ==2 ){echo 'suspended-class';}?>" href="/bedrijf?id=<?php echo $item['id']; ?>">
                        <div class="row align-items-center">
                            <i class="fad fa-building text-orangered search_icon"></i>
                            <div class="pl-2 search_text"><?php echo $item['name']; ?> <span
                                        class="op-50">(#<?php echo $item['id']; ?>)</span></div>
                        </div>
                    </a>
                    <?php
                }
                break;
            case 'persons':
                   foreach($value as $item) {
                       ?>
                       <a class="col-12 py-2 px-4 search_item <?php if($item['status'] ==2 ){echo 'suspended-class';}?>" href="/contact?id=<?php echo $item['id']; ?>">
                           <div class="row align-items-center">
                               <i class="fad fa-user text-orange search_icon"></i>
                               <div class="pl-2 search_text"><?php echo $item['name']; ?> <span
                                           class="op-50">(#<?php echo $item['id']; ?>)</span></div>
                           </div>
                       </a>
                       <?php
                   }
                break;
            case 'suppliers':
                   foreach($value as $item){
                ?>
                <a class="col-12 py-2 px-4 search_item" href="/leverancier?id=<?php echo $item['id']; ?>">
                    <div class="row align-items-center">
                        <i class="fad fa-truck-loading text-cyan search_icon"></i>
                        <div class="pl-2 search_text"><?php echo $item['name']; ?> <span
                                    class="op-50">(#<?php echo $item['id']; ?>)</span></div>
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

    <?php
}
?>

<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class TableArticles
{
    public $db;
    public $name;
    public $limit = 10;
    public $total;
    public $pages;
    public $currentpage = 1;
    public $startfrom;

    public function __construct($currentpage = null, $table, $name, $tags, $search)
    {
        $this->name = strtolower($name);
        if ($currentpage) {
            $this->currentpage = $currentpage;
        }
        $this->db = new Medoo(DB_INIT);
        if ($tags || $search) {
            $articles = [];
            if ($tags) {
                $tags = explode(',', $tags);
                $data = $this->db->select('article_tags', '*', ['tag' => $tags]);
                foreach ($data as $da) {
                    $articles[] = $da['article'];
                }

                if ($search && $articles) {
                    $data_tags = $this->db->select('articles', '*', ['id' => $articles, 'name[~]' => '%' . $search . '%']);
                    $articles = [];
                    foreach ($data_tags as $da) {
                        $articles[] = $da['id'];
                    }
                }
            } else {
                if ($search) {
                    $data = $this->db->select('articles', '*', ['name[~]' => '%' . $search . '%']);
                    foreach ($data as $da) {
                        $articles[] = $da['id'];
                    }
                }
            }

            if (!$articles) {
                $this->setTotal(1);
            } else {
                $this->setTotal($this->db->count($table, ['id' => $articles]));
            }
        } else {
            $this->setTotal($this->db->count($table));
        }

        $this->setPages(ceil($this->total / $this->limit));
        $this->startfrom = ($this->currentpage - 1) * $this->limit;
    }

    public function showPagination()
    {
        if (!empty($this->pages)) {
            /*PREV BUTTOn*/
            if ($this->currentpage == 1) {
                ?>
                <li class="page-item disabled">
                    <a class="page-link" tabindex="-1">
                        <i class="fad fa-angle-left"></i>
                        <span class="sr-only">Vorige</span>
                    </a>
                </li>
                <?php
            } else {
                $togo = $this->currentpage - 1;
                ?>
                <li class="page-item">
                    <a class="page-link loc_button" data-location="<?php echo $togo; ?>" tabindex="-1">
                        <i class="fad fa-angle-left"></i>
                        <span class="sr-only">Vorige</span>
                    </a>
                </li>
                <?php
            }


            /*PAGES*/
            if (!empty($this->pages)) {
                for ($i = 1; $i <= $this->pages; $i++) {
                    if ($i == $this->currentpage) {
                        ?>
                        <li class="page-item active" id="<?php echo $i; ?>">
                            <a class="page-link loc_button" data-location="<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } else { ?>
                        <li class="page-item" id="<?php echo $i; ?>">
                            <a class="page-link loc_button" data-location="<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                <?php };
            };

            /*NEXT BUTTON*/
            if ($this->currentpage == $this->pages) {
                ?>
                <li class="page-item disabled">
                    <a class="page-link">
                        <i class="fad fa-angle-right"></i>
                        <span class="sr-only">Volgende</span>
                    </a>
                </li>
                <?php
            } else {
                $togo = $this->currentpage + 1;

                ?>
                <li class="page-item ">
                    <a class="page-link loc_button" data-location="<?php echo $togo; ?>">
                        <i class="fad fa-angle-right"></i>
                        <span class="sr-only">Volgende</span>
                    </a>
                </li>
                <?php
            }
        }

    }


    /**
     * @param bool|int|mixed|string $total
     */
    public function setTotal($total)
    {
        if ($total) {
            $this->total = $total;
            return true;
        }

        return false;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

}
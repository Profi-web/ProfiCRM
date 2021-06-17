<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class TableOrdersCompany
{
    public $db;
    public $name;
    public $limit = 8;
    public $total;
    public $pages;
    public $currentpage = 1;
    public $startfrom;
    public $test;

    public function __construct($currentpage = null, $table, $name, $id)
    {
        $this->name = strtolower($name);
        if ($currentpage) {
            $this->currentpage = $currentpage;
        }
        $this->db = new Medoo(DB_INIT);
        $this->setTotal($this->db->count($table, ['relation_id' => $id]));
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
                    <a class="page-link" href="<?php echo $this->name; ?>?pageOrders=<?php echo $togo; ?>"
                       tabindex="-1">
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
                            <a class="page-link"
                               href='<?php echo $this->name; ?>?pageOrders=<?php echo $i; ?>'><?php echo $i; ?></a>
                        </li>
                    <?php } else { ?>
                        <li class="page-item" id="<?php echo $i; ?>">
                            <a class="page-link"
                               href='<?php echo $this->name; ?>?pageOrders=<?php echo $i; ?>'><?php echo $i; ?></a>
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
                    <a class="page-link" href="<?php echo $this->name; ?>?pageOrders=<?php echo $togo; ?>">
                        <i class="fad fa-angle-right"></i>
                        <span class="sr-only">Volgende</span>
                    </a>
                </li>
                <?php
            }
        }
    }

    public function showPaginationId($id = null)
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
                    <a class="page-link"
                       href="<?php echo $this->name; ?>?pageOrders=<?php echo $togo; ?>&id=<?php echo $id; ?>"
                       tabindex="-1">
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
                            <a class="page-link"
                               href='<?php echo $this->name; ?>?pageOrders=<?php echo $i; ?>&id=<?php echo $id; ?>'><?php echo $i; ?></a>
                        </li>
                    <?php } else { ?>
                        <li class="page-item" id="<?php echo $i; ?>">
                            <a class="page-link"
                               href='<?php echo $this->name; ?>?pageOrders=<?php echo $i; ?>&id=<?php echo $id; ?>'><?php echo $i; ?></a>
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
                    <a class="page-link"
                       href="<?php echo $this->name; ?>?pageOrders=<?php echo $togo; ?>&id=<?php echo $id; ?>">
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
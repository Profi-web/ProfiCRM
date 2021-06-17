<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Orders
{
    public $db;
    public $data;
    public $limit;


    public function __construct($id = null, $limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($id) {
            $this->find($id);
        }
        if ($limit) {
            $this->limit = $limit;
        }
    }

    public function find($id = null)
    {
        if ($id) {
            $query = $this->db->select('orders', '*', ['id' => $id]);
            $error = $this->db->error();
            if (!$error[2]) {
                return $query[0];
            }
            return 'Not found';
        }

        return 'Not found';
    }

    public function findAll($limit_1 = null, $limit_2 = null, $user = null, $statussort = null, $gefactureerdsort = null, $datumsort = null)
    {
        if ($user) {
            if ($gefactureerdsort) {
                $querysql = "SELECT * FROM `orders` WHERE `user` = '" . $user . "' ORDER BY facturering " . $gefactureerdsort . " , id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } elseif ($statussort) {
                $querysql = "SELECT * FROM `orders` WHERE `user` = '" . $user . "'  ORDER BY status " . $statussort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } elseif ($datumsort) {
                $querysql = "SELECT * FROM `orders` WHERE `user` = '" . $user . "'  ORDER BY STR_TO_DATE(date,'%d-%c-%Y')" . $datumsort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } else {
                $querysql = "SELECT * FROM `orders` WHERE `user` = '" . $user . "'  ORDER BY STR_TO_DATE(date,'%d-%c-%Y'), id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            }
//            $query = $this->db->select('orders', '*', ['user' => $user, "LIMIT" => [$limit_1, $limit_2], "ORDER" => $order]);
            $query = $this->db->query($querysql)->fetchAll();
        } else {
            if ($gefactureerdsort) {
                $querysql = "SELECT * FROM `orders` ORDER BY facturering " . $gefactureerdsort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } elseif ($statussort) {
                $querysql = "SELECT * FROM `orders` ORDER BY status " . $statussort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } elseif ($datumsort) {
                $querysql = "SELECT * FROM `orders` ORDER BY STR_TO_DATE(date,'%d-%c-%Y') " . $datumsort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } else {
                $querysql = "SELECT * FROM `orders` ORDER BY STR_TO_DATE(date,'%d-%c-%Y') DESC, id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            }
//            $query = $this->db->select('orders', '*', ["LIMIT" => [$limit_1, $limit_2], "ORDER" => $order]);
            $query = $this->db->query($querysql)->fetchAll();
        }
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

    public function findAllId($limit_1 = null, $limit_2 = null, $id = NULL, $type = NULL)
    {
        if ($id) {
            if ($type) {
                if ($type == 1 || $type == 2) {
                    $querysql = "SELECT * FROM `orders` WHERE `relation_id` = '" . $id . "'  AND `relation_type` = '" . $type . "' ORDER BY STR_TO_DATE(date,'%d-%c-%Y') DESC,id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
                } else {
                    $querysql = "SELECT * FROM `orders` WHERE `relation_id` = '" . $id . "'  ORDER BY STR_TO_DATE(date,'%d-%c-%Y') DESC, id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
                }
            } else {
                $querysql = "SELECT * FROM `orders` WHERE `relation_id` = '" . $id . "'  ORDER BY STR_TO_DATE(date,'%d-%c-%Y') DESC,id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            }
            //            $query = $this->db->select('orders', '*', ['user' => $user, "LIMIT" => [$limit_1, $limit_2], "ORDER" => $order]);
            $query = $this->db->query($querysql)->fetchAll();
        }
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

    public function getFacturering($id)
    {
        switch ($id) {
            case 1:
                return '<i
                            class="fad fa-print"></i> Nee';
                break;
            case 2:
                return '<i
                            class="fad fa-print text-green"></i> Ja';
                break;
            case 3:
                return '<i
                            class="fad fa-shield-alt text-cyan"></i> Service / Garantie';
                break;
            case 4:
                return '<i
                            class="fad fa-badge text-warning"></i> Eigen gebruik';
                break;
            case 5:
                return '<i
                            class="fad fa-file-contract text-primary"></i> Contract';
                break;
        }
    }

    public function getStatus($id)
    {
        switch ($id) {
            case 1:
                return '<i
                            class="fad fa-clock"></i> Nee';
                break;
            case 2:
                return '<i
                            class="fad fa-check-double text-green"></i> Ja';
                break;
        }
    }

    public function getRelation($id, $type)
    {
        if ($id && $type) {
            switch ($type) {
                case 1:
                    //Company
                    $count = $this->db->count('companies', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('companies', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return '<i class="fad fa-building text-orangered"></i> ' . $data[0]['name'];
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
                case 2:
                    //Contact
                    $count = $this->db->count('persons', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('persons', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return '<i class="fad fa-user text-orange"></i> ' . $data[0]['name'];
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
                case 3:
                    //suppliers
                    $count = $this->db->count('suppliers', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('suppliers', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return '<i class="fad fa-truck-loading text-cyan search_icon"></i> ' . $data[0]['name'];
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
            }
        }
        return false;
    }

    public function getRelationData($id, $type, $datatag)
    {
        if ($id && $type) {
            switch ($type) {
                case 1:
                    //Company
                    $count = $this->db->count('companies', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('companies', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            if ($data[0][$datatag]) {
                                return $data[0][$datatag];
                            } else {
                                return '-';
                            }
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
                case 2:
                    //Contact
                    $count = $this->db->count('persons', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('persons', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            if ($data[0][$datatag]) {
                                return $data[0][$datatag];
                            } else {
                                return '-';
                            }
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
            }
        }
        return false;
    }

    public function getRelationColor($id, $type)
    {
        if ($id && $type) {
            switch ($type) {
                case 1:
                    //Company
                    $count = $this->db->count('companies', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('companies', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return 'text-orangered';
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
                case 2:
                    //Contact
                    $count = $this->db->count('persons', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('persons', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return 'text-orange';
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
            }
        }
        return false;
    }

    public function replaceTag($str,$tags) {
        foreach ( $tags as $old => $new )
            $str = preg_replace("~<(/)?$old>~", "<\\1$new>", $str);
        return $str;
    }

    public function getExcerpt($text)
    {
        $test = mb_substr($text, 0, 80);
        $test = strip_tags($test);
        $test = $test . '...';
        $test = str_replace(array("\r", "\n", "<br />", "<br>", "<br >", "<strong>", "<b>", "</strong>", "<a>"), ' ', $test);

        $test = htmlspecialchars($test);


        return $test;
    }
    public function getExcerptFull($test)
    {
        $test = strip_tags($test);
        $test = $test . '...';
        $test = str_replace(array("\r", "\n", "<br />", "<br>", "<br >", "<strong>", "<b>", "</strong>", "<a>"), ' ', $test);

        $test = htmlspecialchars($test);


        return $test;
    }

    public function getUser($id)
    {
        $query = $this->db->select('users', '*', ['id' => $id]);
        if (!$this->db->error()[2]) {
            return $query[0]['name'];
        }
        return $this->db->error()[2];
    }

    public function getCount($id){
        $data = $this->db->count('orders',['user' => $id,'status' => 1]);
        if(!$this->db->error()[2]){
            return $data;
        }
        return $this->db->error()[2];
    }
}

?>
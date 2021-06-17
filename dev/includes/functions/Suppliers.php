<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Suppliers
{
    public $db;
    public $data;
    public $limit;


    public function __construct($supplier = null,$limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($supplier) {
            $this->find($supplier);
        }
        if ($supplier) {
            $this->limit = $limit;
        }
    }

    public function find($supplier = null)
    {
        if ($supplier) {
            $query = $this->db->select('suppliers', '*', ['id' => $supplier]);
            $error = $this->db->error();
            if (!$error[2]) {
                return $query[0];
            }
            return 'Not found';
        }

        return 'Not found';
    }

    public function findAll($limit_1 = null,$limit_2 = null)
    {
        $query = $this->db->select('suppliers', '*',["LIMIT"=>[$limit_1,$limit_2],"ORDER"=>'name']);
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

}

?>
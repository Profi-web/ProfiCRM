<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Companies
{
    public $db;
    public $data;
    public $limit;


    public function __construct($company = null,$limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($company) {
            $this->find($company);
        }
        if ($company) {
            $this->limit = $limit;
        }
    }

    public function find($company = null)
    {
        if ($company) {
            $query = $this->db->select('companies', '*', ['id' => $company]);
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
        $query = $this->db->select('companies', '*',["LIMIT"=>[$limit_1,$limit_2],"ORDER"=>'name']);
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

}

?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Persons
{
    public $db;
    public $data;
    public $limit;


    public function __construct($person = null,$limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($person) {
            $this->find($person);
        }
        if ($person) {
            $this->limit = $limit;
        }
    }

    public function find($person = null)
    {
        if ($person) {
            $query = $this->db->select('persons', '*', ['id' => $person]);
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
        $query = $this->db->select('persons', '*',["LIMIT"=>[$limit_1,$limit_2],"ORDER"=>'name']);
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

}

?>
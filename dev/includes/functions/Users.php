<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Users
{
    public $db;
    public $data;
    public $limit;


    public function __construct($user = null, $limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($user) {
            $this->find($user);
        }
        if ($limit) {
            $this->limit = $limit;
        }
    }

    public function find($user = null)
    {
        if ($user) {
            $query = $this->db->select('users', '*', ['id' => $user]);
            $error = $this->db->error();
            if (!$error[2]) {
                return $query[0];
            }
            return 'Not found';
        }

        return 'Not found';
    }

    public function findAll($limit_1 = null, $limit_2 = null)
    {
        $query = $this->db->select('users', '*', ["LIMIT" => [$limit_1, $limit_2]]);
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

    public function getRole($id)
    {
        $query = $this->db->select('user_roles', 'name', ['id' => $id]);
        if (!$this->db->error()[2]) {
            return $query[0];
        }

        return '-';

    }

    public function getRoles(){
        $query = $this->db->select('user_roles', '*');
        if (!$this->db->error()[2]) {
            return $query;
        }

        return '-';
    }

}

?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/classes/Authentication/validateLogin.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Tags
{
    public $db;

    public function __construct()
    {
        $this->db = new Medoo(DB_INIT);
    }

    public function getTags(){
        $query = $this->db->select('tags', '*');
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return false;
    }
}
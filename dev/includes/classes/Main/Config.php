<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/classes/Authentication/validateLogin.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Config
{
    public $db;

    public function __construct()
    {
        $this->db = new Medoo(DB_INIT);
    }

    public function getMaintenance()
    {
        $query = $this->db->select('config', 'maintenance');
        $error = $this->db->error();
        if (!$error[2]) {
            return $query[0];
        }
        return 'Oeps';
    }
    public function getVersion()
    {
        $query = $this->db->select('config', 'version');
        $error = $this->db->error();
        if (!$error[2]) {
            return $query[0];
        }
        return 'Oeps';
    }


    public function getDate()
    {
        $query = $this->db->select('config', 'date');
        $error = $this->db->error();
        if (!$error[2]) {
            return $query[0];
        }
        return 'Oeps';
    }


}
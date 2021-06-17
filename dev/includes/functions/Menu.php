<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/classes/Authentication/validateLogin.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Menu
{
    public $db;

    public function __construct()
    {
        $this->db = new Medoo(DB_INIT);
    }

    public function getMenuCats()
    {
        $query = $this->db->select('menu_categories', '*',['ORDER' => 'sort']);
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Oeps';
    }

    public function getMenu($id = null)
    {
        if($id) {
            $query = $this->db->select('menu', '*',['category' => $id,'ORDER' => 'sort']);
            $error = $this->db->error();
            if (!$error[2]) {
                return $query;
            }
            return 'Oeps';
        }
        $query = $this->db->select('menu', '*',['ORDER' => 'sort']);
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Oeps';
    }
}
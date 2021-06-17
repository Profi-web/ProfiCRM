<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Procedures
{
    public $db;
    public $data;
    public $limit;


    public function __construct($procedure = null,$limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($procedure) {
            $this->find($procedure);
        }
        if ($procedure) {
            $this->limit = $limit;
        }
    }

    public function find($procedure = null)
    {
        if ($procedure) {
            $query = $this->db->select('procedures', '*', ['id' => $procedure]);
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
        $query = $this->db->select('procedures', '*',["LIMIT"=>[$limit_1,$limit_2],"ORDER"=>'title']);
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

    public function getExcerpt($text)
    {
        $test = mb_substr($text, 0, 50);

        $test = $test . '...';

        $test = str_replace(array("\r", "\n", "<br />", "<br>", "<br >", "<strong>", "<b>", "</strong>"), ' ', $test);

        return $test;
    }


}

?>
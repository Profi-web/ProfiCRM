<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Versions
{
    public $db;
    public $data;
    public $limit;


    public function __construct($version = null,$limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($version) {
            $this->find($version);
        }
        if ($version) {
            $this->limit = $limit;
        }
    }

    public function find($version = null)
    {
        if ($version) {
            $query = $this->db->select('versions', '*', ['id' => $version]);
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
        $query = $this->db->select('versions', '*',["LIMIT"=>[$limit_1,$limit_2],"ORDER"=>["date" => "DESC"]]);
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

    public function getExcerpt($text)
    {
        $textempty = strip_tags($text);
        $leng = strlen($textempty);
        if($leng > 150) {
            $test = mb_substr($text, 0, 150);
        } else {
            $test = $text;
        }

        $test = $test . '...';

        $test = str_replace(array("\r", "\n", "<br />", "<br>", "<br >", "<strong>", "<b>", "</strong>"), ' ', $test);

        return $test;
    }

    public function findLatest()
    {
        $query = $this->db->select('versions', '*',["LIMIT"=>1,"ORDER"=>["date" => "DESC"]]);
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

}

?>
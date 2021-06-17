<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Nice_to_haves
{
    public $db;
    public $data;
    public $limit;


    public function __construct($nice_to_have = null,$limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($nice_to_have) {
            $this->find($nice_to_have);
        }
        if ($nice_to_have) {
            $this->limit = $limit;
        }
    }

    public function find($nice_to_have = null)
    {
        if ($nice_to_have) {
            $query = $this->db->select('nice_to_haves', '*', ['id' => $nice_to_have]);
            $error = $this->db->error();
            if (!$error[2]) {
                return $query[0];
            }
            return 'Not found';
        }

        return 'Not found';
    }

    public function findAll($limit_1 = null,$limit_2 = null,$datumsort = null)
    {
        if($datumsort){
            $query = $this->db->select('nice_to_haves', '*',["LIMIT"=>[$limit_1,$limit_2],"ORDER"=>[
              'date' => $datumsort,
            ]]);
        } else {
            $query = $this->db->select('nice_to_haves', '*',["LIMIT"=>[$limit_1,$limit_2],"ORDER"=>'title']);
        }
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

    public
    function getStatus($id)
    {
        switch ($id) {
            case 1:
                return '<i
                            class="fad fa-clock"></i> Open';
                break;
            case 2:
                return '<i
                            class="fad fa-check-double text-green"></i> Uitgevoerd';
                break;
        }
    }

    public
    function getPriority($id)
    {
        switch ($id) {
            case 1:
                return '<i
                            class="fad fa-flag text-blue"></i> Laag';
                break;
            case 2:
                return '<i
                            class="fad fa-flag text-warning"></i> Middel';
                break;
            case 3:
                return '<i
                            class="fad fa-flag text-danger"></i> Hoog';
                break;
        }
    }


}

?>
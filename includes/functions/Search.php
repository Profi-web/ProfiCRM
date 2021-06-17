<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Search
{
    public $db;
    public $data = array();
    public $error;

    /**
     * User constructor.
     * @param null $person
     */
    public function __construct($term = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($term) {
            $this->find($term);
        }
    }

    public function find($term = null)
    {
        if ($term) {
            $error = 1;

            //Companies
            $count = $this->db->count('companies', ['name[~]' =>  '%'.$term.'%']);
            if ($count > 0) {
                $query = $this->db->select('companies', '*', ['name[~]' =>  '%'.$term.'%']);
                if (!$this->db->error()[2]) {
                    $this->data['companies'] = $query;
                }
                ++$error;
            }
            ++$error;

            //persons
            $count = $this->db->count('persons', ['name[~]' =>  '%'.$term.'%']);
            if ($count > 0) {
                $query = $this->db->select('persons', '*', ['name[~]' => '%'.$term.'%']);
                if (!$this->db->error()[2]) {
                    $this->data['persons'] = $query;
                }
                ++$error;
            }
            ++$error;

            //suppliers
            $count = $this->db->count('suppliers', ['name[~]' =>  '%'.$term.'%']);
            if ($count > 0) {
                $query = $this->db->select('suppliers', '*', ['name[~]' =>  '%'.$term.'%']);
                if (!$this->db->error()[2]) {
                    $this->data['suppliers'] = $query;
                }
                ++$error;
            }
            ++$error;

            if($error === 1){
                return true;
            }
            return false;
        }

        return false;

    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error .= $error . '<br>';
    }
}
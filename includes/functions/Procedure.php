<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Procedure
{
    public $db;
    public $data;
    public $error;

    /**
     * User constructor.
     * @param null $procedure
     */
    public function __construct($procedure = null)
    {
        $this->db = new Medoo(DB_INIT);
        if($procedure) {
            if(!$this->find($procedure)){
                Header('Location: /procedures');
            }
        }
    }

    public function create($text = null,$title = null)
    {
        $title = strip_tags($title);
        $text = strip_tags($text,'<b><strong><i><br>');


        if (!$text) {
            $text = '';
        }

        if (!$title) {
            $this->setError('Je moet een titel opgeven!');
        } else {
            if(strlen($title) < 2) {
                $this->setError('De naam moet minimaal 2 tekens lang zijn');
            }
        }
        if($this->getError()) {
            return false;
        }



        $this->db->insert('procedures',[
            'text' => $text,
            'title' => $title,
        ]);

        if($this->db->error()[2]){
            $this->setError('Oeps er ging iets mis!.'.$this->db->error()[2]);
            return false;
        }
        return true;

    }
//
    public function update($data = null,$column = null, $id = null)
    {
        if ($column && $id) {
            if(!$data){
                $data = '';
            }
            $data = strip_tags($data,'<b><strong><i><br><em><a>');

//            $sql = $this->db->debug()->update('procedures', ["info" => $data],['id' => $id]);
            $this->db->update('procedures', ["text" => $data],['id' => $id]);
            $error = $this->db->error();
            if(!$error[2]){
                $this->setError('');
                return true;
            }
            $this->setError('Oeps bijwerken is mislukt!');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!.');
        return false;
    }


    public function update_contact($id = null,$title = null)
    {
        if ($id) {
            $title = strip_tags($title);

            if(!$this->db->error()[2]) {

                if (!isset($title) || !$title) {
                    $this->setError('Voer een geldige naam in');
                } else {
                    if(strlen($title) < 2) {
                        $this->setError('De naam moet minimaal 2 tekens lang zijn');
                    }
                }

                if($this->getError()) {
                    return false;
                }



                $this->db->update('procedures', [
                    "title" => $title
                ],
                    ['id' => $id]
                );

                $error = $this->db->error();
                if (!$error[2]) {
                    $this->setError('');
                    return true;
                }
                $this->setError('Oeps bijwerken is mislukt!');
                return false;
            }
            $this->setError('Oeps kon nice to have niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }



    public function find($procedure = null)
    {
        if ($procedure) {
            $count = $this->db->count('procedures', ['id' => $procedure]);
            if ($count > 0) {
                $query = $this->db->select('procedures', '*', ['id' => $procedure]);
                if (!$this->db->error()[2]) {
                    $this->data = $query[0];
                    return true;
                }
                return false;
            }
            return false;
        }

        return false;

    }

    public function getData($data, $replaced = null)
    {
        if ($this->data && $this->data[$data]) {
            if ($replaced) {
                return str_replace(' ', '%20', $this->data[$data]);
            }
            return $this->data[$data];
        }

        return '';
    }

    public function exists()
    {

    }

    public function delete($id = null)
    {
        if($id){

            $count = $this->db->count('procedures', ['id' => $id]);
            if(!$this->db->error()[2]){
                if($count > 0){
                    $this->db->delete('procedures', ['id' => $id]);
                    if(!$this->db->error()[2]){
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen nice to have gevonden');
                return false;
            }
            $this->setError('Geen nice to have gevonden.');
            return false;
        }
        $this->setError('Verwijderen mislukt');

        return false;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    public function countAmount()
    {
        $count = $this->db->count('procedures');
        if (!$this->db->error()[2]) {
            if ($count) {
                return $count;
            }
            return 0;
        }
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error .= $error.'<br>';
    }

}


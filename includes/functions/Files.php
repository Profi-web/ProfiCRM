<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Files
{
    public $db;
    public $data;
    public $error;
    public $database;

    /**
     * User constructor.
     * @param null $file
     */
    public function __construct($file = null, $database = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($file) {
            if (!$this->find($file)) {
                Header('Location: /bedrijven');
            }
        }
        if ($database) {
            $this->database = $database;
        } else {
            echo 'error';
            exit();
        }
    }

    public function create($filename = null, $relation = null, $type = null, $date = null,$filesize=null)
    {
        $filename = strip_tags($filename);
        $relation = strip_tags($relation);
        $type = strip_tags($type);
        $date = strip_tags($date);
        $filesize = strip_tags($filesize);

        if (!isset($filename) || empty($filename)) {
            $this->setError('Je moet een bestandnaam invoeren');
        }
        if (!isset($filesize) || empty($filesize)) {
            $this->setError('Je moet een filesize invoeren');
        }
        if (!isset($relation) || empty($relation)) {
            $this->setError('Je moet een relatie invoeren');
        }
        if (!isset($type) || empty($type)) {
            $this->setError('Je moet een type invoeren');
        }
        if (!isset($date) || empty($date)) {
            $this->setError('Je moet een datum invoeren');
        }
        if ($this->getError()) {
            return false;
        }


        $this->db->insert($this->database, [
            'file_name' => $filename,
            'file_size' => $filesize,
            'relation' => $relation,
            'type' => $type,
            'date' => $date
        ]);

        if ($this->db->error()[2]) {
            $this->setError('Oeps er ging iets mis!');
            return false;
        }
        return true;

    }

//
    public function update($data = null, $column = null, $id = null)
    {
        if ($column && $id) {
            if (!$data) {
                $data = '';
            }
            $data = strip_tags($data, '<b><strong><i><br><em><a>');

//            $sql = $this->db->debug()->update($this->database, ["info" => $data],['id' => $id]);
            $this->db->update($this->database, ["text" => $data], ['id' => $id]);
            $error = $this->db->error();
            if (!$error[2]) {
                $this->setError('');
                return true;
            }
            $this->setError('Oeps bijwerken is mislukt!');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!.');
        return false;
    }


    public function update_contact($id = null, $title = null)
    {
        if ($id) {
            $title = strip_tags($title);

            if (!$this->db->error()[2]) {

                if (!isset($title) || !$title) {
                    $this->setError('Voer een geldige title in');
                } else {
                    if (strlen($title) < 2) {
                        $this->setError('De title moet minimaal 2 tekens lang zijn');
                    }
                    if (strlen($title) > 70) {
                        $this->setError('De title mag maximaal 50 tekens lang zijn');
                    }
                }

                if ($this->getError()) {
                    return false;
                }


                $this->db->update($this->database, [
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
            $this->setError('Oeps kon bestand niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }

    public function findAll()
    {
        $query = $this->db->select($this->database, '*');
        if (!$this->db->error()[2]) {
            return $query;
        }
        return false;

    }

    public function findCompany($id)
    {
        if($id) {
            $query = $this->db->select($this->database, '*',['relation'=>$id]);
            if (!$this->db->error()[2]) {
                return $query;
            }
            return false;
        }
        else
        {
            return false;
        }
    }


    public function find($file = null)
    {
        if ($file) {
            $count = $this->db->count($this->database, ['id' => $file]);
            if ($count > 0) {
                $query = $this->db->select($this->database, '*', ['id' => $file]);
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
        if ($id) {

            $count = $this->db->count($this->database, ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $olddata = $this->db->select($this->database,'*',['id' =>$id]);
                    $oldFilePath = $olddata[0]['file_name'];
                    $oldRelation = $olddata[0]['relation'];

                    if(unlink($_SERVER['DOCUMENT_ROOT'] .'/uploads/company/'.$oldRelation.'/'.$oldFilePath)){
                        $this->db->delete($this->database, ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return true;
                        }
                        $this->setError('Verwijderen mislukt');
                        return false;
                    } else {
                        $this->setError('Kon bestand niet verwijderen');
                        return false;
                    }



                }
                $this->setError('Geen bestand gevonden');
                return false;
            }
            $this->setError('Geen bestand gevonden.');
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
        $count = $this->db->count($this->database);
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
        $this->error .= $error . '<br>';
    }

}


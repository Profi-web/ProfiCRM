<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Nice_to_have
{
    public $db;
    public $data;
    public $error;

    /**
     * User constructor.
     * @param null $nice_to_have
     */
    public function __construct($nice_to_have = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($nice_to_have) {
            if (!$this->find($nice_to_have)) {
                Header('Location: /nice-to-haves');
            }
        }
    }

    public function create($text = null, $title = null, $date = null, $status = null, $priority = null)
    {
        $title = strip_tags($title);
        $text = strip_tags($text, '<b><strong><i><br>');
        $date = strip_tags($date);
        $status = strip_tags($status);
        $priority = strip_tags($priority);

        if (!$text) {
            $text = '';
        }
        if (isset($status)) {
            if (!ctype_digit($status)) {
                $this->setError('Voer een geldige status in');
            } else {
                if ($status === 1 | $status === 2) {
                    $this->setError('Voer een geldige status in.');
                }
            }
        } else {
            $this->setError('Voer een geldige status in.');
        }

        if (isset($priority)) {
            if (!ctype_digit($priority)) {
                $this->setError('Voer een geldige prioriteit in');
            } else {
                if ($priority === 1 | $priority === 2) {
                    $this->setError('Voer een geldige prioriteit in.');
                }
            }
        } else {
            $this->setError('Voer een geldige prioriteit in.');
        }

        if (!$title) {
            $this->setError('Je moet een nice to have titel opgeven!');
        } else {
            if (strlen($title) < 2) {
                $this->setError('De naam moet minimaal 2 tekens lang zijn');
            }
            if (strlen($title) > 70) {
                $this->setError('De title mag maximaal 50 tekens lang zijn');
            }
        }
        if (!isset($date) || empty($date)) {
            $this->setError('Je moet een datum invoeren');
        }

        if ($this->getError()) {
            return false;
        }

        $this->db->insert('nice_to_haves', [
            'text' => $text,
            'title' => $title,
            'date' => $date,
            "status" => $status,
            "priority" => $priority

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

//            $sql = $this->db->debug()->update('nice_to_haves', ["info" => $data],['id' => $id]);
            $this->db->update('nice_to_haves', ["text" => $data], ['id' => $id]);
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


    public function update_contact($id = null, $title = null, $status = null, $priority = null)
    {
        if ($id) {
            $title = strip_tags($title);
            $status = strip_tags($status);
            $priority = strip_tags($priority);
            $data = $this->db->select('nice_to_haves', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {

                if (!isset($title) || !$title) {
                    $title = $data[0]['status'];
                } else {
                    if (strlen($title) < 2) {
                        $this->setError('De title moet minimaal 2 tekens lang zijn');
                    }
                    if (strlen($title) > 70) {
                        $this->setError('De title mag maximaal 50 tekens lang zijn');
                    }
                }

                if (!isset($status)) {
                    $status = $data[0]['status'];
                } else {
                    if (!ctype_digit($status)) {
                        $this->setError('Voer een geldige status in');
                    } else {
                        if ($status === 1 | $status === 2) {
                            $this->setError('Voer een geldige status in.');
                        }
                    }
                }


                if (!isset($priority)) {
                    $priority = $data[0]['priority'];
                } else {
                    if (!ctype_digit($priority)) {
                        $this->setError('Voer een geldige prioriteit in');
                    } else {
                        if ($priority === 1 | $priority === 2) {
                            $this->setError('Voer een geldige prioriteit in.');
                        }
                    }
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('nice_to_haves', [
                    "title" => $title,
                    "status" => $status,
                    "priority" => $priority,
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


    public function find($nice_to_have = null)
    {
        if ($nice_to_have) {
            $count = $this->db->count('nice_to_haves', ['id' => $nice_to_have]);
            if ($count > 0) {
                $query = $this->db->select('nice_to_haves', '*', ['id' => $nice_to_have]);
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

            $count = $this->db->count('nice_to_haves', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('nice_to_haves', ['id' => $id]);
                    if (!$this->db->error()[2]) {
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
        $count = $this->db->count('nice_to_haves');
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

    public function update_status($id = null, $status = null)
    {
        if ($id && $status) {
            $status = intval($status);
            $data = $this->db->select('nice_to_haves', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($status === 1 | $status === 2) {
                } else {
                    $this->setError('Geef een geldige status mee!');
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('nice_to_haves', [
                    "status" => $status,
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

    public function update_priority($id = null, $priority = null)
    {
        if ($id && $priority) {
            $priority = intval($priority);
            $data = $this->db->select('nice_to_haves', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($priority === 1 | $priority === 2 || $priority === 3) {
                } else {
                    $this->setError('Geef een geldige prioriteit mee!');
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('nice_to_haves', [
                    "priority" => $priority,
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

}


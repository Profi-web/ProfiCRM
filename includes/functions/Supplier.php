<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Supplier
{
    public $db;
    public $data;
    public $error;

    /**
     * User constructor.
     * @param null $supplier
     */
    public function __construct($supplier = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($supplier) {
            if (!$this->find($supplier)) {
                Header('Location: /leveranciers');
            }
        }
    }

    public function create($text = null, $name = null, $phonenumber = null, $email = null, $address = null, $zipcode = null, $city = null)
    {
        $phonenumber = strip_tags($phonenumber);
        $email = strip_tags($email);
        $address = strip_tags($address);
        $zipcode = strip_tags($zipcode);
        $city = strip_tags($city);
        $name = strip_tags($name);
        $text = strip_tags($text, '<b><strong><i><br>');

        if (!$text) {
            $text = '';
        }

        if (!$name) {
            $this->setError('Je moet een leveranciersnaam opgeven!');
        } else {
            if (strlen($name) < 2) {
                $this->setError('De naam moet minimaal 2 tekens lang zijn');
            }
        }

        if (!$phonenumber) {
            $phonenumber = '';
        } else {
            if (!ctype_digit($phonenumber)) {
                $this->setError('Telefoonnummer mag alleen cijfer bevatten');
            }
        }

        if (!$email) {
            $email = '';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setError('Voer een geldig emailadres in');
            }
        }
        if (!$address) {
            $address = '';
        }
        if (!$zipcode) {
            $zipcode = '';
        }
        if (!$city) {
            $city = '';
        }
        if ($this->getError()) {
            return false;
        }


        $this->db->insert('suppliers', [
            'info' => $text,
            'name' => $name,
            'phonenumber' => $phonenumber,
            'email' => $email,
            'address' => $address,
            'zipcode' => $zipcode,
            'city' => $city,
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
            $data = strip_tags($data, '<b><strong><i><br><em><a></a>');

//            $sql = $this->db->debug()->update('suppliers', ["info" => $data],['id' => $id]);
            $this->db->update('suppliers', ["info" => $data], ['id' => $id]);
            $error = $this->db->error();
            if (!$error[2]) {
                $this->setError('');
                return true;
            }
            $this->setError('Oeps bijwerken is mislukt!');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }


    public function update_contact($id = null, $phonenumber = null, $email = null, $address = null, $zipcode = null, $city = null, $name = null)
    {
        if ($id) {

            $phonenumber = strip_tags($phonenumber);
            $email = strip_tags($email);
            $address = strip_tags($address);
            $zipcode = strip_tags($zipcode);
            $city = strip_tags($city);
            $name = strip_tags($name);

            $data = $this->db->select('suppliers', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {

                if (!isset($name) || !$name) {
                    $this->setError('Voer een geldige naam in');
                } else {
                    if (strlen($name) < 2) {
                        $this->setError('De naam moet minimaal 2 tekens lang zijn');
                    }
                }

                if (!isset($phonenumber) || !$phonenumber) {
                    $phonenumber = '';
                } else {
                    if (!ctype_digit($phonenumber)) {
                        $this->setError('Telefoonnummer mag alleen cijfer bevatten');
                    }
                }

                if (!isset($email) || !$email) {
                    $email = '';
                } else {
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $this->setError('Voer een geldig emailadres in');
                    }
                }

                if (!isset($address)) {
                    $address = $data[0]['address'];
                }

                if (!isset($zipcode)) {
                    $zipcode = $data[0]['zipcode'];
                }

                if (!isset($city)) {
                    $city = $data[0]['city'];
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('suppliers', [
                    "phonenumber" => $phonenumber,
                    "email" => $email,
                    "address" => $address,
                    "zipcode" => $zipcode,
                    "city" => $city,
                    "name" => $name
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
            $this->setError('Oeps kon leverancier niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }


    public function find($supplier = null)
    {
        if ($supplier) {
            $count = $this->db->count('suppliers', ['id' => $supplier]);
            if ($count > 0) {
                $query = $this->db->select('suppliers', '*', ['id' => $supplier]);
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

            $count = $this->db->count('suppliers', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('suppliers', ['id' => $id]);
                    if (!$this->db->error()[2]) {
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen leverancier gevonden');
                return false;
            }
            $this->setError('Geen leverancier gevonden.');
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
        $count = $this->db->count('suppliers');
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


<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Prospect
{
    public $db;
    public $data;
    public $error;

    /**
     * User constructor.
     * @param null $prospect
     */
    public function __construct($prospect = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($prospect) {
            if (!$this->find($prospect)) {
                Header('Location: /prospects');
            }
        }
    }

    public function create($contactpersoon = null, $name = null, $phonenumber = null, $email = null, $website = null, $address = null, $zipcode = null, $city = null, $kvk = null, $activityText = null, $user = null)
    {
        $phonenumber = strip_tags($phonenumber);
        $email = strip_tags($email);
        $website = strip_tags($website);
        $address = strip_tags($address);
        $zipcode = strip_tags($zipcode);
        $city = strip_tags($city);
        $kvk = strip_tags($kvk);
        $name = strip_tags($name);
        $user = strip_tags($user);
        $contactpersoon = strip_tags($contactpersoon);
        $activityText = strip_tags($activityText, '<b><strong><i><br><a>');


        if (!$contactpersoon) {
            $contactpersoon = '';
        }

        if (!$name) {
            $this->setError('Je moet een prospectsnaam opgeven!');
        } else {
            if (strlen($name) < 2) {
                $this->setError('De naam moet minimaal 2 tekens lang zijn');
            }
        }
        $phonenumber = trim($phonenumber);
        if (trim($phonenumber) == "") {
            $phonenumber = '';
        }
        if (!$phonenumber) {
            $phonenumber = '';
        } else {
//            if(!ctype_digit($phonenumber)){
//                $this->setError('Telefoonnummer mag alleen cijfer bevatten');
//            }
        }

        if (!$email) {
            $email = '';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setError('Voer een geldig emailadres in');
            }
        }
        if (!$website) {
            $website = '';
        } else {
            if (strpos($website, 'http://') === false && strpos($website, 'https://') === false) {
                $website = 'http://' . $website;
            }
        }
        if (!$address) {
            $address = '';
        }
        if (!$activityText) {
            $activityText = '';
        }
        if (!$zipcode) {
            $zipcode = '';
        }
        if (!$city) {
            $city = '';
        }
        $kvk = trim($kvk);
        if (!$kvk) {
            $kvk = '';
        } else {
            if (strlen($kvk) == 7) {
                $kvk = "0" . $kvk;
                switch (strlen($kvk)) {
                    case 8:
                        $kvk = $kvk . '0000';
                        break;
                    case 9:
                        $kvk = $kvk . '000';
                        break;
                    case 10:
                        $kvk = $kvk . '00';
                        break;
                    case 11:
                        $kvk = $kvk . '0';
                        break;
                }
            } else {
                switch (strlen($kvk)) {
                    case 8:
                        $kvk = $kvk . '0000';
                        break;
                    case 9:
                        $kvk = $kvk . '000';
                        break;
                    case 10:
                        $kvk = $kvk . '00';
                        break;
                    case 11:
                        $kvk = $kvk . '0';
                        break;
                }
            }
        }

        if (isset($user)) {
            if (!ctype_digit($user)) {
                $this->setError('Voer een geldige user in');
            } else {
                $userCount = $this->db->count('users', ['id' => $user]);
                if (!$this->db->error()[2]) {
                    if ($userCount < 1) {
                        $this->setError('Voer een user status in.');
                    }
                } else {
                    $this->setError('Voer een user status in.');
                }
            }
        }

        if ($this->getError()) {
            return false;
        }

        $this->db->insert('prospects', [
            'contactpersoon' => $contactpersoon,
            'name' => $name,
            'phonenumber' => $phonenumber,
            'email' => $email,
            'website' => $website,
            'address' => $address,
            'zipcode' => $zipcode,
            'city' => $city,
            'kvk' => $kvk,
        ]);
        $date = date("Y-m-d");
        if ($this->db->error()[2]) {
            $this->setError('Oeps er ging iets mis!' . $this->db->error()[2]);
            return false;
        } else {
            $prospectID = $this->db->id();
            $this->db->insert('prospects_activities', [
                'info' => $activityText,
                "status" => 1,
                'date' => $date,
                'activity_date' => $date,
                'user' => $user,
                'prospect' => $prospectID,
            ]);
            if ($this->db->error()[2]) {
                $this->setError('Oeps er ging iets mis!.' . $this->db->error()[2]);
                return false;
            } else {
                return true;
            }
        }
    }

//
    public function update($data = null, $column = null, $id = null)
    {
        if ($column && $id) {
            if (!$data) {
                $data = '';
            }
            $data = strip_tags($data, '<b><strong><i><br><em><a>');

//            $sql = $this->db->debug()->update('prospects', ["info" => $data],['id' => $id]);
            $this->db->update('prospects', ["info" => $data], ['id' => $id]);
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


    public function update_contact($id = null, $phonenumber = null, $email = null, $website = null, $address = null, $zipcode = null, $city = null, $kvk = null, $name = null, $contactpersoon = null)
    {
        if ($id) {
            $phonenumber = strip_tags($phonenumber);
            $email = strip_tags($email);
            $website = strip_tags($website);
            $address = strip_tags($address);
            $zipcode = strip_tags($zipcode);
            $city = strip_tags($city);
            $kvk = strip_tags($kvk);
            $name = strip_tags($name);
            $contactpersoon = strip_tags($contactpersoon);

            $data = $this->db->select('prospects', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {

                if (!isset($name) || !$name) {
                    $this->setError('Voer een geldige naam in');
                } else {
                    if (strlen($name) < 2) {
                        $this->setError('De naam moet minimaal 2 tekens lang zijn');
                    }
                    $tempname = trim($name);
                    if ($tempname == "") {
                        $this->setError('De naam moet minimaal 2 tekens lang zijn');
                    }
                }
                $phonenumber = trim($phonenumber);
                if (trim($phonenumber) == "") {
                    $phonenumber = '';
                }
                if (!isset($phonenumber) || !$phonenumber) {
                    $phonenumber = '';
                } else {
//                    if(!ctype_digit($phonenumber)){
//                        $this->setError('Telefoonnummer mag alleen cijfer bevatten');
//                    }
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
                if (trim($address) == "") {
                    $address = '';
                }
                $kvk = trim($kvk);
                if (!$kvk) {
                    $kvk = '';
                } else {
                    if (strlen($kvk) == 7) {
                        $kvk = "0" . $kvk;
                        switch (strlen($kvk)) {
                            case 8:
                                $kvk = $kvk . '0000';
                                break;
                            case 9:
                                $kvk = $kvk . '000';
                                break;
                            case 10:
                                $kvk = $kvk . '00';
                                break;
                            case 11:
                                $kvk = $kvk . '0';
                                break;
                        }
                    } else {
                        switch (strlen($kvk)) {
                            case 8:
                                $kvk = $kvk . '0000';
                                break;
                            case 9:
                                $kvk = $kvk . '000';
                                break;
                            case 10:
                                $kvk = $kvk . '00';
                                break;
                            case 11:
                                $kvk = $kvk . '0';
                                break;
                        }
                    }
                }

                if (!isset($zipcode)) {
                    $zipcode = $data[0]['zipcode'];
                }
                if (trim($zipcode) == "") {
                    $zipcode = '';
                }

                if (!isset($contactpersoon)) {
                    $contactpersoon = $data[0]['contactpersoon'];
                }
                if (trim($contactpersoon) == "") {
                    $contactpersoon = '';
                }

                if (!isset($city)) {
                    $city = $data[0]['city'];

                }
                if (trim($city) == "") {
                    $city = '';
                }

                if (!$website) {
                    $website = $data[0]['website'];
                } else {
                    if (strpos($website, 'http://') === false && strpos($website, 'https://') === false) {
                        $website = 'http://' . $website;
                    }
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('prospects', [
                    "phonenumber" => $phonenumber,
                    "email" => $email,
                    "address" => $address,
                    "zipcode" => $zipcode,
                    "website" => $website,
                    "city" => $city,
                    "name" => $name,
                    "kvk" => $kvk,
                    "contactpersoon" => $contactpersoon
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
            $this->setError('Oeps kon prospect niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }


    public function find($prospect = null)
    {
        if ($prospect) {
            $count = $this->db->count('prospects', ['id' => $prospect]);
            if ($count > 0) {
                $query = $this->db->select('prospects', '*', ['id' => $prospect]);
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

    public function getDataLine($data, $replaced = null)
    {
        if ($this->data && $this->data[$data]) {
            if ($replaced) {
                return str_replace(' ', '%20', $this->data[$data]);
            }
            return $this->data[$data];
        }

        return '-';
    }

    public function exists()
    {

    }

    public function delete($id = null)
    {
        if ($id) {

            $count = $this->db->count('prospects', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('prospects', ['id' => $id]);
                    if (!$this->db->error()[2]) {
                        $this->db->delete('prospects_activities', ['prospect' => $id]);
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen prospect gevonden');
                return false;
            }
            $this->setError('Geen prospect gevonden.');
            return false;
        }
        $this->setError('Verwijderen mislukt');

        return false;
    }

    public function deleteActvitity($id = null)
    {
        if ($id) {

            $count = $this->db->count('prospects_activities', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('prospects_activities', ['id' => $id]);
                    if (!$this->db->error()[2]) {
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen prospect gevonden');
                return false;
            }
            $this->setError('Geen prospect gevonden.');
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
        $count = $this->db->count('prospects');
        if (!$this->db->error()[2]) {
            if ($count) {
                return $count;
            }
            return 0;
        }
        return 0;
    }

    public function countAmountKvK()
    {
//        $count = $this->db->count('prospects');
        $count = 0;
        $co = $this->db->query("SELECT id
FROM prospects
WHERE LENGTH(kvk) > 1")->fetchAll();
        foreach ($co as $c) {
            $count++;
        }
        if (!$this->db->error()[2]) {
            if ($count) {
                return $count;
            }
            return 0;
        }
        return 0;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error .= $error . '<br>';
    }

}


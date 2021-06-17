<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Company
{
    public $db;
    public $data;
    public $error;

    /**
     * User constructor.
     * @param null $company
     */
    public function __construct($company = null)
    {
        $this->db = new Medoo(DB_INIT);
        if($company) {
            if(!$this->find($company)){
                Header('Location: /bedrijven');
            }
        }
    }

    public function create($text = null,$name = null,$phonenumber = null, $email = null, $address = null, $zipcode = null, $city = null)
    {
        $phonenumber = strip_tags($phonenumber);
        $email = strip_tags($email);
        $address = strip_tags($address);
        $zipcode = strip_tags($zipcode);
        $city = strip_tags($city);
        $name = strip_tags($name);
        $text = strip_tags($text,'<b><strong><i><br>');


        if (!$text) {
            $text = '';
        }

        if (!$name) {
            $this->setError('Je moet een bedrijfsnaam opgeven!');
        } else {
            if(strlen($name) < 2) {
                $this->setError('De naam moet minimaal 2 tekens lang zijn');
            }
        }

        if (!$phonenumber) {
            $phonenumber = '';
        } else {
            if(!ctype_digit($phonenumber)){
                $this->setError('Telefoonnummer mag alleen cijfer bevatten');
            }
        }

        if (!$email) {
            $email = '';
        } else{
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
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
        if($this->getError()) {
            return false;
        }



        $this->db->insert('companies',[
            'info' => $text,
            'name' => $name,
            'phonenumber' => $phonenumber,
            'email' => $email,
            'address' => $address,
            'zipcode' => $zipcode,
            'city' => $city,
        ]);

        if($this->db->error()[2]){
            $this->setError('Oeps er ging iets mis!');
            return false;
        }
        return true;

    }

    public
    function getStatus($id)
    {
        switch ($id) {
            case 1:
                return '<i
                            class="fad fa-check-circle"></i> Normaal';
                break;
            case 2:
                return '<i
                            class="fad fa-exclamation-circle text-danger"></i> <span class="text-danger">Suspended</span>';
                break;
        }
    }
//
    public function update($data = null,$column = null, $id = null)
    {
        if ($column && $id) {
            if(!$data){
                $data = '';
            }
            $data = strip_tags($data,'<b><strong><i><br><em><a>');

//            $sql = $this->db->debug()->update('companies', ["info" => $data],['id' => $id]);
            $this->db->update('companies', ["info" => $data],['id' => $id]);
            $error = $this->db->error();
            if(!$error[2]){
                $this->setError('');
                return true;
            }
            $this->setError('Oeps bijwerken is mislukt!');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }


    public function update_contact($id = null,$phonenumber = null, $email = null, $address = null, $zipcode = null, $city = null,$name = null,$kvk = null,$iban = null)
    {
        if ($id) {
            $phonenumber = strip_tags($phonenumber);
            $email = strip_tags($email);
            $address = strip_tags($address);
            $zipcode = strip_tags($zipcode);
            $city = strip_tags($city);
            $name = strip_tags($name);
            $kvk = strip_tags($kvk);
            $iban = strip_tags($iban);

            $data = $this->db->select('companies','*',['id' => $id]);
            if(!$this->db->error()[2]) {

                if (!isset($name) || !$name) {
                    $this->setError('Voer een geldige naam in');
                } else {
                    if(strlen($name) < 2) {
                        $this->setError('De naam moet minimaal 2 tekens lang zijn');
                    }
                    $tempname = trim($name);
                    if($tempname == ""){
                        $this->setError('De naam moet minimaal 2 tekens lang zijn');
                    }
                }

                if (!isset($phonenumber) || !$phonenumber) {
                    $phonenumber = '';
                } else {
                    if(!ctype_digit($phonenumber)){
                        $this->setError('Telefoonnummer mag alleen cijfer bevatten');
                    }
                }
                if(trim($phonenumber) == ""){
                    $phonenumber = '';
                }

                if (!isset($email) || !$email) {
                    $email = '';
                } else{
                    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                        $this->setError('Voer een geldig emailadres in');
                    }
                }

                if (!isset($address)) {
                    $address = $data[0]['address'];
                }
                if(trim($address) == ""){
                    $address = '';
                }

                if (!isset($zipcode)) {
                    $zipcode = $data[0]['zipcode'];
                }
                if(trim($zipcode) == ""){
                    $zipcode = '';
                }

                if (!isset($city)) {
                    $city = $data[0]['city'];

                }
                if(trim($city) == ""){
                    $city = '';
                }

                if (!isset($kvk)) {
                    $kvk = $data[0]['kvk'];

                }
                if(trim($kvk) == ""){
                    $kvk = '';
                }

                if (!isset($iban)) {
                    $iban = $data[0]['iban'];

                }
                if(trim($iban) == ""){
                    $iban = '';
                }



                if($this->getError()) {
                    return false;
                }




                $this->db->update('companies', [
                    "phonenumber" => $phonenumber,
                    "email" => $email,
                    "address" => $address,
                    "zipcode" => $zipcode,
                    "city" => $city,
                    "name" => $name,
                    "kvk" => $kvk,
                    "iban" => $iban
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
            $this->setError('Oeps kon bedrijf niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }



    public function find($company = null)
    {
        if ($company) {
            $count = $this->db->count('companies', ['id' => $company]);
            if ($count > 0) {
                $query = $this->db->select('companies', '*', ['id' => $company]);
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

            $count = $this->db->count('companies', ['id' => $id]);
            if(!$this->db->error()[2]){
                if($count > 0){
                    $this->db->delete('companies', ['id' => $id]);
                    if(!$this->db->error()[2]){
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen bedrijf gevonden');
                return false;
            }
            $this->setError('Geen bedrijf gevonden.');
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
        $count = $this->db->count('companies');
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

    public function update_status($id = null, $status = null)
    {
        if ($id && $status) {
            $status = intval($status);
            $data = $this->db->select('companies', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($status === 1 | $status === 2) {
                } else {
                    $this->setError('Geef een geldige status mee!');
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('companies', [
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
            $this->setError('Oeps kon bedrijf niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }
    public function getRelations($id)
    {
        $return_data = array();
        if ($id) {
            $count = $this->db->count('person_relations', ['relation' => $id, 'type' => 1]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $data = $this->db->select('person_relations', '*', ['relation' => $id, 'type' => 1]);
                    foreach ($data as $value) {
                        if ($value['type'] == 1) {
                            $count = $this->db->count('persons', ['id' => $value['person']]);
                            if (!$this->db->error()[2]) {
                                if ($count > 0) {
                                    $query = $this->db->select('persons', '*', ['id' => $value['person']]);
                                    $return_data[$value['id']] = $query;
                                }
                            }
                        }
                    }
                    return $return_data;
                }
            }
            return false;
        }
        return false;
    }

    public function showRelations($id)
    {
        if ($this->getRelations($id) !== null && !empty($this->getRelations($id))) {
            foreach ($this->getRelations($id) as $key => $value) {
                if ($key === 'suppliers') {
                    echo '<div class="col-12 font-weight-bold p-0 pt-2">Leveranciers:</div>';
                    foreach ($value as $item) {
                        echo '<a class="col-12 p-0" href="/leverancier?id=' . $item[0]['id'] . '">' . $item[0]['name'] . '</a>';
                    }
                }
                if ($key === 'companies') {
                    echo '<div class="col-12 font-weight-bold p-0 pt-2">Bedrijven:</div>';
                    foreach ($value as $item) {
                        echo '<a class="col-12 p-0" href="/bedrijf?id=' . $item[0]['id'] . '">' . $item[0]['name'] . '</a>';
                    }
                }


                echo '<br>';
                echo '<br>';
            }
        } else {
            echo '<a class="col-12 p-0 py-2">Geen relaties gevonden</a>';
        }
    }

}


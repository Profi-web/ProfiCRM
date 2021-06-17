<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Person
{
    public $db;
    public $data;
    public $error;
    public $setId;

    /**
     * User constructor.
     * @param null $person
     */
    public function __construct($person = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($person) {
            $this->setSetId($person);
            if (!$this->find($person)) {
                Header('Location: /contacten');
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
            $this->setError('Je moet een contactsnaam opgeven!');
        } else {
            if(strlen($name) < 2) {
                $this->setError('De naam moet minimaal 2 tekens lang zijn');
            }
            $tempname = trim($name);
            if($tempname == ""){
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




        $this->db->insert('persons', [
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
            $data = strip_tags($data, '<b><strong><i><br><em><a>');

//            $sql = $this->db->debug()->update('persons', ["info" => $data],['id' => $id]);
            $this->db->update('persons', ["info" => $data], ['id' => $id]);
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

            $data = $this->db->select('persons', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {

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



                $this->db->update('persons', [
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
            $this->setError('Oeps kon contact niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }


    public function find($person = null)
    {
        if ($person) {
            $count = $this->db->count('persons', ['id' => $person]);
            if ($count > 0) {
                $query = $this->db->select('persons', '*', ['id' => $person]);
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

    /**
     * @param $id
     * @return array|bool
     */
    public function getRelations($id)
    {
        $return_data = array();
        if ($id) {
            $count = $this->db->count('person_relations', ['person' => $id, 'ORDER' => 'person']);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $data = $this->db->select('person_relations', '*', ['person' => $id, 'ORDER' => 'person']);
                    foreach ($data as $value) {
                        if ($value['type'] == 1) {
                            $count = $this->db->count('companies', ['id' => $value['relation']]);
                            if (!$this->db->error()[2]) {
                                if ($count > 0) {
                                    $query = $this->db->select('companies', '*', ['id' => $value['relation']]);
                                    $return_data['companies'][$value['id']] = $query;
                                }
                            }
                        }


                        if ($value['type'] == 3) {
                            $count = $this->db->count('suppliers', ['id' => $value['relation']]);
                            if (!$this->db->error()[2]) {
                                if ($count > 0) {
                                    $query = $this->db->select('suppliers', '*', ['id' => $value['relation']]);
                                    $return_data['suppliers'][$value['id']] = $query;
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

    public function showEditRelations($id)
    {


        /*Leveranciers*/
        echo '<div class="col-12 font-weight-bold p-0 pt-2">Leveranciers:</div>';
        if ($this->getRelations($id)) {
            foreach ($this->getRelations($id) as $key => $value) {
                if ($key === 'suppliers') {
                    foreach ($value as $itemkey => $item) {
                        echo '<div class="container-fluid">';
                        echo '<div class="row justify-content-between align-items-center bg-light p-2 mb-1 rounded">';
                        echo '<a class="p-0" id="' . $itemkey . '">' . $item[0]['name'] . '</a>';
                        echo '<a class="p-0 delete text-danger" id="' . $itemkey . '"><i class="fad fa-times-circle text-danger"></i></a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                if (!isset($this->getRelations($id)['suppliers'])) {
                    echo '<div class="container-fluid">';
                    echo '<div class="row justify-content-between align-items-center p-0 mb-1 rounded">';
                    echo '<a class="p-0">Niks gevonden</a>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        } else {
            echo '<div class="container-fluid">';
            echo '<div class="row justify-content-between align-items-center p-0 mb-1 rounded">';
            echo '<a class="p-0">Niks gevonden</a>';
            echo '</div>';
            echo '</div>';
        }

        /*Bedrijven*/
        echo '<div class="col-12 font-weight-bold p-0 pt-2">Bedrijven:</div>';
        if ($this->getRelations($id)) {
            foreach ($this->getRelations($id) as $key => $value) {
                if ($key === 'companies') {
                    foreach ($value as $itemkey => $item) {
                        echo '<div class="container-fluid">';
                        echo '<div class="row justify-content-between align-items-center bg-light p-2 rounded">';
                        echo '<a class="p-0" id="' . $itemkey . '">' . $item[0]['name'] . '</a>';
                        echo '<a class="p-0 delete text-danger" id="' . $itemkey . '"><i class="fad fa-times-circle text-danger"></i></a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                if (!isset($this->getRelations($id)['companies'])) {
                    echo '<div class="container-fluid">';
                    echo '<div class="row justify-content-between align-items-center p-0 mb-1 rounded">';
                    echo '<a class="p-0">Niks gevonden</a>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        } else {
            echo '<div class="container-fluid">';
            echo '<div class="row justify-content-between align-items-center p-0 mb-1 rounded">';
            echo '<a class="p-0">Niks gevonden</a>';
            echo '</div>';
            echo '</div>';
        }

    }

    public
    function delete($id = null)
    {
        if ($id) {

            $count = $this->db->count('persons', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('persons', ['id' => $id]);
                    if (!$this->db->error()[2]) {
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen contact gevonden');
                return false;
            }
            $this->setError('Geen contact gevonden.');
            return false;
        }
        $this->setError('Verwijderen mislukt');

        return false;
    }

    public
    function deleteRelation($id = null)
    {
        if ($id) {

            $count = $this->db->count('person_relations', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('person_relations', ['id' => $id]);
                    if (!$this->db->error()[2]) {
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen relatie gevonden');
                return false;
            }
            $this->setError('Geen relatie gevonden.' . json_encode($this->db->error()));
            return false;
        }
        $this->setError('Verwijderen mislukt');

        return false;
    }

    public
    function showCompaniesOptions($id)
    {
        if ($id) {
            $count = $this->db->count('companies');
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $data = $this->db->select('companies', '*');
                    if (!$this->db->error()[2]) {
                        foreach ($data as $item) {
                            $count = $this->db->count('person_relations', [
                                'person' => $id,
                                'relation' => $item['id']
                            ]);
                            if (!$this->db->error()[2]) {
                                if ($count > 0) {
                                    echo "<option value='" . $item['id'] . "' disabled>" . $item['name'] . " (#" . $item['id'] . ")</option>";
                                } else {
                                    echo "<option value='" . $item['id'] . "'>" . $item['name'] . " (#" . $item['id'] . ")</option>";
                                }
                            }
                        }
                    }
                }
                return false;
            }
            return false;
        }
        return false;
    }

    public
    function showSuppliersOptions($id)
    {
        if ($id) {
            $count = $this->db->count('suppliers');
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $data = $this->db->select('suppliers', '*');
                    if (!$this->db->error()[2]) {
                        foreach ($data as $item) {
                            $count = $this->db->count('person_relations', [
                                'person' => $id,
                                'relation' => $item['id']
                            ]);
                            if (!$this->db->error()[2]) {
                                if ($count > 0) {
                                    echo "<option value='" . $item['id'] . "' disabled>" . $item['name'] . " (#" . $item['id'] . ")</option>";
                                } else {
                                    echo "<option value='" . $item['id'] . "'>" . $item['name'] . " (#" . $item['id'] . ")</option>";
                                }
                            }
                        }
                    }
                }
                return false;
            }
            return false;
        }
        return false;
    }

    public
    function saveRelation($person_id = null, $type = null, $relation = null)
    {
        if ($person_id && $type && $relation) {
            $data = $this->db->insert('person_relations', [
                'person' => $person_id,
                'relation' => $relation,
                'type' => $type
            ]);
            if (!$this->db->error()[2]) {
                return true;
            }
            $this->setError('Oeps er ging iets mis!.'.$person_id.$relation.$type);
            return false;
        }

        $this->setError('Oeps er ging iets mis!123');
        return false;
    }

    /**
     * @return mixed
     */
    public
    function getError()
    {
        return $this->error;
    }

    public
    function countAmount()
    {
        $count = $this->db->count('persons');
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
    public
    function setError($error)
    {
        $this->error .= $error . '<br>';
    }

    /**
     * @return mixed
     */
    public
    function getSetId()
    {
        return $this->setId;
    }

    /**
     * @param mixed $setId
     */
    public
    function setSetId($setId)
    {
        $this->setId = $setId;
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

    public function update_status($id = null, $status = null)
    {
        if ($id && $status) {
            $status = intval($status);
            $data = $this->db->select('persons', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($status === 1 | $status === 2) {
                } else {
                    $this->setError('Geef een geldige status mee!');
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('persons', [
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
            $this->setError('Oeps kon persoon niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }

}


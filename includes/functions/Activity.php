<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Activity
{
    public $db;
    public $notification;
    public $data;
    public $error;

    /**
     * User constructor.
     * @param null $activity
     */
    public function __construct($activity = null)
    {
        $this->db = new Medoo(DB_INIT);
        $this->notification = new Notification();
        if ($activity) {
            if (!$this->find($activity)) {
                Header('Location: /taken');
            }
        }
    }

    public function create($text = null, $user = null, $relation = null, $type = null, $status = null, $facturering = null, $date = null, $from = null, $to = null, $traveltime = null, $sentUserID = null)
    {
        $relation = strip_tags($relation);
        $user = strip_tags($user);
        $type = strip_tags($type);
        $status = strip_tags($status);
        $facturering = strip_tags($facturering);
        $date = strip_tags($date);
        $from = strip_tags($from);
        $to = strip_tags($to);
        $traveltime = strip_tags($traveltime);
        $sentUserID = strip_tags($sentUserID);
        $text = strip_tags($text, '<b><strong><i><br><a>');


        if (!$text) {
            $text = '';
        }

        if (isset($relation) && $relation && isset($type) && $type && !empty($relation) && !empty($type)) {
            if (!ctype_digit($relation) || !ctype_digit($type)) {
                $this->setError('Voer een geldige relatie in');
            } else {
                if ($type != '1' && $type != '2' && $type != '3') {
                    $this->setError('Er ging iets mis met de relatie');
                } else {
                    switch ($type) {
                        case '1':
                            $count = $this->db->count('companies', ['id' => $relation]);
                            if ($count < 1) {
                                $this->setError('Voer een geldige relatie in');
                            }
                            break;
                        case '2';
                            $count = $this->db->count('persons', ['id' => $relation]);
                            if ($count < 1) {
                                $this->setError('Voer een geldige relatie in');
                            }
                            break;
                        case '3';
                            $count = $this->db->count('suppliers', ['id' => $relation]);
                            if ($count < 1) {
                                $this->setError('Voer een geldige relatie in');
                            }
                            break;
                        default:
                            $this->setError('Voer een geldige relatie in');
                            break;
                    }
                }
            }
        } else {
            $this->setError('Je moet een geldige relatie invoeren');
        }

        if (isset($status)) {
            if (!ctype_digit($status)) {
                $this->setError('Voer een geldige status in');
            } else {
                if ($status === 1 | $status === 2 | $status === 3 | $status === 4) {
                    $this->setError('Voer een geldige status in.');
                }
            }
        }

        if (isset($facturering)) {
            if (!ctype_digit($facturering)) {
                $this->setError('Voer een geldige facturering status in');
            } else {
                if ($facturering === 1 | $facturering === 2 | $facturering === 3 | $facturering === 4) {
                    $this->setError('Voer een geldige facturering status in.');
                }
            }
        }

        $sentUserCheck = $this->db->count('users', ['id' => $sentUserID]);
        if (!$this->db->error()[2]) {
            if ($sentUserCheck > 0) {

            } else {
                $this->setError('Oeps er ging iets mis met het opslaan van de verstuurde gebruiker');
            }
        } else {
            $this->setError('Oeps er ging iets mis met het opslaan van de verstuurde gebruiker.');
        }

        if (!isset($date) || empty($date)) {
            $this->setError('Je moet een datum invoeren');
        } else {
//            if (!preg_match('/[^\d-]/', $date)) {
//                $this->setError('Je moet een geldige datum invoeren');
//            }

        }

        if ($traveltime) {
            if (!is_numeric($traveltime)) {
                $this->setError('Je moet een geldige reistijd invoeren');
            }
        }

        if ($this->getError()) {
            return false;
        }


        $this->db->insert('activities', [
            'text' => $text,
            'user' => $user,
            "relation_id" => $relation,
            "relation_type" => $type,
            "status" => $status,
            "facturering" => $facturering,
            "date" => $date,
            "time_from" => $from,
            "time_to" => $to,
            "traveltime" => $traveltime,
            "sentUser" => $sentUserID,
            "lastUser" => $sentUserID,
        ]);

        if ($this->db->error()[2]) {
            $this->setError('Oeps er ging iets mis!');
            return false;
        }
        if ($status === 2 || $status === 3){
            return true;
        } else {
            $this->notification->add(1, $user, $this->db->id());
            if ($this->notification->getError() == '') {
                return true;
            } else {
                $this->setError('Oeps er ging iets mis met de notificatie1' . $this->notification->getError());
                return false;
            }
        }
    }

//
    public function update($data = null, $column = null, $id = null, $sentUserID = null)
    {
        if ($column && $id) {
            if (!$data) {
                $data = '';
            }
            $data = strip_tags($data, '<b><strong><i><br><em><a>');

//            $sql = $this->db->debug()->update('activities', ["info" => $data],['id' => $id]);
            $this->db->update('activities', ["text" => $data, "lastUser" => $sentUserID], ['id' => $id]);
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


    public function update_contact($id = null, $user = null, $relation = null, $type = null, $status = null, $gefactureerd = null, $date = null, $from = null, $to = null, $traveltime = null, $sentUserID = null)
    {
        if ($id) {
            $user = strip_tags($user);
            $relation = strip_tags($relation);
            $type = strip_tags($type);
            $status = strip_tags($status);
            $gefactureerd = strip_tags($gefactureerd);
            $date = strip_tags($date);
            $from = strip_tags($from);
            $to = strip_tags($to);
            $traveltime = strip_tags($traveltime);
            $sentUserID = strip_tags($sentUserID);

            $data = $this->db->select('activities', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {

                if (isset($relation) && $relation && isset($type) && $type) {
                    if (!ctype_digit($relation) || !ctype_digit($type)) {
                        $this->setError('Voer een geldige relatie in');
                    } else {
                        if ($type != '1' && $type != '2') {
                            $this->setError('Er ging iets mis met de relatie');
                        } else {
                            switch ($type) {
                                case '1':
                                    $count = $this->db->count('companies', ['id' => $relation]);
                                    if ($count < 1) {
                                        $this->setError('Voer een geldige relatie in');
                                    }
                                    break;
                                case '2';
                                    $count = $this->db->count('persons', ['id' => $relation]);
                                    if ($count < 1) {
                                        $this->setError('Voer een geldige relatie in');
                                    }
                                    break;
                                case '3';
                                    $count = $this->db->count('suppliers', ['id' => $relation]);
                                    if ($count < 1) {
                                        $this->setError('Voer een geldige relatie in');
                                    }
                                    break;
                                default:
                                    $this->setError('Voer een geldige relatie in');
                                    break;
                            }
                        }
                    }
                }


                if (isset($user) && $user) {
                    if (!ctype_digit($user)) {
                        $this->setError('Voer een geldige gebruiker in');
                    } else {

                        $count = $this->db->count('users', ['id' => $user]);
                        if ($count < 1) {
                            $this->setError('Voer een geldige gebruiker in.');
                        }


                    }
                    if ($user != $data[0]['user']) {
                        $userChange = true;
                    } else {
                        $userChange = false;
                    }
                }


                if (!isset($status)) {
                    $status = $data[0]['status'];
                } else {
                    if (!ctype_digit($status)) {
                        $this->setError('Voer een geldige status in');
                    } else {
                        if ($status === 1 | $status === 2 | $status === 3 | $status === 4) {
                            $this->setError('Voer een geldige status in.');
                        }
                    }
                }

                if (!isset($gefactureerd)) {
                    $gefactureerd = $data[0]['facturering'];
                } else {
                    if (!ctype_digit($gefactureerd)) {
                        $this->setError('Voer een geldige status in');
                    } else {
                        if ($gefactureerd === 1 | $gefactureerd === 2 | $gefactureerd === 3 | $gefactureerd === 4 | $gefactureerd === 5) {
                            $this->setError('Voer een geldige status in.');
                        }
                    }
                }

                if (!isset($date) || empty($date)) {
                    $this->setError('Je moet een datum invoeren');
                }

                if (!isset($from)) {
                    $from = $data[0]['time_from'];
                }

                if (!isset($to)) {
                    $to = $data[0]['time_to'];
                }

                if (!isset($traveltime)) {
                    $to = $data[0]['traveltime'];
                } else {
                    if ($traveltime) {
                        if (!is_numeric($traveltime)) {
                            $this->setError('Je moet een geldige reistijd invoeren');
                        }
                    }
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('activities', [
                    "user" => $user,
                    "relation_id" => $relation,
                    "relation_type" => $type,
                    "status" => $status,
                    "facturering" => $gefactureerd,
                    "date" => $date,
                    "time_from" => $from,
                    "time_to" => $to,
                    "traveltime" => $traveltime,
                    "lastUser" => $sentUserID
                ],
                    ['id' => $id]
                );

                $error = $this->db->error();
                if (!$error[2]) {
                    $this->setError('');
                    if ($userChange) {
                        $this->notification->add(2, $user, $data[0]['id']);
                        if ($this->notification->getError() == '') {
                            return true;
                        } else {
                            $this->setError('Oeps er ging iets mis met de notificatie' . $this->notification->getError());
                            return false;
                        }
                    } else {
                        return true;
                    }
                }
                $this->setError('Oeps bijwerken is mislukt!.');
                return false;
            }
            $this->setError('Oeps kon taak niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }


    public
    function find($activity = null)
    {
        if ($activity) {
            $count = $this->db->count('activities', ['id' => $activity]);
            if ($count > 0) {
                $query = $this->db->select('activities', '*', ['id' => $activity]);
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

    public
    function getData($data, $replaced = null)
    {
        if ($this->data && $this->data[$data]) {
            if ($replaced) {
                return str_replace(' ', '%20', $this->data[$data]);
            }
            return $this->data[$data];
        }

        return '-';
    }

    public
    function getDataNormal($data, $replaced = null)
    {
        if ($this->data && $this->data[$data]) {
            if ($replaced) {
                return str_replace(' ', '%20', $this->data[$data]);
            }
            return $this->data[$data];
        }

        return '';
    }


    public
    function exists()
    {

    }

    public
    function delete($id = null)
    {
        if ($id) {

            $count = $this->db->count('activities', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('activities', ['id' => $id]);
                    if (!$this->db->error()[2]) {
                        $this->notification->delete($id);
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen taak gevonden');
                return false;
            }
            $this->setError('Geen taak gevonden.');
            return false;
        }
        $this->setError('Verwijderen mislukt');

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
        $count = $this->db->count('activities');
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
            case 3:
                return '<i
                            class="fad fa-pause-circle text-indianred"></i> In behandeling';
                break;
            case 4:
                return '<i
                            class="fad fa-dolly text-warning"></i> Wachten op klant';
                break;
        }
    }

    public
    function getGefactureerd($id)
    {
        switch ($id) {
            case 1:
                return '<i
                            class="fad fa-print"></i> Nee';
                break;
            case 2:
                return '<i
                            class="fad fa-print text-green"></i> Ja';
                break;
            case 3:
                return '<i
                            class="fad fa-shield-alt text-cyan"></i> Service / Garantie';
                break;
            case 4:
                return '<i
                            class="fad fa-badge text-warning"></i> Eigen gebruik';
                break;
            case 5:
                return '<i
                            class="fad fa-file-contract text-primary"></i> Contract';
                break;
        }
    }


    public
    function getRelation($id = null, $type = null)
    {
        if ($id && $type) {
            switch ($type) {
                case 1:
                    //Company
                    $count = $this->db->count('companies', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('companies', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return '<i class="fad fa-building text-orangered"></i> ' . $data[0]['name'];
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
                case 2:
                    //Contact
                    $count = $this->db->count('persons', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('persons', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return '<i class="fad fa-user text-orange"></i> ' . $data[0]['name'];
                        }
                        return false;
                    }

                    return false;
                    break;
                case 3:
                    //suppliers
                    $count = $this->db->count('suppliers', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('suppliers', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return '<i class="fad fa-truck-loading text-cyan search_icon"></i> ' . $data[0]['name'];
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
                default:
                    return 'Geen relatie';
                    break;
            }
        } else {
            return '<i class="fad fa-circle-notch text-orange"></i> ' . '-';
        }
        return false;
    }

    public
    function getRelationName($id = null, $type = null)
    {
        if ($id && $type) {
            switch ($type) {
                case 1:
                    //Company
                    $count = $this->db->count('companies', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('companies', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return $data[0]['name'];
                        }
                        return false;
                    }

                    return false;
                    break;
                case 2:
                    //Contact
                    $count = $this->db->count('persons', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('persons', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return $data[0]['name'];
                        }
                        return false;
                    }

                    return false;
                    break;
                case 3:
                    //Suppliers
                    $count = $this->db->count('suppliers', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('suppliers', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return $data[0]['name'];
                        }
                        return false;
                    }

                    return false;
                    break;
            }
        } else {
            return false;
        }
        return false;
    }

    public function update_facturering($id = null, $facturering = null)
    {
        if ($id && $facturering) {
            $facturering = intval($facturering);
            $data = $this->db->select('activities', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($facturering === 1 | $facturering === 2 | $facturering === 3 | $facturering === 4 | $facturering === 5) {
                } else {
                    $this->setError('Geef een geldige facturering mee!');
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('activities', [
                    "facturering" => $facturering,
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
            $this->setError('Oeps kon taak niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }

    public function update_status($id = null, $status = null)
    {
        if ($id && $status) {
            $status = intval($status);
            $data = $this->db->select('activities', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($status === 1 | $status === 2 | $status === 3 | $status === 4) {
                } else {
                    $this->setError('Geef een geldige status mee!');
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('activities', [
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
            $this->setError('Oeps kon taak niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }

}


<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Order
{
    public $db;
    public $notification;
    public $data;
    public $error;

    /**
     * User constructor.
     * @param null $order
     */
    public function __construct($order = null)
    {
        $this->db = new Medoo(DB_INIT);
        $this->notification = new Notification();
        if ($order) {
            if (!$this->find($order)) {
                Header('Location: /bestelling');
            }
        }
    }

    public function create($text = null, $relation = null, $price, $type = null, $status = null, $facturering = null, $date = null)
    {
        $relation = strip_tags($relation);
        $type = strip_tags($type);
        $status = strip_tags($status);
        $price = preg_replace('~\x{00a0}~siu', '', $price);
        $facturering = strip_tags($facturering);
        $date = strip_tags($date);
        $text = strip_tags($text, '<b><strong><i><br><a>');


        if (!$text) {
            $text = '';
        }

        if (isset($relation) && $relation && isset($type) && $type && !empty($relation) && !empty($type)) {
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
                if ($status === 1 | $status === 2) {
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

        if (!isset($date) || empty($date)) {
            $this->setError('Je moet een datum invoeren');
        }

        $priceMatch = '/^\d+(\.\d{2})?$/';

        if ($facturering == 3) {
            if ($price == '' || $price == 0) {
                $price = 0;
            } else {
                if (!preg_match($priceMatch, $price)) {
                    $this->setError('Je moet een geldige prijs invoeren');
                }
            }
            if (strlen($price) > 10) {
                $this->setError('Deze prijs is te lang');
            }
        } else {
            if (!isset($price) || empty($price)) {
                $this->setError('Je moet een prijs invoeren');
            } else {
                if ($price === 0) {
                    $price = 0;
                } else {
                    if (!preg_match($priceMatch, $price)) {
                        $this->setError('Je moet een geldige prijs invoeren');
                    }
                }
                if (strlen($price) > 10) {
                    $this->setError('Deze prijs is te lang');
                }
            }
        }


        if ($this->getError()) {
            return false;
        }


        $this->db->insert('orders', [
            'text' => $text,
            "relation_id" => $relation,
            "relation_type" => $type,
            "status" => $status,
            "facturering" => $facturering,
            "date" => $date,
            "price" => $price,
        ]);

        if ($this->db->error()[2]) {
            $this->setError('Oeps er ging iets mis!');
            return false;
        } else {
            return true;
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

//            $sql = $this->db->debug()->update('orders', ["info" => $data],['id' => $id]);
            $this->db->update('orders', ["text" => $data], ['id' => $id]);
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


    public function update_contact($id = null, $relation = null, $type = null, $price = null, $status = null, $gefactureerd = null, $date = null)
    {
        if ($id) {
            $relation = strip_tags($relation);
            $type = strip_tags($type);
            $price = strip_tags($price);
            $price = preg_replace('~\x{00a0}~siu', '', $price);
            $status = strip_tags($status);
            $gefactureerd = strip_tags($gefactureerd);
            $date = strip_tags($date);

            $data = $this->db->select('orders', '*', ['id' => $id]);
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
                                default:
                                    $this->setError('Voer een geldige relatie in');
                                    break;
                            }
                        }
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

                if (!isset($gefactureerd)) {
                    $gefactureerd = $data[0]['facturering'];
                } else {
                    if (!ctype_digit($gefactureerd)) {
                        $this->setError('Voer een geldige status in');
                    } else {
                        if ($gefactureerd === 1 | $gefactureerd === 2 | $gefactureerd === 3 | $gefactureerd === 4) {
                            $this->setError('Voer een geldige status in.');
                        }
                    }
                }
                if (!isset($date) || empty($date)) {
                    $this->setError('Je moet een datum invoeren');
                }
                $priceMatch = '/^\d+(\.\d{2})?$/';
                if ($gefactureerd == 3) {
                    if ($price == '' || $price == 0) {
                        $price = 0;
                    } else {
                        if (!preg_match($priceMatch, $price)) {
                            $this->setError('Je moet een geldige prijs invoeren');
                        }
                    }
                    if (strlen($price) > 10) {
                        $this->setError('Deze prijs is te lang');
                    }
                } else {
                    if (!isset($price) || empty($price)) {
                        $this->setError('Je moet een prijs invoeren');
                    } else {
                        if ($price === 0) {
                            $price = 0;
                        } else {
                            if (!preg_match($priceMatch, $price)) {
                                $this->setError('Je moet een geldige prijs invoeren');
                            }
                        }
                        if (strlen($price) > 10) {
                            $this->setError('Deze prijs is te lang');
                        }
                    }
                }
                if ($this->getError()) {
                    return false;
                }


                $this->db->update('orders', [
                    "relation_id" => $relation,
                    "relation_type" => $type,
                    "status" => $status,
                    "facturering" => $gefactureerd,
                    "date" => $date,
                    "price" => $price,
                ],
                    ['id' => $id]
                );

                $error = $this->db->error();
                if (!$error[2]) {
                    $this->setError('');
                    return true;
                }
                $this->setError('Oeps bijwerken is mislukt!.');
                return false;
            }
            $this->setError('Oeps kon bestelling niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }


    public
    function find($order = null)
    {
        if ($order) {
            $count = $this->db->count('orders', ['id' => $order]);
            if ($count > 0) {
                $query = $this->db->select('orders', '*', ['id' => $order]);
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
    function exists()
    {

    }

    public
    function delete($id = null)
    {
        if ($id) {

            $count = $this->db->count('orders', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('orders', ['id' => $id]);
                    if (!$this->db->error()[2]) {
                        $this->notification->delete($id);
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen bestelling gevonden');
                return false;
            }
            $this->setError('Geen bestelling gevonden.');
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
        $count = $this->db->count('orders');
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
                            class="fad fa-check-double"></i> Nee';
                break;
            case 2:
                return '<i
                            class="fad fa-check-double text-green"></i> Ja';
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
                    }

                    return false;
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
            $data = $this->db->select('orders', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($facturering === 1 | $facturering === 2 | $facturering === 3 | $facturering === 4) {
                } else {
                    $this->setError('Geef een geldige facturering mee!');
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('orders', [
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
            $this->setError('Oeps kon bestelling niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }

    public function update_status($id = null)
    {
        if ($id) {

            $data = $this->db->select('orders', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {
                $status = $data[0]['status'];
                if ($status == '1') {
                    $newstatus = 2;
                } else {
                    $newstatus = 1;
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('orders', [
                    "status" => $newstatus,
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
            $this->setError('Oeps kon bestelling niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }

}


<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class ProspectActivities
{
    public $db;
    public $data;
    public $limit;
    public $error;

    public function __construct($id = null, $limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($id) {
            $this->find($id);
        }
        if ($limit) {
            $this->limit = $limit;
        }
    }

    public function find($id = null)
    {
        if ($id) {

            $count = $this->db->count('prospects_activities', ['id' => $id]);

            $error = $this->db->error();
            if (!$error[2]) {
                if ($count > 0) {
                    $query = $this->db->select('prospects_activities', '*', ['id' => $id]);
                    if (!$error[2]) {
                        return $query[0];
                    } else {
                        return 'Not found';
                    }
                }
            } else {
                return 'Not found';
            }
            return 'Not found';
        }

        return 'Not found';
    }

    /**
     * @param mixed $error
     */
    public
    function setError($error)
    {
        $this->error .= $error . '<br>';
    }

    public function findBoolean($id = null)
    {
        if ($id) {

            $count = $this->db->count('prospects_activities', ['id' => $id]);

            $error = $this->db->error();
            if (!$error[2]) {
                if ($count > 0) {
                    $query = $this->db->select('prospects_activities', '*', ['id' => $id]);
                    if (!$error[2]) {
                        return $query[0];
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
                return false;
            }
        }
        return false;
    }

    public
    function findAll($limit_1 = null, $limit_2 = null, $user = null, $statussort = null, $gefactureerdsort = null, $datumsort = null)
    {
        if ($user) {
            if ($gefactureerdsort) {
                $querysql = "SELECT * FROM `prospects_activities` WHERE `user` = '" . $user . "' ORDER BY facturering " . $gefactureerdsort . " , id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } elseif ($statussort) {
                $querysql = "SELECT * FROM `prospects_activities` WHERE `user` = '" . $user . "'  ORDER BY status " . $statussort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } elseif ($datumsort) {
                $querysql = "SELECT * FROM `prospects_activities` WHERE `user` = '" . $user . "'  ORDER BY STR_TO_DATE(date,'%d-%c-%Y') " . $datumsort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } else {
                $querysql = "SELECT * FROM `prospects_activities` WHERE `user` = '" . $user . "'  ORDER BY STR_TO_DATE(date,'%d-%c-%Y') DESC, id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            }
//            $query = $this->db->select('prospects_activities', '*', ['user' => $user, "LIMIT" => [$limit_1, $limit_2], "ORDER" => $order]);
            $query = $this->db->query($querysql)->fetchAll();
        } else {
            if ($gefactureerdsort) {
                $querysql = "SELECT * FROM `prospects_activities` ORDER BY facturering " . $gefactureerdsort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } elseif ($statussort) {
                $querysql = "SELECT * FROM `prospects_activities` ORDER BY status " . $statussort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } elseif ($datumsort) {
                $querysql = "SELECT * FROM `prospects_activities` ORDER BY STR_TO_DATE(date,'%d-%c-%Y') " . $datumsort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            } else {
                $querysql = "SELECT * FROM `prospects_activities` ORDER BY STR_TO_DATE(date,'%d-%c-%Y') DESC, id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            }
//            $query = $this->db->select('prospects_activities', '*', ["LIMIT" => [$limit_1, $limit_2], "ORDER" => $order]);
            $query = $this->db->query($querysql)->fetchAll();
        }
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

    public
    function findAllId($limit_1 = null, $limit_2 = null, $id = NULL, $type = NULL)
    {
        if ($id) {
            $querysql = "SELECT * FROM `prospects_activities` WHERE `prospect` = '" . $id . "'  ORDER BY STR_TO_DATE(date,'%d-%c-%Y') DESC,id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
            //            $query = $this->db->select('prospects_activities', '*', ['user' => $user, "LIMIT" => [$limit_1, $limit_2], "ORDER" => $order]);
            $query = $this->db->query($querysql)->fetchAll();
        }
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

    public
    function getFacturering($id)
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
    function getStatus($id)
    {
        switch ($id) {
            case 1:
                return '<i
                            class="fad fa-clock"></i> Open';
                break;
            case 2:
                return '<i
                            class="fad fa-phone text-orange"></i> Gebeld';
                break;
            case 3:
                return '<i
                            class="fad fa-phone-volume text-blue"></i> Terugbellen';
                break;
            case 4:
                return '<i
                            class="fad fa-calendar-check text-success"></i> Afspraak gemaakt';
                break;
            case 5:
                return '<i
                            class="fad fa-times text-danger"></i> Niet geïnteresseerd';
                break;
        }
    }

    public
    function getRelation($id, $type)
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
                    } else {
                        return false;
                    }
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
            }
        }
        return false;
    }

    public
    function getRelationData($id, $type, $datatag)
    {
        if ($id && $type) {
            switch ($type) {
                case 1:
                    //Company
                    $count = $this->db->count('companies', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('companies', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            if ($data[0][$datatag]) {
                                return $data[0][$datatag];
                            } else {
                                return '-';
                            }
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
                            if ($data[0][$datatag]) {
                                return $data[0][$datatag];
                            } else {
                                return '-';
                            }
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
            }
        }
        return false;
    }

    public
    function getRelationColor($id, $type)
    {
        if ($id && $type) {
            switch ($type) {
                case 1:
                    //Company
                    $count = $this->db->count('companies', ['id' => $id]);
                    if ($count > 0 && !$this->db->error()[2]) {
                        $data = $this->db->select('companies', '*', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return 'text-orangered';
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
                            return 'text-orange';
                        }
                        return false;
                    } else {
                        return false;
                    }
                    break;
            }
        }
        return false;
    }

    public
    function replaceTag($str, $tags)
    {
        foreach ($tags as $old => $new)
            $str = preg_replace("~<(/)?$old>~", "<\\1$new>", $str);
        return $str;
    }

    public
    function getExcerpt($text)
    {
        $test = mb_substr($text, 0, 50);
        $test = strip_tags($test);
        $test = $test . '...';
        $test = str_replace(array("\r", "\n", "<br />", "<br>", "<br >", "<strong>", "<b>", "</strong>", "<a>"), ' ', $test);

        $test = htmlspecialchars($test);


        return $test;
    }

    public
    function getExcerptFull($test)
    {
        $test = strip_tags($test);
        $test = $test . '...';
        $test = str_replace(array("\r", "\n", "<br />", "<br>", "<br >", "<strong>", "<b>", "</strong>", "<a>"), ' ', $test);

        $test = htmlspecialchars($test);


        return $test;
    }

    public
    function getUser($id)
    {
        $query = $this->db->select('users', '*', ['id' => $id]);
        if (!$this->db->error()[2]) {
            return $query[0]['name'];
        }
        return $this->db->error()[2];
    }

    public
    function getCount($id)
    {
        $data = $this->db->count('prospects_activities', ['user' => $id, 'status' => [1, 3, 4]]);
        if (!$this->db->error()[2]) {
            return $data;
        }
        return $this->db->error()[2];
    }

    public function update_status($id = null, $status = null)
    {
        if ($id && $status) {
            $status = intval($status);
            $data = $this->db->select('prospects_activities', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($status === 1 | $status === 2 | $status === 3 | $status === 4 | $status === 5) {
                } else {
                    $this->setError('Geef een geldige status mee!');
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('prospects_activities', [
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
            $this->setError('Oeps kon de activiteit niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    public function create($status = null, $info = null, $id = null, $date = null, $activity_date = null,$user = null)
    {
        $status = strip_tags($status);
        $id = strip_tags($id);
        $user = strip_tags($user);
        $date = strip_tags($date);
        $activity_date = strip_tags($activity_date);
        $info = strip_tags($info, '<b><strong><i><br><a>');

        if (isset($id)) {
            if (!ctype_digit($id)) {
                $this->setError('Voer een geldige id in');
            }
        } else {
            $this->setError('Voer een geldige id in');
        }

        if (!$info) {
            $info = '';
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

        if (isset($user)) {
            if (!ctype_digit($user)) {
                $this->setError('Voer een geldige status in');
            } else {
                $userCount = $this->db->count('users',['id' => $user]);
                if(!$this->db->error()[2]){
                    if($userCount < 1){
                        $this->setError('Voer een geldige status in.');
                    }
                } else {
                    $this->setError('Voer een geldige status in.');
                }
            }
        }

        if (!isset($date) || empty($date)) {
            $this->setError('Je moet een datum invoeren');
        }
        if (!isset($activity_date) || empty($activity_date)) {
            $this->setError('Je moet een datum invoeren');
        }

        if ($this->getError()) {
            return false;
        }
        $activity_date = strtotime($activity_date);
        $activity_date = date('Y-m-d',$activity_date);

        $date = strtotime($date);
        $date = date('Y-m-d',$date);
        $this->db->insert('prospects_activities', [
            'info' => $info,
            "status" => $status,
            'prospect' => $id,
            'date' => $date,
            'activity_date' => $activity_date,
            'user' => $user
        ]);

        $this->db->update('prospects', ['date' => $activity_date,'status'=>$status], ['id' => $id]);

        if ($this->db->error()[2]) {
            $this->setError('Oeps er ging iets mis!');
            return false;
        }
        return true;
    }


    public function update($status = null, $info = null, $id = null, $date = null, $activity_date = null)
    {
        if ($id) {
            $status = strip_tags($status);
            $id = strip_tags($id);
            $activity_date = strip_tags($activity_date);
            $date = strip_tags($date);
            $info = strip_tags($info, '<b><strong><i><br><a>');


            $data = $this->db->select('prospects_activities', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {


                if (!isset($status)) {
                    $status = $data[0]['status'];
                } else {
                    if (!ctype_digit($status)) {
                        $this->setError('Status is ongeldig');
                    }
                }
                if (trim($status) == "") {
                    $this->setError('ERROR!');
                }

                if (!isset($date)) {
                    $date = $data[0]['date'];
                }
                if (!isset($activity_date)) {
                    $activity_date = $data[0]['activity_date'];
                }
                if (!isset($info)) {
                    $info = $data[0]['info'];

                }
                if (trim($info) == "") {
                    $info = '';
                }


                if ($this->getError()) {
                    return false;
                }

                $activity_date = strtotime($activity_date);
                $activity_date = date('Y-m-d',$activity_date);
                $date = strtotime($date);
                $date = date('Y-m-d',$date);
                $this->db->update('prospects_activities', [
                    'info' => $info,
                    "status" => $status,
                    'date' => $date,
                    'activity_date' => $activity_date
                ],
                    ['id' => $id]
                );
                $dataID = $this->db->select('prospects_activities', '*', ['id' => $id]);
                $dataLast = $this->db->select('prospects_activities', '*', ['LIMIT' => 1, 'ORDER' => ['id' => 'DESC']]);
                $lastID = $dataLast[0]['id'];
                if ($lastID == $id) {
                    $this->db->update('prospects', ['date' => $activity_date,'status' =>$dataID[0]['status']], ['id' => $dataID[0]['prospect']]);
                }

                $error = $this->db->error();
                if (!$error[2]) {
                    $this->setError('');
                    return true;
                }
                $this->setError('Oeps bijwerken is mislukt!' . $error[2]);
                return false;
            }
            $this->setError('Oeps kon prospect niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }


}

?>
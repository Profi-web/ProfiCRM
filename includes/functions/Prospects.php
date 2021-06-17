<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Prospects
{
    public $db;
    public $data;
    public $dataTerms = array();
    public $limit;


    public function __construct($prospect = null, $limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($prospect) {
            $this->find($prospect);
        }
        if ($prospect) {
            $this->limit = $limit;
        }
    }

    public function find($prospect = null)
    {
        if ($prospect) {
            $query = $this->db->select('prospects', '*', ['id' => $prospect]);
            $error = $this->db->error();
            if (!$error[2]) {
                return $query[0];
            }
            return 'Not found';
        }

        return 'Not found';
    }

    public function findAll($limit_1 = null, $limit_2 = null, $statussort = null, $citysort = null, $from_datesort = null,$to_datesort = null)
    {


        if ($statussort) {
            if ($citysort) {
                $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "'  ORDER BY status " . $statussort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "' AND date BETWEEN '" . $from_datesort . "' AND '".$to_datesort."'  ORDER BY status " . $statussort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
                }
            } else {
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE date BETWEEN '" . $from_datesort . "' AND '".$to_datesort."'  ORDER BY status " . $statussort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
                } else {
                    $querysql = "SELECT * FROM `prospects`  ORDER BY status " . $statussort . ", id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;

                }
            }
        } else {
            if ($citysort) {
                $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "'  ORDER BY  id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "' AND date BETWEEN '" . $from_datesort . "' AND '".$to_datesort."'  ORDER BY  id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
                }
            } else {
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE date BETWEEN '" . $from_datesort . "' AND '".$to_datesort." ' ORDER BY  id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;
                } else {
                    $querysql = "SELECT * FROM `prospects` ORDER BY  id DESC LIMIT " . $limit_2 . " OFFSET " . $limit_1;

                }
            }
        }

        $query = $this->db->query($querysql)->fetchAll();
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }
    public function findAllCSV($statussort = null, $citysort = null, $from_datesort = null,$to_datesort = null)
    {


        if ($statussort) {
            if ($citysort) {
                $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "'  ORDER BY status " . $statussort . ", id DESC" ;
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "' AND date BETWEEN '" . $from_datesort . "' AND '".$to_datesort."'  ORDER BY status " . $statussort . ", id DESC " ;
                }
            } else {
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE date BETWEEN '" . $from_datesort . "' AND '".$to_datesort."'  ORDER BY status " . $statussort . ", id DESC ";
                } else {
                    $querysql = "SELECT * FROM `prospects`  ORDER BY status " . $statussort . ", id DESC  ";

                }
            }
        } else {
            if ($citysort) {
                $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "'  ORDER BY  id DESC " ;
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "' AND date BETWEEN '" . $from_datesort . "' AND '".$to_datesort."'  ORDER BY  id DESC " ;
                }
            } else {
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE date BETWEEN '" . $from_datesort . "' AND '".$to_datesort." ' ORDER BY  id DESC";
                } else {
                    $querysql = "SELECT * FROM `prospects` ORDER BY  id DESC";

                }
            }
        }

        $query = $this->db->query($querysql)->fetchAll();
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }
    public function findAllNoLimit($statussort = null, $citysort = null, $from_datesort = null,$to_datesort = null)
    {


        if ($statussort) {
            if ($citysort) {
                $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "'  ORDER BY status " . $statussort . ", id DESC ";
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "' AND date BETWEEN '" . $from_datesort . "' AND '".$to_datesort."'  ORDER BY status " . $statussort . ", id DESC";
                }
            } else {
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE date BETWEEN '" . $from_datesort . "' AND '".$to_datesort."'  ORDER BY status " . $statussort . ", id DESC ";
                } else {
                    $querysql = "SELECT * FROM `prospects`  ORDER BY status " . $statussort . ", id DESC";

                }
            }
        } else {
            if ($citysort) {
                $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "'  ORDER BY  id DESC ";
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE city = '" . $citysort . "' AND date BETWEEN '" . $from_datesort . "' AND '".$to_datesort."'  ORDER BY  id DESC ";
                }
            } else {
                if ($from_datesort && $to_datesort) {
                    $querysql = "SELECT * FROM `prospects` WHERE date BETWEEN '" . $from_datesort . "' AND '".$to_datesort." ' ORDER BY  id DESC";
                } else {
                    $querysql = "SELECT * FROM `prospects` ORDER BY  id DESC ";

                }
            }
        }

        $query = $this->db->query($querysql)->fetchAll();
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

    public function getStatus($id)
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
    public function getStatusClean($id)
    {
        switch ($id) {
            case 1:
                return 'Open';
                break;
            case 2:
                return 'Gebeld';
                break;
            case 3:
                return 'Terugbellen';
                break;
            case 4:
                return 'Afspraak gemaakt';
                break;
            case 5:
                return 'Niet geïnteresseerd';
                break;
        }
    }

    public function getLastStatus($id)
    {
        if ($id) {
            $count = $this->db->count('prospects_activities', ['prospect' => $id]);
            $error = $this->db->error();
            if (!$error[2]) {
                if ($count > 0) {
                    $query = $this->db->select('prospects_activities', '*', ['prospect' => $id, "LIMIT" => 1, "ORDER" => ['id' => 'DESC']]);
                    if (!$error[2]) {
                        return $query[0]['status'];
                    }
                    return 'Not found';
                } else {
                    return 1;
                }
            }
            return 'Not found';


        }

        return 'Not found';
    }

    public function getLastStatusDate($id)
    {
        if ($id) {
            $count = $this->db->count('prospects_activities', ['prospect' => $id]);
            $error = $this->db->error();
            if (!$error[2]) {
                if ($count > 0) {
                    $query = $this->db->select('prospects_activities', '*', ['prospect' => $id, "LIMIT" => 1, "ORDER" => ['id' => 'DESC']]);
                    if (!$error[2]) {
                        return $query[0]['activity_date'];
                    }
                    return 'Not found';
                } else {
                    return '-';
                }
            }
            return 'Not found';


        }

        return 'Not found';
    }

    public function findTerm($term = null)
    {
        if ($term) {
            $error = 1;

            //Companies
            $count = $this->db->count('prospects', ['city[~]' => '%' . $term . '%']);
            if ($count > 0) {
                $query = $this->db->select('prospects', '*', ['city[~]' => '%' . $term . '%']);
                if (!$this->db->error()[2]) {
                    $this->dataTerms['prospects'] = $query;
                }
                ++$error;
            }
            ++$error;


            if ($error === 1) {
                return true;
            }
            return false;
        }

        return false;

    }

}

?>
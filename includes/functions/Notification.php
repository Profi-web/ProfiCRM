<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Notification
{
    public $db;
    public $data;
    public $error;

    /**
     * User constructor.
     * @param null $notification
     */
    public function __construct($notification = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($notification) {
            if (!$this->find($notification)) {
                Header('Location: /');
            }
        }
    }

    public
    function delete($id = null)
    {
        if ($id) {

            $count = $this->db->count('notifications', ['relation' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('notifications', ['relation' => $id]);
                    if (!$this->db->error()[2]) {
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen notificatie gevonden');
                return false;
            }
            $this->setError('Geen notificatie gevonden.');
            return false;
        }
        $this->setError('Verwijderen mislukt');

        return false;
    }

    public function add($type = null, $user = null, $relation = null)
    {
        $type = strip_tags($type);
        $user = strip_tags($user);
        $relation = strip_tags($relation);


        if (!$type) {
            $this->setError('Er moet een type zijn meegegeven');
        } else {
            if (!is_numeric($type)) {
                $this->setError('De type moet een nummer zijn.');
            }
            if ($type == 1) {
                if (!$relation) {
                    $this->setError('Er moet een relatie zijn meegegeven ( Geen relatie)');
                }
                $userclass = new User($user);
                $activity = new Activity($relation);
                if ($activity->data['relation_type'] == 1) {
                    $connected = new Company($activity->data['relation_id']);
                } elseif ($activity->data['relation_type'] == 2) {
                    $connected = new Person($activity->data['relation_id']);
                } elseif ($activity->data['relation_type'] == 3) { 
                    $connected = new Supplier($activity->data['relation_id']);
                } else {
                    $this->setError('Er moet een relatie zijn meegegeven');
                }
            } elseif ($type == 2) {
                if (!$relation) {
                    $this->setError('Er moet een relatie zijn meegegeven');
                }
                $userclass = new User($user);
                $activity = new Activity($relation);
                if ($activity->data['relation_type'] == 1) {
                    $connected = new Company($activity->data['relation_id']);
                } elseif ($activity->data['relation_type'] == 2) {
                    $connected = new Person($activity->data['relation_id']);
                }elseif ($activity->data['relation_type'] == 3) {
                    $connected = new Supplier($activity->data['relation_id']);
                }else {
                    $this->setError('Er moet een relatie zijn meegegeven');
                }
            }
        }


        if (!$user) {
            $this->setError('Er moet een user zijn meegegeven');
        } else {
            if (!is_numeric($user)) {
                $this->setError('De user moet een nummer zijn.');
            }
        }

        if ($this->getError()) {
            return false;
        }


        $this->db->insert('notifications', [
            'type' => $type,
            'user' => $user,
            'relation' => $relation,
        ]);

        if ($this->db->error()[2]) {
            $this->setError('Oeps er ging iets mis!');
            return false;
        }

        $subject = '';
        $msg = '';
        switch ($type) {
            case 1:
                $subject = $this->ActivityNew($relation, $userclass->data['name'], $connected->data['name'], $activity, 2);
                $msg = $this->ActivityNew($relation, $userclass->data['name'], $connected->data['name'], $activity, 1);
                break;
            case 2:
                $subject = $this->ActivityNew($relation, $userclass->data['name'], $connected->data['name'], $activity, 2);
                $msg = $this->ActivityNew($relation, $userclass->data['name'], $connected->data['name'], $activity, 1);
                break;
        }

        $mailer = new Mailer($userclass->data['email'], $subject,
            $msg
            , 'notification@profi-crm.nl');
        if (!$mailer->send()) {
            $this->setError($mailer->getError());
            return false;
        }


        return true;

    }

//

    public function getExcerpt($text)
    {
        $textempty = strip_tags($text);
        $leng = strlen($textempty);
        if ($leng > 150) {
            $test = mb_substr($text, 0, 150);
        } else {
            $test = $text;
        }

        $test = $test . '...';

        $test = str_replace(array("\r", "\n", "<br />", "<br>", "<br >", "<strong>", "<b>", "</strong>"), ' ', $test);

        return $test;
    }

    public function ActivityNew($relation, $name, $connected, $activity, $return)
    {
        $text = $this->getExcerpt($activity->data['text']);
        /**
         * @var Activity $activity
         */
        switch ($return) {
            case 1;
                return ' <div class="emailHolder" style="
display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin: auto;
        margin-top: 50px;
        width: 90%;
        min-height: 200px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
                font-family: Roboto, serif;
">
    <div class="emailTop" style="
   background: #F7FAFC;
   border:5px solid #F7FAFC;
        width: 100%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center">
                        <img src="https://profi-crm.nl/assets/media/logo.png" width="150" alt="Profi-crm" style=" width: 150px;
        margin: auto;"/>
                    </td>
                </tr>
            </table>
    </div>
    <div class="emailContent holder" style="  background: white;border:5px solid white;      padding: 20px 40px !important;
"> 
        <h2>Nieuwe taak in CRM (#' . $relation . ')</h2>
        <p>
                Hallo ' . $name . '<br>
                Er staat een nieuwe taak klaar in het CRM. 
        </p>
        <div style="width:100%;background:grey;padding:10px;border-radius:10px;font-style:italic">
          ' . $text . '
           </div>
        <a class="btn btn-info rounded text-white btn-sm" href="https://profi-crm.nl/taak?id=' . $relation . '" style="

   display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none; 
        border: 4px #3da4f4 solid;
        color: #fff;
        text-decoration: none;
        background-color: #3da4f4;
        cursor: pointer;
">Bekijken
        </a>
    </div>
    <div class="emailBottom" style="
        text-align: center;
        color: grey;
        background: #F7FAFC;
        border:5px solid #F7FAFC;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        width: 100%;
">
        <div>
            Deze email is afkomstig van www.profi-crm.nl
        </div>
    </div>
</div>
<style>
    @import url(\'https://fonts.googleapis.com/css?family=Roboto&display=swap\');
    </style>';
                break;
            case 2;
                return 'Nieuwe taak in het CRM voor ' . $connected . ' (#' . $relation . ')';
                break;
            default:
                return false;
                break;
        }

    }


    public function find($notification = null)
    {
        if ($notification) {
            $query = $this->db->select('notifications', '*', ['id' => $notification]);
            $error = $this->db->error();
            if (!$error[2]) {
                return $query[0];
            }
            return 'Not found';
        }

        return 'Not found';
    }

    public function findAll()
    {
        $query = $this->db->select('notifications', '*', ["ORDER" => 'datetime']);

        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

    }

    public function findAllUser($user)
    {
        $query = $this->db->select('notifications', '*', ["user" => $user, 'viewed' => 1, "ORDER" => ['datetime' => 'DESC', 'id' => 'DESC']]);

        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Not found';

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

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    public function countUser($user)
    {
        $count = $this->db->count('notifications', ["user" => $user, "ORDER" => 'datetime', "viewed" => 1]);
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

    public function updateView($notification, $user)
    {
        if ($notification) {
            $count = $this->db->count('notifications', ['relation' => $notification, 'user' => $user]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->update('notifications', ['viewed' => 2], ['relation' => $notification, 'user' => $user]);
                    if (!$this->db->error()[2]) {
                        return true;
                    }
                    $this->setError('Updaten mislukt');
                    return false;
                }
                $this->setError('Geen notificatie gevonden');
                return false;
            }
            $this->setError('Geen notificatie gevonden.');
            return false;
        }

        return 'Not found';
    }

}


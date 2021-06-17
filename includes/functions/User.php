<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class User
{
    public $db;
    public $data;
    public $isLoggedIn;
    public $error;
    public $all = false;

    /**
     * User constructor.
     * @param null $user
     */
    public function __construct($user = null, $disable = null)
    {
        $this->db = new Medoo(DB_INIT);

        if (!$user) {
            if (Session::exists('userid')) {
                $user = Session::get('userid');
                if ($this->find($user)) {
                    $this->isLoggedIn = True;
                }
            }
        } else {

            if (!$this->find($user)) {
                if (!$disable) {
                    header('Location: /');
                }
            }
        }
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function find($user = null)
    {
        if ($user) {
            $count = $this->db->count('users', ['id' => $user]);
            $error = $this->db->error();
            if (!$error[2]) {
                if ($count > 0) {
                    $query = $this->db->select('users', '*', ['id' => $user]);
                    $error = $this->db->error();
                    if (!$error[2]) {
                        $this->data = $query[0];
                        return true;
                    }
                    return false;
                }
                return false;
            }
            return false;
        }
        return false;
    }


    public
    function exists()
    {

    }

    public
    function delete($id)
    {
        if ($id) {

            $count = $this->db->count('users', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('users', ['id' => $id]);
                    if (!$this->db->error()[2]) {
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen medewerker gevonden');
                return false;
            }
            $this->setError('Geen medewerker gevonden.');
            return false;
        }
        $this->setError('Verwijderen mislukt');

        return false;
    }

    public function getRole()
    {
        $query = $this->db->select('user_roles', 'name', ['id' => $this->data['role']]);
        if (!$this->db->error()[2]) {
            return $query[0];
        }

        return '-';

    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error .= $error . '<br>';
    }

}


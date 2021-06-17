<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Reset
{
    public $db;
    public $error;
    public $key;
    public $user;
    public $password_1;
    public $password_2;

    public function __construct()
    {
        $this->db = new Medoo(DB_INIT);
    }

    public function validateInput($password_1 = null, $password_2 = null, $key = null)
    {
        if (!$key) {
            $this->setError('Geen geldige code');
            return false;
        }

        if (!$password_1) {

            $this->setError('Vul een wachtwoord in');
            return false;
        }

        if (!$password_2) {

            $this->setError('Vul het wachtwoord nogmaals in');
            return false;
        }
        if ($password_1 !== $password_2) {
            $this->setError('Wachtwoorden zijn niet gelijk aan elkaar');
            return false;
        }

        $this->setPassword1($password_1);
        $this->setPassword2($password_2);

        list($selector, $authenticator) = explode(':', $key);
        $selector = rawurldecode($selector);
        $authenticator = rawurldecode(base64_decode($authenticator));
        $count = $this->db->count('password_forgot', ['selector' => $selector]);
        if ($count > 0) {
            $data = $this->db->select('password_forgot', '*', ['selector' => $selector]);
            if (hash_equals($data[0]['token'], hash('sha256', $authenticator))) {
                $this->setKey($key);
                $this->setUser($data[0]['userid']);
                return true;
            }
            $this->setError('Geen geldige code');
            return false;
        }
        return false;

    }

    public function changePassword()
    {
        list($selector, $authenticator) = explode(':', $this->getKey());
        $selector = rawurldecode($selector);
        $authenticator = rawurldecode(base64_decode($authenticator));

        $count = $this->db->count('password_forgot', ['selector' => $selector]);
        if ($count > 0) {
            $data = $this->db->select('password_forgot', '*', ['selector' => $selector]);
            if (hash_equals($data[0]['token'], hash('sha256', $authenticator))) {
                //Rehash password
                $hashedpassword = $this->encrypt_password($this->getPassword1());
                //Update password
                $this->db->update('users', ['password' => $hashedpassword], ['id' => $this->getUser()]);
                if (!$this->db->error()[2]) {
                    $this->setError('Wachtwoord succesvol aangepast!');

                    //Remove key
                    $this->db->delete('password_forgot', ['selector' => $selector]);

                    return true;
                }
                $this->setError('Niet gelukt om het wachtwoord te veranderen');
                return false;
            }
            $this->setError('Geen geldige code');
            return false;
        }
        $this->setError('Geen geldige code');
        return false;
    }

    public function encrypt_password($password)
    {
        $options = [
            'cost' => 12,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
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


    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getPassword1()
    {
        return $this->password_1;
    }

    /**
     * @param mixed $password_1
     */
    public function setPassword1($password_1)
    {
        $this->password_1 = $password_1;
    }

    /**
     * @return mixed
     */
    public function getPassword2()
    {
        return $this->password_2;
    }

    /**
     * @param mixed $password_2
     */
    public function setPassword2($password_2)
    {
        $this->password_2 = $password_2;
    }


}
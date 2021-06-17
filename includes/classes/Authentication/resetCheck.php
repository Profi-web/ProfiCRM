<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class resetCheck
{
    public $db;
    public $key;

    public function __construct($key = null)
    {
        $this->db = new Medoo(DB_INIT);

        if ($key) {
            $this->setKey($key);
        } else {
            header('Location: /wachtwoord-vergeten');
        }
    }

    public function validate(){
        list($selector, $authenticator) = explode(':', $this->getKey());
        $selector = rawurldecode($selector);
        $authenticator = rawurldecode(base64_decode($authenticator));
        $count = $this->db->count('password_forgot',  ['selector' => $selector]);
        if($count > 0) {
            $data = $this->db->select('password_forgot', '*', ['selector' => $selector]);
            if (hash_equals($data[0]['token'], hash('sha256', $authenticator))) {
                return true;
            }
            return false;
        }
        return false;
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
}

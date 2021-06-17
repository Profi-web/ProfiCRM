<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions/Mailer.php';

use Medoo\Medoo;

class Forgot
{
    public $db;
    public $user;
    public $email;
    public $error;
    public $mailer;

    public function __construct()
    {
        $this->db = new Medoo(DB_INIT);

    }

    public function validateInput($email = null)
    {
        if (!$email) {

            $this->setError('Vul een email in');
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $this->setError('Vul een geldig email adres in');
            return false;
        }

        $this->setEmail($email);
        $count = $this->db->count('users', ['email' => $this->getEmail()]);
        if ($count > 0) {
            $data = $this->db->select('users', '*', ['email' => $this->getEmail()]);
            if (!$this->db->error()[2]) {
                $this->setUser($data[0]['id']);
                return true;
            }
            $this->setError('Geen gebruiker gevonden');
            return false;
        }
        $this->setError('Geen gebruiker gevonden');
        return false;
    }

    public function setForgot()
    {
        //remove old keys
        $this->db->delete('password_forgot',['userid' => $this->getUser()]);

        $selector = base64_encode(random_bytes(9));
        $authenticator = random_bytes(33);

        $this->db->insert('password_forgot', [
            "selector" => $selector,
            "token" => hash('sha256', $authenticator),
            "userid" => $this->getUser(),
            "expires" => date('Y-m-d\TH:i:s', time() + 86400000)
        ]);
        $error = $this->db->error();
        if (!$error[2]) {
            $return_selector =  rawurlencode($selector);
            $return_authenticator = rawurlencode(base64_encode($authenticator));
//            urlencode($selector) . ':' . urlencode(base64_encode($authenticator))
            $this->mailer = new Mailer($this->getEmail(),'Wachtwoord vergeten','Klik op de volgende link om uw wachtwoord te veranderen: https://profi-crm.nl/wachtwoord-herstellen?key='.$return_selector . ':' . $return_authenticator);
            if($this->mailer->send()){
                $this->setError('Uw aanvraag is verwerkt, er is een email naar het emailadres gestuurd');
                return true;
            }

            $this->setError($this->mailer->getError());
            return false;


        }
        $this->setError('Oeps er ging iets mis met het onthouden van je gegevens!');
        return false;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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


}
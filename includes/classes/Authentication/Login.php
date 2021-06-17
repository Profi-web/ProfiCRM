<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Login
{
    public $db;
    public $error;
    public $email;
    public $password;
    public $user;

    public function __construct()
    {
        $this->db = new Medoo(DB_INIT);
    }

    public function checkFields($email = null, $password = null)
    {
        $status = true;

        if (!$email) {
            $status = false;
            $this->setError('Vul een email in');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $status = false;
            $this->setError('Vul een geldig email adres in');
        } else {
            $this->setEmail($email);
        }

        if (!$password) {
            $status = false;
            $this->setError('Vul een wachtwoord in');
        } else {
            $this->setPassword($password);
        }


        return $status;
    }

    public function validatePassword()
    {
        if ($this->getEmail() && $this->getPassword()) {
            $data = $this->db->select('users',
                ['id','email', 'password'],
                ["email" => $this->getEmail(),]
            );
            $error = $this->db->error();
            if(!$error[2]){
                if(count($data) > 0 ){
                    if(password_verify($this->getPassword(),$data[0]['password'])){
                        $this->setUser($data[0]['id']);
                        return true;
                    }

                    $this->setError('Ongeldig wachtwoord!');
                    return false;
                } else {
                    $this->setError('Geen gebruiker gevonden');
                    return false;
                }
            } else {
                $this->setError('Oeps er ging iets mis!');
                return false;
            }
        } else {
            $this->setError('Geen geldige email & wachtwoord');
            return false;
        }
    }

    public function setLoginCookie(){
        $selector = base64_encode(random_bytes(9));
        $authenticator = random_bytes(33);

        $setCookie = setcookie(
            'remember',
            $selector.':'.base64_encode($authenticator),
            time() + 86400000,
            '/'
        );

        if($setCookie){
            $this->db->insert('auth_tokens',[
                "selector" => $selector,
                "token" => hash('sha256',$authenticator),
                "userid" => $this->getUser(),
                "expires" =>date('Y-m-d\TH:i:s',time()+86400000)
            ]);
            $error = $this->db->error();
            if(!$error[2]){
                return true;
            }
            $this->setError('Oeps er ging iets mis met het onthouden van je gegevens!');
            return false;
        }
        $this->setError('Mij onthouden is mislukt!');
        return false;


    }

    public function saveLogin(){
        $_SESSION['userid'] = $this->getUser();
        $_SESSION['inlogtime'] = time();
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
use Medoo\Medoo;

class validateLogin
{
    public $db;
    public $user;
    public $notifcation = false;
    public $rolecheck = false;
    public $deniedRoles = [7,8];

    public function __construct($role = null)
    {
        $this->user = new User();
        $this->db = new Medoo(DB_INIT);
        if ($role) {
          foreach($role as $rol){
              $index = array_search($rol,$this->deniedRoles);
              $deniedRolesLocal = $this->deniedRoles;
              if($index !== FALSE){
                  unset($deniedRolesLocal[$index]);
              }
              $this->deniedRoles = $deniedRolesLocal;
          }
        }
    }

    public function validate()
    {
        if (isset($_SESSION['userid'])) {
            if ($_SESSION['userid']) {
                if (!$this->checkCookie()) {
                    if (!$this->loginTime()) {
                        return false;
                    }
                }
                $count = $this->db->count('users', ['id' => $_SESSION['userid']]);
                if ($count < 1) {
                    header('Location: /');
                    return false;
                }
                return true;
            }
            if ($this->checkCookie()) {
                return true;
            }
            return false;
        }
        if ($this->checkCookie()) {
            return true;
        }
        return false;
    }

    public function checkCookie()
    {
        if (isset($_COOKIE['remember']) && !empty($_COOKIE['remember'])) {
            list($selector, $authenticator) = explode(':', $_COOKIE['remember']);

            $data = $this->db->select('auth_tokens', '*', ['selector' => $selector]);

            if (hash_equals($data[0]['token'], hash('sha256', base64_decode($authenticator)))) {
                $_SESSION['userid'] = $data[0]['userid'];
                // Then regenerate login token as above
                return true;
            }
            return false;
        }

        return false;
    }

    public function loginTime()
    {
        if (isset($_SESSION['inlogtime'])) {
            if (time() - $_SESSION['inlogtime'] > 30 * 60) {
                $_SESSION['notification'] = json_encode(array(
                    'message' => 'Je sessie is verlopen, log aub opnieuw in',
                    'type' => 'login'
                ));
                return false;
            }
            return true;
        }
        return true;
    }

    public function securityCheck()
    {
        if (!isset($_SESSION['userid']) || !$_SESSION['userid']) {
            echo $_SESSION['userid'];
            require_once $_SERVER['DOCUMENT_ROOT'] . '/views/error/404page.php';
            exit();
        }
        if (!$this->checkCookie()) {
            if (!$this->loginTime()) {
                require_once $_SERVER['DOCUMENT_ROOT'] . '/views/error/404page.php';
                exit();
            }
        }
        if (!$this->rolecheck) {
            foreach($this->deniedRoles as $role){
                if ($this->user->data['role'] == $role) {
                    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/error/404page.php';
                    exit();
                }
            }

        }

    }
}

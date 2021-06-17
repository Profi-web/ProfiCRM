<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/phpmailer/src/Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/phpmailer/src/PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/libraries/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Mailer
{
    public $db;
    public $to;
    public $subject;
    public $body;
    public $error;
    public $setfrom;

    public function __construct($to,$subject,$body,$sendfrom = null)
    {
        $this->db = new Medoo(DB_INIT);
        $this->setTo($to);
        $this->setSubject($subject);
        $this->setBody($body);
        $this->setSetfrom($sendfrom);

    }

    public function send(){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail.profi-crm.nl';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->getSetfrom();                 // SMTP username
            $mail->Password = 'P0nyp@rk2005';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Recipients
            $mail->setFrom($this->getSetfrom(), 'Profi-crm');
            $mail->addAddress($this->getTo());     // Add a recipient
            $mail->addReplyTo($this->getSetfrom(), 'Profi-crm');
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->getSubject();
            $mail->Body    = $this->getBody();

            $mail->send();
            return true;
        } catch (Exception $e) {
            $this->setError('Message could not be sent. Mailer Error: '. $mail->ErrorInfo);
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
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
        $this->error .= $error.'<br>';
    }

    /**
     * @return mixed
     */
    public function getSetfrom()
    {
        return $this->setfrom;
    }

    /**
     * @param mixed $setfrom
     */
    public function setSetfrom($setfrom = null)
    {
        if($setfrom) {
            $this->setfrom = $setfrom;
        } else {
            $this->setfrom = 'reset@profi-crm.nl';
        }
    }
}
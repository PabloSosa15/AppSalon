<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;


class Email
{
    public $email;
    public $name;
    public $token;

    public function __construct($email, $name, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation() {

        //Create the email object
        $email = new PHPMailer();
        $email->isSMTP();
        $email->Host = $_ENV['EMAIL_HOST'];
        $email->SMTPAuth = true;
        $email->Port = $_ENV['EMAIL_PORT'];
        $email->Username = $_ENV['EMAIL_USER'];
        $email->Password = $_ENV['EMAIL_PASS'];

        $email->setFrom('accounts@appsalon.com');
        $email->addAddress('accounts@appsalon.com', 'AppSalon.com');
        $email->Subject = 'Confirm your account';

        //Set HTML
        $email->isHTML(TRUE);
        $email->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p><strong>Hola " . $this->email . "</strong> You have created your account on AppSalon, just have to confirm by clicking on the following link</p>";
        $content .= "<p>Press Here: <a href= '" .    $_ENV['APP_URL']    . "/confirm-account?token=" . $this->token . "'>Confirm account</a> </p> ";
        $content .= "<p>If you did not request this account, you can ignore the message</p>";
        $content .= "</html>";

        $email->Body = $content;
        $email->send();
    }

    public function sendInstruction() {
               //Create the email object
               $email = new PHPMailer();
               $email->isSMTP();
               $email->Host = $_ENV['EMAIL_HOST'];
               $email->SMTPAuth = true;
               $email->Port = $_ENV['EMAIL_PORT'];
               $email->Username = $_ENV['EMAIL_USER'];
               $email->Password = $_ENV['EMAIL_PASS'];
       
               $email->setFrom('accounts@appsalon.com');
               $email->addAddress('accounts@appsalon.com', 'AppSalon.com');
               $email->Subject = 'Reset your password';
       
               //Set HTML
               $email->isHTML(TRUE);
               $email->CharSet = 'UTF-8';
       
               $content = '<html>';
               $content .= "<p><strong>Hi " . $this->name . "</strong> You have requested to reset your password, follow the instructions in the following link</p>";
               $content .= "<p>Press Here: <a href= '" .    $_ENV['APP_URL']    . "/recover?token=" . $this->token . "'>Reset Password</a> </p> ";
               $content .= "<p>If you did not request this account, you can ignore the message</p>";
               $content .= "</html>";
       
               $email->Body = $content;
               $email->send();
    }
}


?>

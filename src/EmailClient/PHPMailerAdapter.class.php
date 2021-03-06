<?php
namespace EmailClient;

use PHPMailer;
use phpmailerException;
require_once '../lib/PHPMailer/PHPMailerAutoload.php';

class PHPMailerAdapter implements Mailer
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer();
    }

    /**
     * @inheritDoc
     */
    public function config() : void
    {
        //$this ->mail ->Hostname = 'localhost.localdomain';
        $this->mail ->IsSmtp(true);
        $this->mail->SMTPDebug = 0;
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = 587;
        $this->mail ->IsHTML(true);
        $this->mail->Username = "oopassign1@gmail.com"; //set email address
        $this->mail->Password = "pleasedontremovenetwork"; //set password
        $this->mail->SetFrom("noreply@quatrex.lk");
    }

    /**
     * @inheritDoc
     */
    public function send(Email $email) : void
    {
        $recipients = $email->getField('recipients');
        foreach ($recipients as $recipient)
            $this->mail->addAddress($recipient);
        $this->mail->Subject = $email->getField('subject');
        $this->mail->Body = $email->getField('message');

        try {
            $this->mail->Send();
        } catch (phpmailerException $e) {
            $e -> errorMessage();
        }

        $this->clearMail();
    }

    /**
     * Clear the details in the PHPMailer
     */
    private function clearMail() : void
    {
        $this->mail->clearAddresses();
        $this->mail->Body = "";
        $this->mail->Subject = "";
    }
}
<?php

//IMPORT PHP MAILER LIBRARIES

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'libraries/PHPMailer/src/Exception.php';
require 'libraries/PHPMailer/src/PHPMailer.php';
require 'libraries/PHPMailer/src/SMTP.php';


class SendMail {

    private $mailer;
    private $mail_details = [
        "Host" => "smtp.mailtrap.io",
        "STMPAuth" => true,
        "Username" => "261b36826d95cd",
        "Password" => "556f11818b6c82",
        "SMTPSecure" => "tls",
        "Port" => 2525
    ];
    private $sender_mail = "sirelite11@gmail.com";
    private $sender_name = "CEO HORTECH HOSPITALS";

    function __construct() {
        $this->mailer = new PHPMailer(true);
         //Server settings
        //$this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mailer->isSMTP();                                            //Send using SMTP
        $this->mailer->Host       = $this->mail_details['Host'];                     //Set the SMTP server to send through
        $this->mailer->SMTPAuth   = $this->mail_details['STMPAuth'];                                   //Enable SMTP authentication
        $this->mailer->Username   = $this->mail_details['Username'];              //SMTP username
        $this->mailer->Password   = $this->mail_details['Password'];                                 //SMTP password// h+w0o?yR.Lj2
        $this->mailer->SMTPSecure = $this->mail_details['SMTPSecure'];           //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->mailer->Port       = $this->mail_details['Port'];      
    }

    public function send_mail($email, $firstname, $lastname, $subject, $message){
        try {

            //Recipients
            $this->mailer->setFrom($this->sender_mail, $this->sender_name);
            $this->mailer->addAddress($email);     //Add a recipient
            //$this->mailer->addAddress('ehiosun.bishop@fybomidetravel.com');
            //$this->mailer->addReplyTo('info@example.com', 'Information');
            //$this->mailer->addCC('');
            //$this->mailer->addBCC('bcc@example.com');
            
            //Attachments
            //$this->mailer->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$this->mailer->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            $html = $message;
        
            //Content
            $this->mailer->isHTML(true);//Set email format to HTML
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $html;
            $this->mailer->AltBody = nl2br(strip_tags($html));
            
            $mail = $this->mailer->send();
            return 1;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {".$this->mailer->ErrorInfo."}";
        }
    }
}


?>
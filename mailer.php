<?php

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{

    public function validateRequest()
    {
        if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->ignoreRequest();
        }
    }

    public function validateCaptcha()
    {
        if (rpHash($_POST['areYouHuman']) != $_POST['areYouHuman'])  {
            $this->ignoreRequest();
        }

    }


    public function sendMail()
    {



        require 'mailer/PHPMailer.php';
        require 'mailer/SMTP.php';

        $mail = new PHPMailer;
        $mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 2;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "marcov4lente@gmail.com";
        $mail->Password = "hjcwbwnkbquyptvb";
        $mail->setFrom('marcov4lente@gmail.com', 'MarcoV4lente.com');
        $mail->addReplyTo($_POST['email'], $_POST['name']);
        $mail->addAddress('marcov4lente@gmail.com', 'Marco Valente');
        $mail->Subject = 'MarcoV4lente.com contact form submission';

        $message = '
        <strong>Name:</strong> '.$_POST['name'].'<br>
        <strong>Email:</strong> '.$_POST['email'].'<br>
        <strong>Message:</strong> '.$_POST['message'].'<br>';

        $mail->msgHTML($message);
        $mail->AltBody = strip_tags(str_replace('<br>', "\n", $message));

        if (!$mail->send()) {
            $this->processError();
        }

        $this->processSuccess();
    }


    private function processSuccess()
    {
        header('Location: contact-thank-you.html');
            exit;

    }


    private function processError()
    {
        header('Location: error.html');
            exit;

    }


    private function ignoreRequest()
    {
        header('Location: index.html');
            exit;

    }


    private function rpHash($value)
    {
        $hash = 5381;
        $value = strtoupper($value);

        for($i = 0; $i < strlen($value); $i++) {
            $hash = (($hash << 5) + $hash) + ord(substr($value, $i));
        }

        return $hash;
    }
}

$m = New Mailer;
$m->validateRequest();
$m->validateCaptcha();
$m->sendMail();





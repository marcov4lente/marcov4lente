<?php

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{


    /**
     * @param null
     * @return void
     **/
    public function validateRequest()
    {
        if(!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->ignoreRequest();
        }
    }


    /**
     * @param null
     * @return void
     **/
    public function validateCaptcha()
    {

        if ($this->rpHash($_POST['areYouHuman']) != $_POST['areYouHumanHash'])  {
            $this->incorrectCaptcha();
        }

    }


    /**
     * @param null
     * @return void
     **/
    public function sendMail()
    {

        require 'mailer/PHPMailer.php';
        require 'mailer/Exception.php';
        require 'mailer/SMTP.php';
        $mailerConfig = include('mailer.config.php');

        $mail = new PHPMailer;
        $mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = $mailerConfig['smtpUsername'];
        $mail->Password = $mailerConfig['smtpPassword'];
        $mail->setFrom($mailerConfig['senderEmail'], $mailerConfig['senderName']);
        $mail->addReplyTo($_POST['email'], $_POST['name']);
        $mail->addAddress($mailerConfig['recipientEmail'], $mailerConfig['recipientName']);
        $mail->Subject = 'marcovalente.io contact form submission';

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


    /**
     * @param null
     * @return void
     **/
    private function processSuccess()
    {

        print '<script>
                alert("Thank you for your form submission! I\'ll be in contact soon!");
                window.location.href = window.history.back(1);
            </script>';
        exit;

    }


    /**
     * @param null
     * @return void
     **/
    private function processError()
    {

        print '<script>
                alert("Oh no!, something went wrong with your form submission. Please try again later.");
                window.location.href = window.history.back(1);
            </script>';
        exit;

    }


    /**
     * @param null
     * @return void
     **/
    private function ignoreRequest()
    {

        header('Location: index.html');
        exit;

    }


    /**
     * @param null
     * @return void
     **/
    private function incorrectCaptcha()
    {

        print '<script>
                alert("Oh no!, the validation code you entered in is incorrect. Please try again.");
                window.location.href = window.history.back(1);
            </script>';
        exit;
    }


    /**
     * @param string $valua
     * @return void
     **/
    private function rpHash($value)
    {
        $hash = 5381;
        $value = strtoupper($value);

        for($i = 0; $i < strlen($value); $i++) {
            // 32 bit OS
            // $hash = (($hash << 5) + $hash) + ord(substr($value, $i));
            // 64 bit OS
            $hash = ($this->leftShift32($hash, 5) + $hash) + ord(substr($value, $i));
        }

        return $hash;
    }


    /**
     * @param string $number
     * @param integer $steps
     * @return void
     **/
    function leftShift32($number, $steps)
    {
        // convert to binary (string)
        $binary = decbin($number);
        // left-pad with 0's if necessary
        $binary = str_pad($binary, 32, "0", STR_PAD_LEFT);
        // left shift manually
        $binary = $binary.str_repeat("0", $steps);
        // get the last 32 bits
        $binary = substr($binary, strlen($binary) - 32);
        // if it's a positive number return it
        // otherwise return the 2's complement
        return ($binary{0} == "0" ? bindec($binary) :
        -(pow(2, 31) - bindec(substr($binary, 1))));
    }
}

$m = New Mailer;
$m->validateRequest();
$m->validateCaptcha();
$m->sendMail();

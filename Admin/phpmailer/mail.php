<?php 

    function sendmail($recipent, $subject, $body, $altbody=""){
        $mail = new PHPMailer;
        //$mail->SMTPDebug = 4;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = Config::SMTP_HOST;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = Config::SMTP_EMAIL;                 // SMTP username
        $mail->Password = Config::SMTP_PASS;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom(Config::SMTP_EMAIL, 'eShopper');
        $mail->addAddress($recipent);     // Add a recipient
    
        $mail->addReplyTo(Config::SMTP_EMAIL);

        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altbody;

        $res = ['isError'=>true, 'message'=>'somthing went wrong!!'];
        if(!$mail->send()) {
            $res['isError'] = true;
            $res['message'] = 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            $res['isError'] = false;
            $res['message'] = 'Message has been sent';
        }

        return $res;
    }

?>
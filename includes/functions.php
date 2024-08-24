<?php
if (defined("_INCODE") != 1) die("Access denail");
function layout($layoutName = 'header', $data = [])
{

    if (file_exists(_WEB_PATH_TEMPLATE . '/layouts/' . $layoutName . '.php')) {
        require_once _WEB_PATH_TEMPLATE . '/layouts/' . $layoutName . '.php';
    }
}

// function insert($email='',$fullname='',$createAt=''){
//     $sql="INSERT INTO users(email,fullname,createAt) VALUE (
//     try{
//     $statement=$conn->prepara($sql);
//     $data=[
//          $email,
//          $fullname,
//          $createAt
//         ];
//         $insertState=$statement->excute($data);

//     }catch()
// }catch (Exception $exception) {
//     echo $exception->getMessage() . '<br/>';
//     echo 'File: ' . $exception->getFile() . ' - Line: ' . $exception->getLine() . '<br/>';
// }

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function sendMail($to,$subject)
{

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'trinhtrangat18actvn@gmail.com';                     //SMTP username
        $mail->Password   = 'ppyfznkjyjrobvbo';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('trinhtrangat18actvn@gmail.com', 'Mailer');
        $mail->addAddress($to);     //Add a recipient
      //  $mail->addReplyTo();
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
       // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

       return $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

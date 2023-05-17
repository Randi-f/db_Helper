<?php
/*
 * @Description: tools to send email
 * @Version: 1.0
 * @Author: fsh
 * @Date: 2023-04-09 18:12:59
 * @LastEditTime: 2023-04-26 20:33:58
 */

namespace app\service;

use PHPMailer\PHPMailer\PHPMailer;
 
class SendMail
{
    /**
     * @description: send email
     * @param {*} $email
     * @param {*} $userId
     * @return {*}
     */    
    public static function sendMail($email, $userId)
    {
 
        $mail = new PHPMailer(true);
 
        $mail->isSMTP(); // use the service of SMTP (required)
        $mail->CharSet = "utf8"; // set the coding format to avoid collisions
        $mail->Host = "smtp.exmail.qq.com"; // the SMTP server address of the sender (exmail or"smtp.qq.com")
        $mail->SMTPAuth = true; // whether use identity authentication 
        $mail->Username = "lucifer_1412@bupt.edu.cn"; // sender's email address
        $mail->Password = "6t5v1ygyjylgvb\$n"; // sender's server's password
        $mail->SMTPSecure = "ssl"; // use ssl protocol
        $mail->Port = 465; // port (normally 465 or 994)
 
        $mail->setFrom("lucifer_1412@bupt.edu.cn","dnHelper"); // sender's address and name
        $mail->addAddress($email,'deHelper User'); // receiver's address and name
        $mail->addReplyTo("lucifer_1412@bupt.edu.cn","Reply"); // respondent's address and name
        //$mail->addCC("xxx@163.com");// Set the email cc recipient to only write the address, and the above settings can also only write the address (this person can also receive emails)
        //$mail->addBCC("xxx@163.com");// Set up a secret cc person (this person can also receive emails)
        //$mail->addAttachment("bug0.jpg");// Add attachments
 
 
        $mail->Subject = "dbHelper Register"; // title
        $mail->Body = "Your registration has been successful! Your user Id is: ".$userId.". You can use it to login."; // content
 
        if(!$mail->send()){// send email
            // echo "Message could not be sent.";
            return "Mailer Error: ".$mail->ErrorInfo;// print error message
        }else{
            return 'send success';
        }
    }
}
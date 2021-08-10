<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
    public function sendMail(Request $request) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $body = '<b>Họ và tên: </b>'.$request->data['name'].'<br/>'.
                '<b>Địa chỉ: </b>'.$request->data['address'].'<br/>'.
                '<b>Số điện thoại: </b>'.$request->data['phone'].'<br/>'.
                '<b>Email: </b>'.$request->data['email'].'<br/>'.
                '<b>Nội dung: </b>'.$request->data['content'];

            // Read this link to setup mail: https://stackoverflow.com/questions/37524275/smtp-error-could-not-authenticate-message-could-not-be-sent-mailer-error-smt
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = env('MAIL_HOST');                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = env('MAIL_USERNAME');                   //SMTP username
            $mail->Password   = env('MAIL_PASSWORD');                   //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = env('MAIL_PORT');                       //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(env('MAIL_USERNAME'), 'Hitech Lab Website');
            $mail->addAddress(env('MAIL_TO'));     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Yeu cau lien he tu Hitech Lab Website';
            $mail->Body    = $body;
            $mail->AltBody = str_replace(["<b>", "</b>"], "", $body);

            //Send mail
            $mail->send();

            return response()->json("Sent mail success", 202);
        } catch (Exception $e) {
            return response()->json("Sent mail error", 404);
        }
    }
}
<?php

namespace App;

use Pelago\Emogrifier\CssInliner;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public static function sendEmail($to, $title, $html) {
        try {
            $mail = new PHPMailer();

            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';

            $mail->Host = env('MAIL_HOST');
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port = env('MAIL_PORT');
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');

            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body = CssInliner::fromHtml($html)->inlineCss()->render();

            $mail->setFrom(env('MAIL_FROM_EMAIL'), env('MAIL_FROM_NAME'));
            $mail->addReplyTo(env('MAIL_FROM_EMAIL'), env('MAIL_FROM_NAME'));

            $mail->addAddress($to);

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }

}

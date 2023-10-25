<?php

namespace Yosimar\Corona\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class MailService
{
    public static function sendMail(int $idReview): bool
    {
        $mail = new PHPMailer(true);
        try {
            $dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/corona');
            $dotenv->load();
            //Server settings
            $mail->isSMTP();
            $mail->Host = $_SERVER['SMTPHOST'];
            $mail->Port = $_SERVER['SMTPPORT'];
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = $_SERVER['AUTHUSER'];
            $mail->Password = $_SERVER['AUTHPASSWORD'];
<<<<<<< HEAD
            $mail->smtpConnect([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]);

            //Recipients
            $mail->setFrom($_SERVER['MAILFROM'], 'Soporte Ti Corona Los Tuxtlas');
            //$mail->addAddress($_SERVER['MAILADDRESSVENTAS'], 'Ventas Corona Los Tuxtlas');
            $mail->addAddress($_SERVER['MAILFROM'], 'Soporte Ti Corona Los Tuxtlas');
            $mail->addCC($_SERVER['MAILCC'], 'Soporte Sistemas Corona Los Tuxtlas');
=======
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Recipients
            $mail->setFrom($_SERVER['MAILFROM'], 'Soporte Ti Corona Los Tuxtlas');
            $mail->addAddress($_SERVER['MAILADDRESS'], 'Area de Ventas');
            $mail->addCC($_SERVER['MAILCC'], 'Alberto Vargas Quino');
            $mail->addCC($_SERVER['MAILFROM'], 'Area de Sistemas');
>>>>>>> 6625145e0d6c2ef775b1c58baa6cf7da67d4d8ef

            $stringReviewPDF = PdfService::generatePdfReviewForMail($idReview);

            if ($stringReviewPDF == '') {
                return FALSE;
            }

            file_put_contents('review.pdf', $stringReviewPDF);

            //Attachments
            $mail->addAttachment('review.pdf', 'review.pdf');

            //Content
            $mail->isHTML();
            $mail->Subject = 'Revision de envases';
            $mail->Body = '<h1>Reporte de envases</h1>';
            $mail->AltBody = 'Se adjunta archivo PDF con el reporte completo de los envases presentes en la revision';

            $mail->send();
            return TRUE;
        } catch (Exception $e) {
            error_log("MAILSERVICE::sendMail -> No se ha podido enviar la revision por correo. Mailer Error: {$mail->ErrorInfo}");
            error_log("Error: " . $e);
            return FALSE;
        }
    }


    public static function sendMailCash(int $idReview): bool
    {
        $mail = new PHPMailer(true);
        try {
            $dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/corona');
            $dotenv->load();
            //Server settings
            $mail->isSMTP();
            $mail->Host = $_SERVER['SMTPHOST'];
            $mail->Port = $_SERVER['SMTPPORT'];
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = $_SERVER['AUTHUSER'];
            $mail->Password = $_SERVER['AUTHPASSWORD'];
            $mail->smtpConnect([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]);
            //Recipients
            $mail->setFrom($_SERVER['MAILFROM'], 'Soporte Ti Corona Los Tuxtlas');
            $mail->addAddress($_SERVER['MAILADDRESSRECEPCION'], 'Recepcion Corona Los Tuxtlas');
            $mail->addCC($_SERVER['MAILCC'], 'Soporte Sistemas Corona Los Tuxtlas');
            $stringInvoicePDF = PdfService::generatePdfInvoiceForMail($idReview);
            if ($stringInvoicePDF == '') {
                return FALSE;
            }
            file_put_contents('invoice.pdf', $stringInvoicePDF);

            //Attachments
            $mail->addAttachment('invoice.pdf', 'invoice.pdf');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Cargo de envases';
            $mail->Body = '<h1>Ticket de cobro</h1>';
            $mail->AltBody = 'Se adjunta el ticket de cobro correspondiente';

            $mail->send();
            return TRUE;
        } catch (Exception $e) {
            error_log("MAILSERVICE::sendMailCash -> No se ha podido enviar el cobro por correo. Mailer Error: {$mail->ErrorInfo}");
            return FALSE;
        }
    }
}

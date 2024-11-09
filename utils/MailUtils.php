<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../');
$dotenv->load();

class MailUtils {
  private static function preparaCorreu($correuDesti): ?PHPMailer {
    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';
      $mail->Host = 'mailsrv2.dondominio.com.';
      $mail->Port = 587;
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Username = $_ENV['MAIL_USER'];
      $mail->Password = $_ENV['MAIL_PASSWORD'];
      $mail->setFrom($_ENV['MAIL_USER'], 'Admin');
      $mail->addAddress($correuDesti);
      
      return $mail;

    } catch (Exception $e) {
      setMessage('errorCorreu', "Error al configurar el correu: {$e->getMessage()}");
      return null;
    }
  }

  public static function enviarCorreuRecuperacio($correuDesti, $resetLink): void {
    $mail = self::preparaCorreu($correuDesti);

    if (!$mail) {
      return;
    }

    try {
      $template = file_get_contents('../templates/reset-password.html');
      $htmlBody = str_replace('{{reset_link}}', $resetLink, $template);

      $mail->Subject = 'Recuperació de contrasenya';
      $mail->Body = $htmlBody;

      $mail->send();
    } catch (Exception $e) {
      setMessage('errorCorreu', "Error al enviar el correu: {$e->getMessage()}");
    }
}
}
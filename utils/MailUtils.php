<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'Logger.php';

use PHPMailer\PHPMailer\PHPMailer;
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
      $mail->Host = 'mailsrv2.dondominio.com';
      $mail->Port = 587;
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Username = $_ENV['MAIL_USER'];
      $mail->Password = $_ENV['MAIL_PASSWORD'];
      $mail->setFrom($_ENV['MAIL_USER'], 'Oni\'s Blog');
      $mail->addAddress($correuDesti);
      
      return $mail;

    } catch (Exception $e) {
      Logger::log("Error al preparar el correu: " . $e->getMessage(), TipusLog::ERROR_LOG, LogLevel::ERROR);
      return null;
    }
  }

  public static function enviarCorreuRecuperacio($correuDesti, $token): void {
    $mail = self::preparaCorreu($correuDesti);

    if (!$mail) {
      return;
    }

    try {
      $template = file_get_contents('../templates/reset-password.html');

      $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? "https" : "http";
      $host = $_SERVER['HTTP_HOST'];
      $resetLink = "$protocol://$host" . BASE_PATH . "/reset-password?token=$token";

      $htmlBody = str_replace('{{reset_link}}', $resetLink, $template);

      $mail->Subject = 'Recuperació de contrasenya';
      $mail->Body = $htmlBody;

      $mail->send();
    } catch (Exception $e) {
      Logger::log("Error al enviar el correu de recuperacio de contrasenya: " . $e->getMessage(), TipusLog::ERROR_LOG, LogLevel::ERROR);
    }
  }

  public static function enviarCorreuVerificacio($correuDesti, $codi): void {
    $mail = self::preparaCorreu($correuDesti);

    if (!$mail) {
      return;
    }

    try {
      $template = file_get_contents('../templates/verify-email.html');

      $htmlBody = str_replace('{{codi_verificacio}}', $codi, $template);

      $mail->Subject = 'Verificació de correu electrònic';
      $mail->Body = $htmlBody;

      $mail->send();
    } catch (Exception $e) {
      Logger::log("Error al enviar el correu de verificacio del compte: " . $e->getMessage(), TipusLog::ERROR_LOG, LogLevel::ERROR);
    }
  }
}
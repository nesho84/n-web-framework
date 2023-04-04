<?php

/**
 * EmailService class - used for sending emails using PHPMailer.
 *
 * @param array $options An array of options for configuring the email settings. The following keys are supported:
 *      - host: SMTP host name
 *      - port: SMTP port number
 *      - username: SMTP username
 *      - password: SMTP password
 *      - from: Email address of the sender
 *      - fromName: Name of the sender
 *      - to: Email address of the recipient
 *      - cc: Email address(es) of the CC recipient(s), separated by commas
 *      - bcc: Email address(es) of the BCC recipient(s), separated by commas
 *      - subject: Email subject
 *      - body: Email body
 *      - isHtml: Whether the email body is HTML or plain text. Defaults to true.
 *      - attachments: Array of file paths to be attached to the email.
 *
 * Example usage:
 *   try {
 *       EmailService::send([
 *           'host' => 'smtp.gmail.com',
 *           'port' => 587,
 *           'username' => 'example@gmail.com',
 *           'password' => 'password',
 *           'from' => 'from@example.com',
 *           'fromName' => 'John Doe',
 *           'to' => 'to@example.com',
 *           'cc' => 'cc@example.com,cc2@example.com',
 *           'bcc' => 'bcc@example.com',
 *           'subject' => 'Test email',
 *           'body' => 'This is a test email',
 *           'isHtml' => true,
 *           'attachments' => [
 *               [
 *                   'path' => '/path/to/attachment1.pdf',
 *                   'name' => 'attachment1.pdf',
 *                   'encoding' => 'base64',
 *                   'type' => 'application/pdf'
 *               ],
 *               [
 *                   'path' => '/path/to/attachment2.txt',
 *                   'name' => 'attachment2.txt',
 *                   'encoding' => 'base64',
 *                   'type' => 'text/plain'
 *               ]
 *           ],
 *       ]);
 *       echo 'Email sent successfully.';
 *   } catch (Exception $e) {
 *       echo 'Email could not be sent. Error: ' . $e->getMessage();
 *   }
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    public static function send(array $options): void
    {
        require LIBRARY_PATH . '/PHPMailer/src/PHPMailer.php';
        require LIBRARY_PATH . '/PHPMailer/src/SMTP.php';
        require LIBRARY_PATH . '/PHPMailer/src/Exception.php';

        $default_options = [
            'from' => '',
            'from_name' => '',
            'to' => '',
            'cc' => '',
            'bcc' => '',
            'subject' => '',
            'body' => '',
            'attachments' => [],
            'smtp_host' => 'localhost',
            'smtp_port' => 25,
            'smtp_username' => '',
            'smtp_password' => '',
            'smtp_security' => '',
            'debug' => false,
        ];

        $options = array_merge($default_options, $options);

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = $options['debug'] ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = $options['smtp_host'];
            $mail->Port = $options['smtp_port'];
            $mail->SMTPAuth = true;
            $mail->Username = $options['smtp_username'];
            $mail->Password = $options['smtp_password'];
            $mail->SMTPSecure = $options['smtp_security'];

            // Recipients
            $mail->setFrom($options['from'], $options['from_name']);
            $mail->addAddress($options['to']);

            if (!empty($options['cc'])) {
                $mail->addCC($options['cc']);
            }
            if (!empty($options['bcc'])) {
                $mail->addBCC($options['bcc']);
            }

            /** @var array $options Attachments */
            foreach ($options['attachments'] as $attachment) {
                $mail->addAttachment(
                    $attachment['path'],
                    $attachment['name'],
                    $attachment['encoding'],
                    $attachment['type']
                );
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $options['subject'];
            $mail->Body = $options['body'];
            $mail->AltBody = strip_tags($options['body']);

            $mail->send();
        } catch (Exception $e) {
            throw new Exception("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}

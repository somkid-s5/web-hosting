<?php
session_start();
require_once 'connectdb.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail()
{
    require_once "PHPMailer.php";
    require_once "SMTP.php";
    require_once "Exception.php";

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'somkid.ubuhosting@gmail.com';
        $mail->Password   = 'cdvdedipbphqzhtf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('somkid.ubuhosting@gmail.com', 'jeedhosting');
        $mail->addAddress("somkid.ubuhosting@gmail.com");
        $mail->Subject = 'Reuse Host';
        $mail->Body = "User Request Reuse Host";
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['reuse'])) {
    $domain = $_POST['domain'];
    $status = 'Reuse';
    try {
         // อัปเดตสถานะในฐานข้อมูลเป็น 'Reuse'
        $stmt = $conn->prepare("UPDATE service_request SET status = :status WHERE domain = :domain");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':domain', $domain);
        $stmt->execute();
        sendMail();
        $_SESSION['success'] = 'ส่งคำขอเปิดใช้งานhostอีกครั้งเรียบร้อยแล้วรอการตรวจสอบ';
        header('location: ../page/user_page.php');
       
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

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
        $mail->Subject = 'Renewal';
        $mail->Body = "User Request Renewal";
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['renewal'])) {
    $service_id = $_POST['service_id'];
    $number = $_POST['number'];
    $status = 'Pending';

    try {
        $renewer_stmt = $conn->prepare("INSERT INTO renewal_request(service_id, num_months, status) 
            VALUES(:service_id, :number, :status)");
        $renewer_stmt->bindParam(":service_id", $service_id);
        $renewer_stmt->bindParam(":number", $number);
        $renewer_stmt->bindParam(":status", $status);
        $renewer_stmt->execute();
        sendMail();
        $_SESSION['success'] = 'ส่งคำขอต่อบริการเรียบร้อยแล้วรอการตรวจสอบ';
        header('location: ../page/user_page.php');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

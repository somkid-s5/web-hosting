<?php
// เชื่อมต่อฐานข้อมูล
require_once 'connectdb.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['domain'])) {
    $domain = $_POST['domain'];
    $sql = $conn->prepare("SELECT email,domain,due_date  FROM users LEFT JOIN service_request ON service_request.user_id = users.user_id WHERE service_request.domain = :domain;");
    $sql->bindParam(':domain', $domain);
    $sql->execute();

    $result = $sql->fetch(PDO::FETCH_ASSOC);
    $email = $result['email'];

    $url = "http://localhost:444/virtual-server/remote.cgi";
    $data = array(
        'program' => 'enable-domain',
        'domain' => $domain,
    );
    $curl = curl_init();
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => false,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => 'admin123:admin123',
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
    );
    curl_setopt_array($curl, $options);
    curl_exec($curl);
    curl_close($curl);

    // ส่งอีเมลแจ้งเตือน
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
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your host has been enabled';
        $mail->Body = "โฮสของคุณได้รับการเปิดใช้งานแล้ว <br> Domain: $domain";

        $mail->send();
        // เพิ่มการบันทึกหรือแจ้งเตือนเมื่อส่งอีเมลสำเร็จ
    } catch (Exception $e) {
        // แสดงข้อความผิดพลาดหรือเพิ่มการบันทึกหรือแจ้งเตือนข้อผิดพลาด
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }

    //update status and due_date 
    $status = 'Approved';
    // due_date + 1 year
    $due_date = date('Y-m-d', strtotime('+1 year', strtotime($result['due_date'])));
    $sql = $conn->prepare("UPDATE service_request SET status = :status, due_date = :due_date WHERE domain = :domain");
    $sql->bindParam(":status", $status);
    $sql->bindParam(":due_date", $due_date);
    $sql->bindParam(":domain", $domain);
    $sql->execute();
    header("location: ../page/admin_page/manage_vs.php");

}

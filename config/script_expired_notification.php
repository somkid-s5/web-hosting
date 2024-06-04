<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once "connectdb.php";
require_once "PHPMailer.php";
require_once "Exception.php";
require_once "SMTP.php";

$sql = "SELECT users.email, service_request.domain, service_request.due_date FROM service_request INNER JOIN users ON service_request.user_id = users.user_id WHERE status = 'Approved'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ส่ง email เงื่อนไข คือ ถ้ามีข้อมูลโดเมนที่ใกล้หมดอายุ ก่อน 10 นาที ให้ส่ง email ไปยังผู้ใช้งาน 
if ($result) {
    foreach ($result as $row) {
        $email = $row['email'];
        $domain = $row['domain'];
        $due_date = $row['due_date'];
        $date = date('Y-m-d', strtotime('-10 day', strtotime($due_date)));
        
        date_default_timezone_set('Asia/Bangkok');
        $currentDateTime = date('Y-m-d');
        echo $currentDateTime;

        if ($date == $currentDateTime) {
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
                $mail->Subject = 'Your domain is about to expire';
                $mail->Body = "โดเมนของคุณกำลังจะหมดอายุในเร็วนี้ๆ . <br> Domain: $domain <br> วันหมดอายุ: $due_date" ;

                $mail->send();
                echo 'Message has been sent';
                // เพิ่มการบันทึกหรือแจ้งเตือนเมื่อส่งอีเมลสำเร็จ
            } catch (Exception $e) {
                // แสดงข้อความผิดพลาดหรือเพิ่มการบันทึกหรือแจ้งเตือนข้อผิดพลาด
                error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
        }
    }
}
?>

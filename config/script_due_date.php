<?php
// เชื่อมต่อฐานข้อมูล
require_once 'connectdb.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// คำสั่ง SQL PDO สำหรับดึงข้อมูลที่ครบกำหนด
$sql = "SELECT users.email, service_request.domain FROM service_request LEFT JOIN users ON service_request.user_id = users.user_id WHERE status = 'Approved' AND DATE(due_date) = CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ถ้ามีข้อมูล ใส่โค้ดที่ใช้ Virtualmin API เพื่อปิด Virtual Server
if ($result) {
    foreach ($result as $row) {
        $domain = $row['domain'];
        $email = $row['email'];
        $url = "http://localhost:444/virtual-server/remote.cgi";
        $data = array(
            'program' => 'disable-domain',
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

        // อัปเดตสถานะในฐานข้อมูลเป็น 'Pending'
        $sql = "UPDATE service_request SET status = 'Disable' WHERE domain = :domain";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':domain', $domain);
        $stmt->execute();

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
            $mail->Subject = 'Your host has been disabled';
            $mail->Body = "Your host has been disabled. <br> Domain: $domain";

            $mail->send();
            // เพิ่มการบันทึกหรือแจ้งเตือนเมื่อส่งอีเมลสำเร็จ
        } catch (Exception $e) {
            // แสดงข้อความผิดพลาดหรือเพิ่มการบันทึกหรือแจ้งเตือนข้อผิดพลาด
            error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}

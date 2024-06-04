<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($domain,$username,$password,$plan,$due_date,$email)
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
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'success';
        $mail->Body = "<h1>ยินดีต้อนรับสู่บริการ Web Hosting ของเรา!</h1>
            <p>เราได้สร้างพื้นที่เว็บไซต์และฐานข้อมูลสำหรับคุณแล้ว</p>
            <p>โดเมน: $domain</p>
            <p>ชื่อผู้ใช้: $username</p>
            <p>รหัสผ่าน: $password</p>
            <p>แพลน: $plan</p>
            <p>วันหมดอายุ: $due_date</p>
            <p>คุณสามารถเข้าถึงบริการของคุณผ่านแผงควบคุมของเราที่ <a href='http://$domain:444'>http://$domain:444</a></p>
            <p>ขอขอบคุณอีกครั้งที่เลือกใช้บริการ Web hosting กับเรา และเราหวังว่าคุณจะมีประสบการณ์ที่ยอดเยี่ยมในการใช้บริการของเรา!</p>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['crateVS'])) {
    $user_id = $_POST['user_id'];
    $domain = $_POST['domain'];
    $uname = $_POST['user'];
    $pword = $_POST['password'];
    $plan = $_POST['plan'];
    $set_status = 'Approved';
    $option_domain = $_POST['option_domain'];
    $date = date('Y-m-d H:i:s');
    $due_date = date('Y-m-d H:i:s', strtotime('+1 month'));


    // Set API URL
    $url = "http://localhost:444/virtual-server/remote.cgi";

    if ($option_domain == '1'){
        $data = array(
            'program' => 'create-domain',
            'domain' => $domain,
            'pass' => $pword,
            'user' => $uname,
            'plan' => $plan,
            'template' => 'TP1',
            'unix' => '',
            'dir' => '',
            'web' => '',
            'mysql' => '',
            'webmin' => '',
            'dns' => '',
            'content' => '/var/www/default/index.html'
        );
    }
    elseif ($option_domain == '2'){
        $data = array(
            'program' => 'create-domain',
            'domain' => $domain,
            'pass' => $pword,
            'user' => $uname,
            'plan' => $plan,
            'template' => 'TP1',
            'unix' => '',
            'dir' => '',
            'web' => '',
            'mysql' => '',
            'webmin' => '',
            'features-from-plan' => '',
            'content' => '/var/www/default/index.html'
        );
    }

    // Create cURL resource
    $curl = curl_init();

    // Set cURL options
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => false,
        CURLOPT_CONNECTTIMEOUT => 5, 
        CURLOPT_TIMEOUT => 5, 
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => 'admin123:admin123', 
        CURLOPT_SSL_VERIFYHOST => false, // Set to true if you want to verify SSL host
        CURLOPT_SSL_VERIFYPEER => false, // Set to true if you want to verify the peer's SSL certificate
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
    );

    curl_setopt_array($curl, $options);

    // Execute the cURL session and get the response
    curl_exec($curl);
    curl_close($curl);
   
    require_once 'connectdb.php';
    $select = $conn->prepare("SELECT email FROM users WHERE user_id = :user_id");
    $select->bindParam(":user_id", $user_id);
    $select->execute(); 
    $dataselect = $select->fetchAll(PDO::FETCH_ASSOC);
    $email = $dataselect[0]['email'];
 
    $sql = $conn->prepare("UPDATE service_request SET status = :status ,approve_date = :approve_date ,due_date = :due_date WHERE domain = :domain");
    $sql->bindParam(":status", $set_status);
    $sql->bindParam(":domain", $domain);
    $sql->bindParam(":approve_date", $date);
    $sql->bindParam(":due_date", $due_date);
    try {
        $sql->execute();
        $_SESSION['success'] = "สร้างโดเมนเรียบร้อยแล้ว!";
        sendMail($domain,$uname,$pword,$plan,$due_date, $email);
        header("location: ../page/admin_page/manage_vs.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
}
?>
    

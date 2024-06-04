<?php

session_start();
require_once "connectdb.php";
if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail()
{
    require_once "../PHPMailer/PHPMailer.php";
    require_once "../PHPMailer/SMTP.php";
    require_once "../PHPMailer/Exception.php";

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
        $mail->addAddress('somkid.ubuhosting@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'User Request';
        $mail->Body = "have a request";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


if (isset($_POST['submitaddserver'])) {
    // ตรวจสอบ Option ที่ผู้ใช้เลือก
    $option = $_POST['inlineRadioOptions'];

    $username = $_POST['username'];
    $password = $_POST['password'];
    $plans = $_POST['plans'];
    $objectives = $_POST['objectives'];
    $about = $_POST['about'];

    if ($option === '1') {
        // ผู้ใช้เลือกใช้ Domain ของเรา
        $domain = $_POST['subdomain'] . ".jeedhost.com";
    } elseif ($option === '2') {
        // ผู้ใช้เลือกมี Domain อยู่แล้ว
        $domain = $_POST['domain_name']; // ใช้ Domain ที่ผู้ใช้กรอก
    }
    try {
        $check_domain = $conn->prepare("SELECT domain,username FROM service_request  WHERE domain = :domain or username = :username");
        $check_domain->bindParam(":domain", $domain);
        $check_domain->bindParam(":username", $username);
        $check_domain->execute();
        $row_request = $check_domain->fetch(PDO::FETCH_ASSOC);

        if ($row_request && $row_request['domain'] == $domain) {
            $_SESSION['warning'] = "มีdomainนี้อยู่ในระบบแล้ว";
            header("location: ../page/user_page.php");
        } else if ($row_request && $row_request['username'] == $username) {
            $_SESSION['warning'] = "มีusernameนี้อยู่ในระบบแล้ว";
            header("location: ../page/user_page.php");
        } else if (!isset($_SESSION['error'])) {
            $date = date("Y-m-d H:i:s");
            $sql = $conn->prepare("INSERT INTO service_request(user_id, domain, username, password, plan, option_domain, objective, about, request_date) 
                                            VALUES(:user_id, :domain, :username, :password, :plan, :option_domain, :objective, :about, :request_date)");

            $sql->bindParam(":user_id", $user_id);
            $sql->bindParam(":domain", $domain);
            $sql->bindParam(":username", $username);
            $sql->bindParam(":password", $password);
            $sql->bindParam(":plan", $plans);
            $sql->bindParam(":option_domain",$option);
            $sql->bindParam(":objective", $objectives);
            $sql->bindParam(":about", $about);
            $sql->bindParam(":request_date", $date);
            $sql->execute();
            sendMail();
            $_SESSION['success'] = "ร้องขอเรียบร้อยแล้ว! รอดำเนินการ";
            header("location: ../page/user_page.php");
        } else {
            $_SESSION['error'] = "มีบางอย่างผิดพลาด";
            header("location: ../page/user_page.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

<?php

session_start();
require_once "connectdb.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($name,$email, $activation_code)
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
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification from jeedhosting';

        $verificationLink = "http://jeedhost.com/config/emailverify.php";

            $mail->Body = "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Your Beautiful Email</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
            
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #ffffff;
                        border-radius: 5px;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }
            
                    h1 {
                        color: #333333;
                        text-align: center;
                    }
            
                    p {
                        color: #555555;
                        text-align: center;
                    }
            
                    .button-container {
                        text-align: center;
                        margin-top: 20px;
                    }
            
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 3px;
                    }
            
                    .footer {
                        text-align: center;
                        margin-top: 20px;
                        color: #777777;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Hello $name</h1>
                    <h1>Welcome to JEEDHOST.COM</h1>
                    <p>Thank you for subscribing to our newsletter. Stay tuned for exciting updates and offers!</p>
                    <div class='button-container'>
                        <form method='POST' action='$verificationLink'>
                            <input type='hidden' name='email' value='$email'>
                            <input type='hidden' name='activation_code' value='$activation_code'>
                            <button type='submit' class='button'>Verify Email</button>
                        </form>
                    </div>
                </div>
                <div class='footer'>
                    <p>&copy; 2023 JEEDHOST.COM. All rights reserved.</p>
                </div>
            </body>
            </html>
            ";
            
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
 
if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $activation_code = bin2hex(random_bytes(16)); // Use random_bytes for secure activation code

    if ($password != $c_password) {
        $_SESSION['warning'] = 'รหัสผ่านไม่ตรงกัน';
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        header("location: ../page/register_page.php");
    } else {
        try {
            $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
            $check_email->bindParam(":email", $email);
            $check_email->execute();
            $row = $check_email->fetch(PDO::FETCH_ASSOC);
    
            if ($row['email'] == $email) {
                $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว";
                header("location: ../page/register_page.php");
            } else if (!isset($_SESSION['error'])) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users(name, email, password, activation_code) 
                                                VALUES(:name, :email, :password, :activation_code)");
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":password", $passwordHash);
                $stmt->bindParam(":activation_code", $activation_code);
                $stmt->execute();
                sendMail($name,$email, $activation_code);
                $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว!";
                header("location: ../page/register_page.php");
            } else {
                $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                header("location: ../page/register_page.php");
                echo 'ไม่รู้จัก';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

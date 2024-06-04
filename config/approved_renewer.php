<?php
session_start();
require_once 'connectdb.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email)
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
        $mail->Subject = 'Approved Renewal successfully';
        $mail->Body = "Your renewal has been approved.";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


if (isset($_POST['renewal'])) {
            $user_id = $_POST['user_id'];
            $renewal_id = $_POST['renewal_id'];
            $service_id = $_POST['service_id'];
            $num_months = intval($_POST['num_months']);
            $due_date = $_POST['due_date'];
            $status = 'Approved';
            $today = date('Y-m-d');

            $renewal_timestamp = strtotime('+' . $num_months . ' months', strtotime($due_date));
            $renewal = date('Y-m-d', $renewal_timestamp);
        
            try{

                $sql3 = $conn->prepare("SELECT email FROM users WHERE user_id = :user_id");
                $sql3->bindParam(":user_id", $user_id);
                $sql3->execute();
                $email = $sql3->fetch(PDO::FETCH_ASSOC);
        

                $sql = $conn->prepare("UPDATE renewal_request SET approve_date = :approve_date, status = :status WHERE renewal_id = :renewal_id");
                $sql->bindParam(":approve_date", $today);
                $sql->bindParam(":status", $status);
                $sql->bindParam(":renewal_id", $renewal_id);
                $sql->execute();

                $sql2 = $conn->prepare("UPDATE service_request SET due_date = :due_date WHERE service_id = :service_id");
                $sql2->bindParam(":due_date", $renewal);
                $sql2->bindParam(":service_id", $service_id);
                $sql2->execute();

                if ($sql->rowCount() > 0 && $sql2->rowCount() > 0) {
                    $_SESSION['success'] = "Data has been updated successfully";
                    sendMail($email['email']);
                    header("location: ../page/admin_page/manage_renewal.php");
                } else {
                    $_SESSION['error'] = "Data has not been updated successfully";
                    header("location: ../page/admin_page/manage_renewal.php");
                }
            }catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }      
}

?>        
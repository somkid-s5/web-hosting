<?php

session_start();
require_once "connectdb.php";

if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $check_data = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $check_data->bindParam(":email", $email);
        $check_data->execute();
        $row = $check_data->fetch(PDO::FETCH_ASSOC);

        if ($check_data->rowCount() > 0) {
            $is_verified = $row['active'];
            if ($is_verified == 1) { // ผู้ใช้ยืนยันอีเมลแล้ว
                if ($email === $row['email'] && password_verify($password, $row['password'])) {
                    if ($row['role'] === 'admin') {
                        $_SESSION['admin_login'] = $row['user_id'];
                        header("location: ../page/admin_page.php");
                    } else {
                        $_SESSION['user_login'] = $row['user_id'];
                        header("location: ../page/user_page.php");
                    }
                } else {
                    $_SESSION['error'] = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
                    $_SESSION['email'] = $email;
                    header("location: ../page/login_page.php");
                }
            } else {
                $_SESSION['error'] = "กรุณายืนยันอีเมลก่อนเข้าสู่ระบบ";
                $_SESSION['email'] = $email;
                header("location: ../page/login_page.php");
            }
        } else {
            $_SESSION['error'] = "ไม่พบข้อมูลผู้ใช้ในระบบ";
            $_SESSION['email'] = $email;
            header("location: ../page/login_page.php");
        }
    } catch (PDOException $e) {
        echo "เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล: " . $e->getMessage();
    }
}

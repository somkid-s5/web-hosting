<?php 

session_start();
require_once '../../config/connectdb.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: ../login_page.php');
}

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        $sql = $conn->prepare("UPDATE users SET name = :name WHERE user_id = :user_id");
        $sql->bindParam(":name", $name);
        $sql->bindParam(":user_id", $id);
        $sql->execute();

        if ($sql) {
            $_SESSION['success-edit'] = "Data has been updated successfully";
            header("location: manage_user.php");
        } else {
            $_SESSION['edit-error'] = "Data has not been updated successfully";
            header("location: manage_user.php");
        }
    }

?>

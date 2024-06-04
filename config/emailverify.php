<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify</title>
    <link href="../css/sweetalert2.min.css" rel="stylesheet">
    <script src="../js/sweetalert2.all.min.js"></script>
</head>

<body>
    <?php

    if (isset($_POST['email'], $_POST['activation_code'])) {
        $email = $_POST['email'];
        $activation_code = $_POST['activation_code'];

        require_once "connectdb.php";

        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND activation_code = :activation_code");
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":activation_code", $activation_code);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user['active'] == 1) {
                    echo '<script>
                                Swal.fire({
                                    icon: "warning",
                                    title: "email นี้ได้ทำการยืนยันตัวตนไปแล้ว!",
                                    text: "คลิกปุ่มเพื่อเข้าสู่ระบบ!",
                                    showCancelButton: false,
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "ตกลง"
                                }).then((result) => {
                                        if (result.isConfirmed) {
                                             window.location.href = "../page/login_page.php";
                                        }
                                });
                            </script>';
                } else {
                    $updateStmt = $conn->prepare("UPDATE users SET active = 1 WHERE email = :email");
                    $updateStmt->bindParam(":email", $email);
                    $updateStmt->execute();
                    echo '<script>
                            Swal.fire({
                                    icon: "success",
                                    title: "ยืนยันตัวตนสำเร็จแล้ว!",
                                    text: "คลิกปุ่มเพื่อเข้าสู่ระบบ!",
                                    showCancelButton: false,
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "ตกลง"
                            }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "../page/login_page.php";
                                    }
                                });
                        </script>';
                }
            } else {
                // ไม่พบอีเมลหรือรหัสการเปิดใช้งานที่ตรงกัน
                echo    '<script>
                            Swal.fire({
                                icon: "error",
                                title: "ไม่สำเร็จ!",
                                text: "ไม่พบอีเมลหรือรหัสการเปิดใช้งาน!",
                            })
                     </script>';
            }
        } catch (PDOException $e) {
            echo "เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล: " . $e->getMessage();
        }
    } else {
        echo "ไม่พบอีเมลหรือรหัสการเปิดใช้งาน";
    }
    ?>

</body>

</html>
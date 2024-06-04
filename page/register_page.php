<?php

session_start();
require_once '../config/connectdb.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">

    <link href="../css/sweetalert2.min.css" rel="stylesheet">
    <script src="../js/sweetalert2.all.min.js"></script>

</head>

<body class="bg-gradient-primary">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block register-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                    </div>
                                    <form class="user" action="../config/signup_db.php" method="post" id="registerfrom">

                                        <?php if (isset($_SESSION['error'])) { ?>
                                            <div>
                                                <script>
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'ไม่สำเร็จ!',
                                                        text: '<?php echo $_SESSION['error'] ?>',
                                                        confirmButtonText: "ลองอีกครั้ง",
                                                    })
                                                </script>
                                                <?php
                                                unset($_SESSION['error']);
                                                ?>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($_SESSION['success'])) { ?>
                                            <div>
                                                <script>
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'สำเร็จ!',
                                                        text: '<?php echo $_SESSION['success'] ?>',
                                                        confirmButtonText: "<a href='login_page.php' class='text-white'>คลิ๊กที่นี่เพื่อเข้าสู่ระบบ</a>",
                                                    })
                                                </script>
                                                <?php
                                                unset($_SESSION['success']);
                                                ?>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($_SESSION['warning'])) { ?>
                                            <div>
                                                <script>
                                                    Swal.fire({
                                                        icon: 'warning',
                                                        title: 'คำเตือน!',
                                                        text: '<?php echo $_SESSION['warning'] ?>',
                                                        confirmButtonText: "<a href='login_page.php' class='text-white'>คลิ๊กที่นี่เพื่อเข้าสู่ระบบ</a>",
                                                    })
                                                </script>
                                                <?php
                                                unset($_SESSION['warning']);
                                                ?>
                                            </div>
                                        <?php } ?>





                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control form-control-user" placeholder="Name" required value="<?php echo $_SESSION['name'];unset($_SESSION['name']);?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user" " placeholder=" Email Address" required value="<?php echo $_SESSION['email'];unset($_SESSION['email']);?>">
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required  pattern=".{5,20}" title="8 to 20 characters">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" name="c_password" class="form-control form-control-user" placeholder="Repeat Password" required pattern=".{5,20}" title="8 to 20 characters">
                                            </div>
                                        </div>
                                        <button type="submit" name="signup" class="btn btn-primary btn-user btn-block"> Register Account</button>
                                        <br>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login_page.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../js/scripts.js"></script>



</body>

</html>
<?php

session_start();
require_once '../config/connectdb.php';
if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login_page.php');
} else {
    $user_id = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User-Manage</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
    <link href="../css/sweetalert2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon ">
                    <i class="fas fa-cat"></i>
                </div>
                <div class="sidebar-brand-text mx-3">User </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->

        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $row['name'] ?></span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    บัญชีผู้ใช้
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    ออกจากระบบ
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">




                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Welcome <?php echo $row['name']; ?></h1>
                    <p class="mb-4">ยินดีต้อนรับเข้าสู่บริการ Web Hosting ของเรา!
                        เราพร้อมที่จะสนับสนุนคุณในการสร้างและบริหารจัดการเว็บไซต์ของคุณ สามารถเข้าถึง <a target="_blank" href="docs_page.html"> คู่มือ</a> การใช้งานเพื่อเรียนรู้การใช้งาน
                        ขอให้คุณมีประสบการณ์ที่ดีที่สุดกับเรา!</p>


                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">My Domain</h6>
                            <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addserverModal'>Add Host</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Domain</th>
                                            <th scope="col">Due Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $stmp2 = $conn->query("SELECT * FROM service_request  WHERE user_id = $user_id");
                                        $stmp2->execute();
                                        $users = $stmp2->fetchAll(PDO::FETCH_ASSOC);



                                        if (!$users) {
                                            echo "<p><td colspan='5' class='text-center'>คุณยังไม่มี Host ของคุณใช่ไหมกดที่ Add Host ได้เลย</td></p>";
                                        } else {
                                            foreach ($users as $user) {
                                                if (empty($user['due_date'])) {
                                                    $formattedDate = 'null';
                                                } else {
                                                    $timestamp = strtotime($user['due_date']);
                                                    $formattedDate = date('d/m/Y', $timestamp);
                                                }
                                        ?>
                                                <tr>
                                                    <td><?php echo $user['domain']; ?></td>
                                                    <td><?php echo $formattedDate;  ?></td>
                                                    <?php
                                                    if ($user['status'] == 'Pending') {
                                                        echo "<td><span class='badge badge-warning'>{$user['status']}</span></td>";
                                                        echo "<td><span>---</span></td>";
                                                    } elseif ($user['status'] == 'Approved') {
                                                        echo "<td><span class='badge badge-success'>{$user['status']}</span></td>";
                                                        echo "<td><button class=\"btn btn-info\" onclick=\"openRenewalModal('{$user['service_id']}', '{$user['domain']}', '{$formattedDate}')\">Renewal</button></td>";
                                                    } else {
                                                        echo "<td><span class='badge badge-secondary'>{$user['status']}</span></td>";
                                                        echo "<td><form method='post' action='../config/script_reuse_host.php'>
                                                                <input type='hidden' name='domain' value='{$user['domain']}'>
                                                                <button type='submit' name='reuse' class='btn btn-success'>Reuse</button>
                                                            </form>
                                                            </td>";
                                                    }
                                                    ?>
                                                </tr>

                                        <?php }
                                        } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- addserver Modal  -->
    <div class="modal fade" id="addserverModal" tabindex="-1" aria-labelledby="addserverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addserverModalLabel">ร้องขอสิทธิ์</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../config/insert-addserver_db.php" method="post" enctype="multipart/form-data">
                        <!-- username -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="username" class="col-form-label">Username:</label>
                                <p class="explain mb-0 ml-2">*สำหรับ Login เข้าใช้งาน Host</p>
                            </div>
                            <input type="text" required class="form-control" name="username" placeholder="Username">
                        </div>
                        <!-- password -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="password" class="col-form-label">Password:</label>
                                <p class="explain mb-0 ml-2">*สำหรับ Login เข้าใช้งาน Host</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <input type="password" name="password" required class="form-control mr-2" placeholder="Password" pattern=".{5,20}" title="5 to 20 characters">
                                <input type="password" name="c_password" required class="form-control ml-2" placeholder="Repeat Password" pattern=".{5,20}" title="5 to 20 characters">
                            </div>
                        </div>
                        <!-- domain -->
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="Radio1" value="1" checked>
                                <label class="form-check-label" for="Radio1">:ใช้ Domain ของเรา สิ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="Radio2" value="2">
                                <label class="form-check-label" for="Radio2">:ฉันมี Domain อยู่แล้ว</label>
                            </div>

                            <div id="subdomainSection">
                                <div class="d-flex align-items-center">
                                    <label for="subdomain" class="col-form-label">SubDomain:</label>
                                    <p class="explain mb-0 ml-2">*สำหรับ Host ของคุณ</p>
                                </div>
                                <div class="input-group">
                                    <input type="text" required title="Please enter your subdomain" class="form-control" name="subdomain" id="subdomain" placeholder="Subdomain">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">.jeedhost.com</div>
                                    </div>
                                </div>
                            </div>

                            <div id="domainNameSection">
                                <div class="d-flex align-items-center">
                                    <label for="domain_name" class="col-form-label">Domain Name:</label>
                                    <p class="explain mb-0 ml-2">*สำหรับ Host ของคุณ</p>
                                </div>
                                <div class="input-group">
                                    <input type="text" required title="Please enter your domain name" class="form-control" name="domain_name" placeholder="Your Domain">
                                </div>
                            </div>

                        </div>
                        <!-- plan and objectives -->
                        <div class="mb-3 d-flex align-items-center row mr-0 ml-0">
                            <div class="col pl-0">
                                <div class="d-flex align-items-center">
                                    <label for="plans" class="col-form-label">Plans:</label>
                                    <p class="explain mb-0 ml-2">*แผนสำหรับโครงงานของคุณ</p>
                                </div>
                                <select class="custom-select" required name="plans">
                                    <option value="">select Plans</option>
                                    <option value="Basic">Basic Plan</option>
                                    <option value="Upgrade">Upgrade Plan</option>
                                    <option value="Advanced">Advanced Plan</option>
                                </select>
                            </div>
                            <div class="col pr-0">
                                <div class="d-flex align-items-center">
                                    <label for="objectives" class="col-form-label">objectives:</label>
                                    <p class="explain mb-0 ml-2">*วัตถุประสงค์ของคุณ</p>
                                </div>
                                <select class="custom-select" required name="objectives">
                                    <option value="">select goal</option>
                                    <option value="การพัฒนาและทดสอบ">การพัฒนาและทดสอบ</option>
                                    <option value="การศึกษาและการเรียนรู้">การศึกษาและการเรียนรู้</option>
                                    <option value="โครงการส่วนตัว">โครงการส่วนตัว</option>
                                </select>
                            </div>
                        </div>
                        <!-- about -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="about" class="col-form-label">about:</label>
                                <p class="explain mb-0 ml-2">*อธิบายโครงงานของคุณ</p>
                            </div>
                            <textarea class="form-control" id="about" required name="about" rows="4" maxlength="100" placeholder="กรอกคำอธิบายที่ไม่เกิน 100 ตัวอักษร"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="submitaddserver" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">คุณ พร้อมที่จะออก?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">เลือก "ออกจากระบบ" ด้านล่างหากคุณพร้อมที่จะออกจากระบบของคุณ</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    <a class="btn btn-primary" href="../config/logout.php">ออกจากระบบ</a>
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
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script src="../js/demo/datatables-demo.js"> </script>



    <!-- renewer Modal  -->
    <div class="modal fade" id="renewalModal" tabindex="-1" aria-labelledby="renewalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renewalModalLabel">ต่ออายุบริการ</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../config/renewal.php" method="post" enctype="multipart/form-data">

                        <div class="mb-3 no-display">
                            <input type="hidden" id="service_id" name="service_id" value="">
                        </div>
                        <div class="mb-3">
                            <label for="domain" class="col-form-label">Domain:</label>
                            <label id="domain" class="col-form-label">วันหมดอายุ:</label>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="col-form-label">Number of months</label>
                            <input type="number" value="" required class="form-control" name="number" min='1'>
                        </div>
                        <hr>
                        <button type="submit" name="renewal" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_SESSION['success'])) {
    ?>
        <script>
            showSuccessAlert("<?php echo $_SESSION['success']; ?>");
        </script>
    <?php
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['warning'])) {
    ?>
        <script>
            showWarningAlert("<?php echo $_SESSION['warning']; ?>");
        </script>
    <?php
        unset($_SESSION['warning']);
    }
    ?>

    <script>
        document.getElementById("subdomain").addEventListener("input", function() {
            var input = this.value;
            var regex = /^[a-zA-Z0-9]*$/; // ตรวจสอบเฉพาะตัวอักษรและตัวเลข
            if (!regex.test(input)) {
                alert("กรุณากรอกเฉพาะตัวอักษรและตัวเลขเท่านั้น");
                this.value = input.replace(/[^a-zA-Z0-9]/g, ''); // ลบอักขระที่ไม่ใช่ตัวอักษรและตัวเลข
            }
        });
    </script>


</body>

</html>
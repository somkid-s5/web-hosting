<?php

session_start();
require_once '../../config/connectdb.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: ../login_page.php');
}

?>
<?php
if (isset($_SESSION['admin_login'])) {
    $user_id = $_SESSION['admin_login'];
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

    <title>Admin-Manage-VS</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../css/sweetalert2.min.css" rel="stylesheet">
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="manage_vs.php">
                <div class="sidebar-brand-icon ">
                    <i class="fas fa-cat"></i>
                </div>
                <div class="sidebar-brand-text mx-3">JH Admin </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item ">
                <a class="nav-link" href="../admin_page.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Configs
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="manage_user.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manage Use Users</span>
                </a>
            </li>

            <!-- Nav Item - Manage Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manage request</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage:</h6>
                        <a class="collapse-item" href="manage_vs.php"">Service</a>
                        <a class=" collapse-item" href="manage_renewal.php"">renewal</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class=" sidebar-divider d-none d-md-block">

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
                                <img class="img-profile rounded-circle" src="../../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manage Request </h1>
                    </div>

                    <!-- Content Row -->

                    <!-- list of service -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary" id="dynamic-heading">List of Service Pending</h6>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#showtable1" onclick="changeHeading('Pending')">Pending</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#showtable2" onclick="changeHeading('Approved')">Approved</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#showtable3" onclick="changeHeading('Disable')">Disable</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body tab-content ">
                            <div class="table-responsive tab-pane fade show active" id="showtable1">
                                <table class="table table-bordered " width="100%" cellspacing="0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>name</th>
                                            <th>Domain</th>
                                            <th>Plan</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $stmt_s_of = $conn->query("SELECT service_request.*, users.name FROM service_request INNER JOIN users ON service_request.user_id = users.user_id WHERE service_request.status = 'Pending' or service_request.status = 'Reuse'");
                                        $stmt_s_of->execute();
                                        $row_VSof = $stmt_s_of->fetchAll(PDO::FETCH_ASSOC);
                                        if (!$row_VSof) {
                                            echo "<tr><td colspan='5' class='text-center'>No data available</td></tr>";
                                        } else {
                                            foreach ($row_VSof as $VSof) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $VSof['name']; ?></td>
                                                    <td><?php echo $VSof['domain']; ?></td>
                                                    <td><?php echo $VSof['plan']; ?></td>
                                                    <?php
                                                    if ($VSof['status'] == 'Pending') {
                                                        echo "<td><span class='badge badge-warning'>{$VSof['status']}</span></td>";
                                                        echo "<td><form method='post' action='../../config/create_vs.php'>
                                                                        <input type='hidden' name='user_id' value='{$VSof['user_id']}'>
                                                                        <input type='hidden' name='domain' value='{$VSof['domain']}'>
                                                                        <input type='hidden' name='password' value='{$VSof['password']}'>
                                                                        <input type='hidden' name='user' value='{$VSof['username']}'>
                                                                        <input type='hidden' name='plan' value='{$VSof['plan']}'>
                                                                        <input type='hidden' name='option_domain' value='{$VSof['option_domain']}'>
                                                                        <button type='submit' name='crateVS' class='btn btn-info'>Approved</button>
                                                                    </form>
                                                                </td>";
                                                    } else {
                                                        echo "<td><span class='badge badge-secondary'>{$VSof['status']}</span></td>";
                                                        echo "<td><form method='post' action='../../config/script_enable.php'>
                                                                    <input type='hidden' name='domain' value='{$VSof['domain']}'>
                                                                    <button type='submit' name='reuse' class='btn btn-info'>Reuse</button>
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
                            <div class="table-responsive tab-pane fade" id="showtable2">
                                <table class=" table table-bordered" width="100%" cellspacing="0" id="dataTable2">
                                    <thead>
                                        <tr>
                                            <th>name</th>
                                            <th>Domain</th>
                                            <th>Plan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $stmt_s_o = $conn->query("SELECT * FROM service_request INNER JOIN users ON service_request.user_id = users.user_id WHERE service_request.status = 'Approved'");
                                        $stmt_s_o->execute();
                                        $row_VSon = $stmt_s_o->fetchAll(PDO::FETCH_ASSOC);

                                        if (!$row_VSon) {
                                            echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                        } else {
                                            foreach ($row_VSon as $VSon) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $VSon['name']; ?></td>
                                                    <td><?php echo $VSon['domain']; ?></td>
                                                    <td><?php echo $VSon['plan']; ?></td>
                                                    <td><span class="badge badge-success"><?php echo $VSon['status']; ?></span></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive tab-pane fade" id="showtable3">
                                <table class="table table-bordered " width="100%" cellspacing="0" id="dataTable3">
                                    <thead>
                                        <tr>
                                            <th>name</th>
                                            <th>Domain</th>
                                            <th>Plan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt_disbale = $conn->query("SELECT service_request.*, users.name FROM service_request INNER JOIN users ON service_request.user_id = users.user_id WHERE service_request.status = 'Disable'");
                                        $stmt_disbale->execute();
                                        $row_VSdis = $stmt_disbale->fetchAll(PDO::FETCH_ASSOC);
                                        if (!$row_VSdis) {
                                            echo "<tr><td colspan='5' class='text-center'>No data available</td></tr>";
                                        } else {
                                            foreach ($row_VSdis as $dis) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $dis['name']; ?></td>
                                                    <td><?php echo $dis['domain']; ?></td>
                                                    <td><?php echo $dis['plan']; ?></td>
                                                    <td><span class="badge badge-secondary"><?php echo $dis['status']; ?></span></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- DataTales User
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary" id="dynamic-heading">List of Service Pending</h6>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#dataTable1" onclick="changeHeading('Pending')">Pending</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#dataTable2" onclick="changeHeading('Approved')">Approved</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body tab-content">
                            <div class="table-responsive tab-pane fade show active" id="dataTable1">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            <td>test</td>
                                            <td>test</td>
                                            <td>
                                                <button type="button" class="btn btn-warning">Approved</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive tab-pane fade" id="dataTable2">
                                <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                           
                                            <td>user</td>
                                            <td>user</td>
                                            <td>
                                                <button type="button" class="btn btn-warning">Approved</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
 -->



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../../config/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>




    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>
    <script src="../../js/sweetalert2.all.min.js"></script>
    <script src="../../js/scripts.js"></script>
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script src="../../js/demo/datatables-demo.js"></script>


    <?php if (isset($_SESSION['success'])) { ?>
        <script>
            autoclose();
        </script>
    <?php
        unset($_SESSION['success']);
    } ?>

</body>

</html>
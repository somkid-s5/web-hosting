<?php

session_start();
require_once '../config/connectdb.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login_page.php');
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

<!-- Count -->
<?php
// Count total number of users
$sql_count_users = "SELECT COUNT(*) as total_users FROM users WHERE role = 'user'";
$stmt_count_users = $conn->query($sql_count_users);
$result_users = $stmt_count_users->fetch(PDO::FETCH_ASSOC);
$totalUsers = $result_users['total_users'];

// Count number of request that are currently turned Approved 
$sql_count_Approved = "SELECT COUNT(*) as total_request_Approved FROM service_request  WHERE status = 'Approved'";
$stmt_count_Approved = $conn->query($sql_count_Approved);
$result_Approved = $stmt_count_Approved->fetch(PDO::FETCH_ASSOC);
$totalApproved = $result_Approved['total_request_Approved'];

// Count number of request that are currently turned Pending 
$sql_count_Pending = "SELECT COUNT(*) as total_request_Pending FROM service_request  WHERE status = 'Pending'";
$stmt_count_Pending = $conn->query($sql_count_Pending);
$result_Pending = $stmt_count_Pending->fetch(PDO::FETCH_ASSOC);
$totalPending = $result_Pending['total_request_Pending'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin-Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_page.php">
                <div class="sidebar-brand-icon ">
                    <i class="fas fa-cat"></i>
                </div>
                <div class="sidebar-brand-text mx-3">JH Admin </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="admin_page.php">
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
                <a class="nav-link" href="admin_page/manage_user.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manage Users</span>
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
                        <a class="collapse-item" href="admin_page/manage_vs.php"">Service</a>
                        <a class=" collapse-item" href="admin_page/manage_renewal.php"">renewal</a>
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
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- COUNT Total -->
                    <div class="row">
                        <!-- Total user -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total user</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "$totalUsers"; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas  fa-users fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Approved -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Approved</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalApproved; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-server fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pending -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalPending; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-server fa-2x text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTales Server Awaiting Host Approval -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <a href="admin_page/manage_vs.php">
                                <h6 class="m-0 font-weight-bold text-primary">Pending</h6>
                            </a>
                            <button type='button' class='btn btn-primary' onclick="document.location='admin_page/manage_vs.php'">manage</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-2">User</th>
                                            <th class="col-sm-2">DomainName</th>
                                            <th class="col-sm-1">Plan</th>
                                            <th class="col-sm-5">Detail</th>
                                            <th class="col-sm-1">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $stmt_Pending = $conn->query("SELECT * FROM service_request INNER JOIN users ON service_request.user_id = users.user_id WHERE service_request.status = 'Pending'");
                                        $stmt_Pending->execute();
                                        $row_Pending = $stmt_Pending->fetchAll(PDO::FETCH_ASSOC);

                                        if (!$row_Pending) {
                                            echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                        } else {
                                            foreach ($row_Pending as $Pending) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $Pending['name']; ?></td>
                                                    <td><?php echo $Pending['domain']; ?></td>
                                                    <td><?php echo $Pending['plan']; ?></td>
                                                    <td><?php
                                                        echo "Objective :" . $Pending['objective'];
                                                        echo "<br>";
                                                        echo "Expected Benefits :" . $Pending['about'];
                                                        echo "<br>";
                                                        ?></td>
                                                    <?php
                                                    if ($Pending['status'] == 'Pending') {
                                                        echo "<td><a href='admin_page/manage_vs.php' class='badge badge-warning'>{$Pending['status']}</a></td>";
                                                    } elseif ($Pending['status'] == 'Approved') {
                                                        echo "<td'><a class='badge badge-success'>{$Pending['status']}</a></td>";
                                                    } else {
                                                        echo "<td'><a class='badge badge-secondary'>{$Pending['status']}</a></td>";
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

                    <!-- DataTales Server is online
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Approved</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-2">User</th>
                                            <th class="col-sm-2">DomainName</th>
                                            <th class="col-sm-1">Plan</th>
                                            <th class="col-sm-5">Detail</th>
                                            <th class="col-sm-1">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $stmt_Pending = $conn->query("SELECT * FROM service_request INNER JOIN users ON service_request.user_id = users.user_id WHERE service_request.status = 'Approve'");
                                    $stmt_Pending->execute();
                                    $row_Pending = $stmt_Pending->fetchAll(PDO::FETCH_ASSOC);

                                    if (!$row_Pending) {
                                        echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                    } else {
                                        foreach ($row_Pending as $Pending) {
                                    ?>
                                                <tr>
                                                    <td><?php echo $Pending['name']; ?></td>
                                                    <td><?php echo $Pending['domain']; ?></td>
                                                    <td><?php echo $Pending['plan']; ?></td>
                                                    <td><?php
                                                        echo "Objective :" . $Pending['objective'];
                                                        echo "<br>";
                                                        echo "Expected Benefits :" . $Pending['about'];
                                                        echo "<br>";
                                                        ?></td>
                                                    <td><?php echo $Pending['status']; ?></td>
                                                </tr>
                                        <?php }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->

                    <!-- DataTales User
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Total User</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $stmtall = $conn->query("SELECT * FROM users WHERE role = 'user'");
                                        $stmtall->execute();
                                        $usersall = $stmtall->fetchAll();

                                        if (!$usersall) {
                                            echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                                        } else {
                                            foreach ($usersall as $user) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $user['name']; ?></td>
                                                    <td><?php echo $user['email']; ?></td>
                                                    <td><?php if ($user['active'] == 1) {
                                                            echo "activated";
                                                        } else {
                                                            echo "pending activate";
                                                        } ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->

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
                    <a class="btn btn-primary" href="../config/logout.php">Logout</a>
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

    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script src="../js/demo/datatables-demo.js"> </script>


</body>

</html>
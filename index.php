<?php
session_start();
error_reporting(1);
include('../connect.php');
if(empty($_SESSION['admin-username'])) {   
    header("Location: login.php"); 
} else {
}

$username = $_SESSION["admin-username"];
date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d');

$sql = "select * from admin where username ='$username'"; 
$result = $conn->query($sql);
$row2 = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Admin Dashboard</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <style>
        /* Custom green button */
        .custom-green-btn {
            background-color: #187C4E !important;
            border-color: #187C4E !important;
            color: white !important;
            border: 2px solid #187C4E;
            border-radius: 25px; /* Rounded button */
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar custom-green-btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto"></ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index.php" class="brand-link">
            <img src="../images/logo.png" alt=" Logo" width="155" height="99" class="" style="opacity: .8">
            <span class="brand-text font-weight-light"></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../<?php echo $row2['photo']; ?>" alt="User Image" width="220" height="192" class="img-circle elevation-2">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?php echo $row2['fullname']; ?></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <?php include('sidebar.php'); ?>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
  
    <?php
    $query = "SELECT * FROM students"; 
    $result = mysqli_query($conn, $query); 
    $row_students = ($result) ? mysqli_num_rows($result) : 0;

    $query = "SELECT * FROM admin"; 
    $result = mysqli_query($conn, $query); 
    $row_users = ($result) ? mysqli_num_rows($result) : 0;

    // Get total amount paid as fee
    $sql = "SELECT SUM(amount) AS tot_pay FROM payment"; 
    $result = $conn->query($sql);
    $rowpayment = mysqli_fetch_array($result);
    $tot_pay = $rowpayment['tot_pay'];
    ?>
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1 custom-green-btn"><i class="fa fa-users" id="icon"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">No. Of Student(s)</span>
                                <span class="info-box-number"><?php echo $row_students; ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-1 custom-green-btn"><i class="fa fa-user" id="icon"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">No. Of User(s)</span>
                                <span class="info-box-number"><?php echo $row_users; ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-dollar-sign"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Amount Paid</span>
                                <span class="info-box-number">ZMW<?php echo number_format((float)$tot_pay, 2); ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>
                <!-- /.row -->

                <!-- Main row -->
                <div class="row">
                    <div class="col-md-8">
                        <!-- MAP & BOX PANE -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- DIRECT CHAT -->
                                <!--/.direct-chat -->
                            </div>
                            <!-- /.col -->

                            <div class="col-md-6">
                                <!-- USERS LIST -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Latest Student(s)</h3>
                                        <div class="card-tools">
                                            <span class="badge badge-danger custom-green-btn"><?php echo $row_students; ?> New Student(s)</span>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="users-list clearfix">
                                            <?php
                                            $sql = "SELECT * FROM students ORDER BY ID DESC LIMIT 8;";
                                            $result = $conn->query($sql);
                                            while ($row_new_students = $result->fetch_assoc()) { 
                                            ?>
                                                <li>
                                                    <img src="../<?php echo $row_new_students['photo']; ?>" alt="students Image">
                                                    <a class="users-list-name" href="#"><?php echo $row_new_students['fullname']; ?></a>
                                                    <span class="users-list-date"><?php echo $row_new_students['matric_no']; ?></span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <!-- /.users-list -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!--/.card -->

                                <!-- Comment Submission Form -->
                                <div class="container">
                                <div class="wrapper">

<!-- Display Success Message -->
<?php if (isset($_GET['success'])): ?>
    <div class='alert alert-success' style='margin: 15px;'>
        Comment added successfully!
    </div>
<?php endif; ?>



<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
        <img src="../images/logo.png" alt="Logo" width="155" height="99" style="opacity: .8">
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../<?php echo $row2['photo']; ?>" alt="User Image" class="img-circle elevation-2">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $row2['fullname']; ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php include('sidebar.php'); ?>
            </ul>
        </nav>
    </div>
</aside>


</div>
    <script src="js/bootstrap.min.js"></script>
</body>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="#">National Institute of Public Adminstration</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
           
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>

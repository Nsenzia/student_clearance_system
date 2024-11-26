<?php
session_start();
error_reporting(0);
include('connect.php');

// Redirect to login if the session is empty
if (empty($_SESSION['matric_no'])) {   
    header("Location: login.php"); 
    exit;
}

// Get necessary session details 
$ID = $_SESSION["ID"];
$matric_no = $_SESSION["matric_no"];
$dept = $_SESSION['dept'];
$faculty = $_SESSION['faculty'];

// Use prepared statements to prevent SQL injection
// Get total fees
$stmt = $conn->prepare("SELECT SUM(amount) AS tot_fee FROM fee WHERE faculty=? AND dept=?");
$stmt->bind_param("ss", $faculty, $dept);
$stmt->execute();
$result = $stmt->get_result();
$row_fee = $result->fetch_assoc();
$tot_fee = $row_fee['tot_fee'];

// Get total payments
$stmt = $conn->prepare("SELECT SUM(amount) AS tot_pay FROM payment WHERE studentID=?");
$stmt->bind_param("s", $ID);
$stmt->execute();
$result = $stmt->get_result();
$rowpayment = $result->fetch_assoc();
$tot_pay = $rowpayment['tot_pay'];

// Calculate outstanding fees
$outstanding_fee = $tot_fee - $tot_pay;

// Get student access details
$stmt = $conn->prepare("SELECT * FROM students WHERE matric_no=?");
$stmt->bind_param("s", $matric_no);
$stmt->execute();
$result = $stmt->get_result();
$rowaccess = $result->fetch_assoc();

$assistant_registrar_exam = $rowaccess["is_assistant_registrar_exam_approved"];
$assistant_registrar_stud_affairs = $rowaccess['is_assistant_registrar_stud_affairs_approved'];
$director_head = $rowaccess['is_director_head_approved'];
$librarian = $rowaccess['is_librarian_approved'];
$bursar = $rowaccess['is_bursar_approved'];
$deputy_registrar_stud_affairs = $rowaccess['is_deputy_registrar_stud_affairs_approved'];

date_default_timezone_set('Africa/Lusaka');
$current_date = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | Online Clearance System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    <style>
        /* Spinner for processing */
        .spinner {
            display: inline-block;
            width: 1em;
            height: 1em;
            border: 0.15em solid currentColor;
            border-bottom-color: transparent;
            border-radius: 50%;
            animation: spinner 0.6s linear infinite;
        }

        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Pending and Approved Buttons */
        .pending {
            color: white;
            background-color: red;
            padding: 5px 10px;
            border-radius: 25px; /* Rounded border for buttons */
            font-size: 1em;
            display: inline-block;
            border: 2px solid #ff9999;
        }

        .approved {
            color: white;
            background-color: #187C4E;
            padding: 5px 10px;
            border-radius: 25px; /* Rounded border for buttons */
            font-size: 1em;
            display: inline-block;
            border: 2px solid #66cc66;
        }

        /* Table styling with rounded borders */
        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: separate; /* Important to allow rounded corners */
            border-spacing: 0; /* Remove gaps between borders */
            border: 2px solid #ddd;
            border-radius: 15px; /* Rounded corners for the whole table */
        }

        th {
            text-align: center;
            width: 14.29%;
            padding: 10px;
            border: 2px solid #ddd;
            background-color: #f9f9f9;
            font-weight: bold;
            border-radius: 10px; /* Optional for individual column corners */
        }

        tbody td {
            border: 2px solid #ddd;
            padding: 8px;
            border-radius: 10px; /* Rounded corners for table rows */
        }

        /* Custom green button */
        .custom-green-btn {
            background-color: #187C4E !important;
            border-color: #187C4E !important;
            color: white !important;
            border: 2px solid #187C4E;
            border-radius: 25px; /* Rounded button */
        }

        /* Rounded borders for boxes */
        .ibox {
            border: 2px solid #ccc;
            padding: 10px;
            border-radius: 15px; /* Rounded corners for boxes */
        }

        .ibox-title {
            background-color: #f9f9f9;
            border-bottom: 2px solid #ddd;
            padding: 10px;
            border-radius: 10px 10px 0 0; /* Rounded top corners */
        }

        .ibox-content {
            padding: 15px;
            border-radius: 0 0 15px 15px; /* Rounded bottom corners */
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span>
                                <img src="<?php echo $rowaccess['photo']; ?>" alt="image" width="142" height="153" class="img-circle" />
                            </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="text-muted text-xs block">Student No: <?php echo $rowaccess['matric_no']; ?> <b class="caret"></b></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </div>  
                        <?php include('sidebar.php'); ?>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary custom-green-btn" href="#">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome <?php echo $rowaccess['fullname']; ?></span>
                        </li>
                        <li>
                            <a href="logout.php">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                    <!-- Total Fee -->
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5><span class="label label-success pull-right">Total Fee</span></h5>
                            </div>
                            <div class="ibox-content">
                                <h3 class="no-margins">ZMW<?php echo number_format($tot_fee, 2); ?></h3>
                            </div>
                        </div>
                    </div>             
            
                    <!-- Amount Paid -->
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5><span class="label label-secondary pull-right">Amount Paid</span></h5>
                            </div>
                            <div class="ibox-content">
                                <h3 class="no-margins">ZMW<?php echo number_format($tot_pay, 2); ?></h3>
                            </div>
                        </div>
                    </div>    
                
                    <!-- Outstanding Fee -->
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Outstanding Fee</h5>
                                <span class="label label-warning pull-right">ZMW</span>
                            </div>
                            <div class="ibox-content">
                                <h3 class="no-margins">ZMW<?php echo number_format($outstanding_fee, 2); ?></h3>
                            </div>
                        </div>
                    </div>  
                
                     <!-- Clearance Status -->
                     <div class="col-lg-3">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><span class="label label-info pull-right">Status</span></h5>
        </div>
        <div class="ibox-content">
            <h3 class="no-margins">
                <?php if ($assistant_registrar_exam == 1 && $assistant_registrar_stud_affairs == 1 && $director_head == 1 && $librarian == 1 && $bursar == 1 && $deputy_registrar_stud_affairs == 1) { ?>
                    <span class="approved">Approved</span>
                    <br>
                    <small><a href="letter.php" target="_blank">Download Clearance Letter</a></small>
                <?php } else { ?>
                    <span class="pending">Pending <span class="spinner" style="color: white;"></span></span>
                    <br>
                    <small><a href="check_process.php" target="_blank" >Check Process</a></small>
                <?php } ?>
            </h3>
        </div>
    </div>
                </div>

                <!-- Clearance Details Table -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Clearance Details</h5>
                            </div>
                            <div class="ibox-content">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Assistant Registrar (Examination)</th>
                                            <th>Assistant Registrar (Student Affairs)</th>
                                            <th>Director/Head</th>
                                            <th>Librarian</th>
                                            <th>Bursar</th>
                                            <th>Deputy Registrar (Student Affairs)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo ($assistant_registrar_exam == 1) ? '<span class="approved">Approved</span>' : '<span class="pending">Pending <span class="spinner"></span></span>'; ?></td>
                                            <td><?php echo ($assistant_registrar_stud_affairs == 1) ? '<span class="approved">Approved</span>' : '<span class="pending">Pending <span class="spinner"></span></span>'; ?></td>
                                            <td><?php echo ($director_head == 1) ? '<span class="approved">Approved</span>' : '<span class="pending">Pending <span class="spinner"></span></span>'; ?></td>
                                            <td><?php echo ($librarian == 1) ? '<span class="approved">Approved</span>' : '<span class="pending">Pending <span class="spinner"></span></span>'; ?></td>
                                            <td><?php echo ($bursar == 1) ? '<span class="approved">Approved</span>' : '<span class="pending">Pending <span class="spinner"></span></span>'; ?></td>
                                            <td><?php echo ($deputy_registrar_stud_affairs == 1) ? '<span class="approved">Approved</span>' : '<span class="pending">Pending <span class="spinner"></span></span>'; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
  
    </div>

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/inspinia.js"></script>
    
</body>
</html>

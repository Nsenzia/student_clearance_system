
<?php
session_start();
include('connect.php');

if (empty($_SESSION['matric_no'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Fetch student details for the sidebar
$matric_no = $_SESSION["matric_no"];
$sql = "SELECT * FROM students WHERE matric_no='$matric_no'"; 
$result = $conn->query($sql);
$rowaccess = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Clearance Form | Online Student Clearance System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <style>
        .custom-green-btn {
            background-color: #187C4E !important;
            border-color: #187C4E !important;
            color: white !important;
            border: 2px solid #187C4E;
            border-radius: 25px; /* Rounded button */
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
                            <span class="clear"><span class="text-muted text-xs block">Matric No: <?php echo $rowaccess['matric_no']; ?><b class="caret"></b></span></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <?php include('sidebar.php'); ?>
                </li>
                <li>
                    <a href="#"><i class="fa fa-upload"></i> <span class="nav-label">Clearance</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="upload-documents.php">Upload Documents</a></li>
                        <li><a href="download-clearance-form.php">Download Clearance Form</a></li>
                    </ul>
                </li>
                <!-- Other menu items -->
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary custom-green-btn " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Welcome to <?php echo $rowaccess['fullname']; ?></span>
                    </li>
                    <li>
                        <a href="logout.php">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Download Student Clearance Form</h5>
                        </div>
                        <div class="ibox-content">
                            <p>You can download your student clearance form using the button below:</p>
                            <a href="download.php" class="btn btn-primary custom-green-btn">Download Clearance Form</a> <!-- Link to download.php -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div><?php include('footer.php'); ?></div>
        </div>
    </div>
</div>

<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<script src="js/inspinia.js"></script>


</body>
</html>

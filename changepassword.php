<?php
session_start();
error_reporting(0);
include('connect.php');

if(empty($_SESSION['matric_no'])) {   
    header("Location: login.php"); 
} else {
    // User is logged in
}

$matric_no = $_SESSION["matric_no"];
$sql = "SELECT * FROM students WHERE matric_no='$matric_no'"; 
$result = $conn->query($sql);
$rowaccess = mysqli_fetch_array($result);

date_default_timezone_set('Africa/Zambia');
$current_date = date('Y-m-d ');

$q = "SELECT * FROM students WHERE matric_no = '$matric_no'";
$q1 = $conn->query($q);
while($row = mysqli_fetch_array($q1)) {
    extract($row);
    $db_pass = $row['password'];
    $matric_no = $row['matric_no'];
}

if(isset($_POST["btnchange"])) {
    $old = mysqli_real_escape_string($conn, $_POST['txtold_password']);
    $pass_new = mysqli_real_escape_string($conn, $_POST['txtnew_password']);
    $confirm_new = mysqli_real_escape_string($conn, $_POST['txtconfirm_password']);

    if($db_pass != $old) { 
        $_SESSION['error'] = 'Old Password not matched';
    } else if($pass_new != $confirm_new) { 
        $_SESSION['error'] = 'New Password and Confirm Password not Matched';
    } else {
        $sql = "UPDATE students SET `password`='$confirm_new' WHERE matric_no= '".$_SESSION['matric_no']."'";
        $res = $conn->query($sql);
        header("refresh:5;url=login.php");
        $_SESSION['success'] = 'Password changed Successfully...';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | Online Clearance System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    <style>
        .btn-custom {
    background-color: #187C4E !important;
    border-color: #187C4E !important;
    color: white !important; /* Change text color to white */
}
.btn-custom:hover {
    background-color: #155d3a !important;
    border-color: #155d3a !important;
}

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
                            <span class="clear"><span class="text-muted text-xs block">Matric No: <?php echo $rowaccess['matric_no']; ?> <b class="caret"></b></span></span>
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
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary custom-green-btn" href="#"><i class="fa fa-bars"></i></a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Welcome to <?php echo $rowaccess['fullname'];?></span>
                    </li>
                    <li>
                        <a href="logout.php">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2></h2>
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li class="active"><strong>Change Password</strong></li>
                </ol>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5></h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-6 b-r">
                                    <h3 class="m-t-none m-b">Change Password</h3>
                                    <form role="form" method="POST">
                                        <div class="form-group"><strong><label>Old Password</label></strong>
                                            <input type="password" name="txtold_password" value="<?php if (isset($_POST['txtold_password'])) echo $_POST['txtold_password']; ?>" placeholder="Enter Old Password" class="form-control" required="">
                                        </div>
                                        <div class="form-group"><strong><label>New Password</label></strong>
                                            <input type="password" name="txtnew_password" value="<?php if (isset($_POST['txtnew_password'])) echo $_POST['txtnew_password']; ?>" placeholder="Enter New Password" class="form-control" required="">
                                        </div>
                                        <div class="form-group"><strong><label>Confirm New Password</label></strong>
                                            <input type="password" name="txtconfirm_password" value="<?php if (isset($_POST['txtconfirm_password'])) echo $_POST['txtconfirm_password']; ?>" placeholder="Confirm New Password" class="form-control" required="">
                                        </div>
                                        <div>
                                            <button class="btn btn-sm btn-custom pull-right m-t-n-xs" type="submit" name="btnchange"><strong>Change Password</strong></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-center">&nbsp;</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5"></div>
            </div>
            <div class="row"></div>
        </div>

        <div class="footer">
            <div><?php include('footer.php'); ?></div>
        </div>

    </div>
</div>

<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>

<link rel="stylesheet" href="popup_style.css">
<?php if(!empty($_SESSION['success'])) { ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
        <h3 class="popup__content__title"><strong>Success</strong></h3>
        <p><?php echo $_SESSION['success']; ?></p>
        <p><button class="button button--success" data-for="js_success-popup">Close</button></p>
    </div>
</div>
<?php unset($_SESSION["success"]); } ?>
<?php if(!empty($_SESSION['error'])) { ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
        <h3 class="popup__content__title"><strong>Error</strong></h3>
        <p><?php echo $_SESSION['error']; ?></p>
        <p><button class="button button--error" data-for="js_error-popup">Close</button></p>
    </div>
</div>
<?php unset($_SESSION["error"]); } ?>

<script>
    var addButtonTrigger = function addButtonTrigger(el) {
        el.addEventListener('click', function (e) {
            var popup = document.querySelector('.popup--' + this.dataset.for);
            popup.classList.toggle('popup--visible');
        });
    };
    var buttons = document.querySelectorAll('.button');
    buttons.forEach(addButtonTrigger);
</script>
</body>
</html>

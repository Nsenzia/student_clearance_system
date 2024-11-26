<?php
session_start();
error_reporting(0);
include('connect.php');

if (empty($_SESSION['matric_no'])) {
    header("Location: login.php");
}

$ID = $_SESSION["ID"];
$matric_no = $_SESSION["matric_no"];

$sql = "SELECT * FROM students WHERE matric_no = '$matric_no'"; 
$result = $conn->query($sql);
$rowaccess = mysqli_fetch_array($result);

date_default_timezone_set('Africa/Lusaka');
$current_date = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Letter | National Institute of Public Administration</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            color: #187C4E; /* Adjust color as necessary */
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            color: #555;
        }
        .signed-section {
            text-align: right;
            margin-top: 40px;
        }
        .centered {
            text-align: center;
        }
        .logo {
            width: 120px; /* Adjust the width as needed */
        }
        .date {
            text-align: right;
            font-size: 14px;
            margin-top: -20px; /* Adjust for spacing */
            color: #777;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
            color: #888;
        }
        hr {
            border: 1px solid #e0e0e0;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="wrapper-content animated fadeInRight article">
        <div class="container">
            <div class="centered">
                <img src="path/to/your/logo.png" class="logo" alt="Institution Logo">
                <h1>National Institute of Public Administration</h1>
                <div class="date"><?php echo date('F j, Y', strtotime($current_date)); ?></div>
            </div>
            <h2 class="title">Clearance Letter</h2>
            <hr>

            <p>Hello <strong><?php echo $rowaccess['fullname']; ?></strong>,</p>

            <p>This letter is to confirm that you have successfully been cleared by the following departments:</p>
            <ul>
                <li>Assistant Registrar - Examinations</li>
                <li>Assistant Registrar - Student Affairs</li>
                <li>Director/Head of Department</li>
                <li>Librarian</li>
                <li>Bursar</li>
            </ul>

            <h3 class="section-title">Student Information</h3>
            <p><strong>Full Name:</strong> <?php echo $rowaccess['fullname']; ?></p>
            <p><strong>Student Number:</strong> <?php echo $rowaccess['matric_no']; ?></p>
            <p><strong>Faculty:</strong> <?php echo $rowaccess['faculty']; ?></p>
            <p><strong>Department:</strong> <?php echo $rowaccess['dept']; ?></p>

            <p>I hereby certify that the above-named student <strong>HAS BEEN</strong> cleared.</p>

            <div class="signed-section">
                <p>Sincerely,</p>
                <p><strong>Deputy Registrar - Academic Affairs</strong></p>
                <img src="path/to/your/signature.png" alt="Digital Signature" style="width:150px; height:auto;"> <!-- Adjust size as needed -->
            </div>

            <div class="left">
                <a href="#" id="print-button" onclick="window.print(); return false;">Print this Document</a>
            </div>
            <div class="footer">
                <p>&copy; <?php echo date('Y'); ?> National Institute of Public Administration. All Rights Reserved.</p>
            </div>
        </div>
    </div>

    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
</body>

</html>

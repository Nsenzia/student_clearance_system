<?php
session_start();
include('connect.php');

if(empty($_SESSION['matric_no'])) {   
    header("Location: login.php"); 
} else {
    $ID = $_SESSION["ID"];
    $matric_no = $_SESSION["matric_no"];
    $dept = $_SESSION['dept'];
    $faculty = $_SESSION['faculty'];

    // Check if the uploads directory exists, if not create it
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true); // Create the uploads directory if it doesn't exist
    }

    if(isset($_POST['upload'])) {
        // Handle file upload
        $fileName = basename($_FILES["document"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Move the uploaded file to the target directory
        if(move_uploaded_file($_FILES["document"]["tmp_name"], $targetFilePath)) {
            // Insert document details into database
            $sql = "INSERT INTO clearance_documents (studentID, document_name, document_path) VALUES ('$ID', '$fileName', '$targetFilePath')";
            if ($conn->query($sql) === TRUE) {
                $successMsg = "Document uploaded successfully!";
            } else {
                $errorMsg = "Database error: " . $conn->error;
            }
        } else {
            $errorMsg = "Error uploading file.";
        }
    }

    // Fetch student details for the sidebar
    $sql = "SELECT * FROM students WHERE matric_no='$matric_no'";
    $result = $conn->query($sql);
    $rowaccess = mysqli_fetch_array($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Documents | Online Student Clearance System</title>
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
                            <span class="clear"><span class="text-muted text-xs block">Student Number: <?php echo $rowaccess['matric_no']; ?><b class="caret"></b></span></span>
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
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary custom-green-btn " href="#"><i class="fa fa-bars"></i></a>
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
                            <h5>Upload Document</h5>
                        </div>
                        <div class="ibox-content">
                            <?php if(isset($successMsg)) echo "<div class='alert alert-success'>$successMsg</div>"; ?>
                            <?php if(isset($errorMsg)) echo "<div class='alert alert-danger'>$errorMsg</div>"; ?>
                            <form action="upload-documents.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="document">Choose Document to Upload</label>
                                    <input type="file" class="form-control" id="document" name="document" required>
                                </div>
                                <button type="submit" name="upload" class="btn btn-primary custom-green-btn">Upload</button>
                            </form>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        /* Wrapper to contain both sidebar and content */
        #wrapper {
            display: flex;
            min-height: 100vh; /* Full height */
            overflow-x: hidden;
        }

        /* Sidebar styling */
        .navbar-default {
            width: 220px; /* Adjust width */
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1000;
            background-color: #2f4050; /* Sidebar background */
            padding-top: 20px;
            overflow-y: auto; /* Scroll if sidebar is long */
        }

        /* Sidebar menu items */
        .navbar-default ul {
            padding: 0;
            list-style: none;
        }

        /* Adjusted styles for dropdown arrows */
        .nav-item a {
            color: #ffffff; /* Menu text color */
            padding: 10px 20px; /* Add some padding */
            display: flex; /* Flex layout for icon and text */
            align-items: center; /* Center items vertically */
            justify-content: space-between; /* Distribute space between items */
            text-decoration: none;
            transition: background-color 0.3s ease; /* Smooth transition for background color */
        }

        .navbar-default li a:hover {
            background-color: #293846; /* Hover effect */
        }

        .navbar-default .nav-label {
            margin-left: 10px;
        }

        /* Page content area */
        #page-wrapper {
            margin-left: 220px; /* Offset by sidebar width */
            padding: 20px;
            width: calc(100% - 220px); /* Make content fit the rest of the page */
            background-color: #f3f3f4;
        }

        /* Dropdown arrow rotation */
        .fa.arrow {
            margin-left: 10px; /* Increase space between text and arrow */
            transition: transform 0.2s; /* Arrow rotation transition */
        }

        .nav-second-level.collapse.in .fa.arrow {
            transform: rotate(90deg); /* Rotate when expanded */
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .navbar-default {
                position: relative;
                width: 100%;
                height: auto;
            }

            #page-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Additional styles for sidebar */
        .nav-item a {
            color: #ffffff; /* Default text color */
            padding: 10px 15px; /* Add some padding */
            display: flex; /* Flex layout for icon and text */
            align-items: center; /* Center items vertically */
            transition: background-color 0.3s ease; /* Smooth transition for background color */
        }

        .nav-item a:hover {
            background-color: #4c5c70; /* Change background color on hover */
        }

        .nav-second-level li a {
            color: #ffffff; /* Default text color for sub-items */
            padding: 10px 15px; /* Add some padding */
            text-decoration: none; /* Remove underline */
            display: block; /* Make the entire area clickable */
            transition: background-color 0.3s ease; /* Smooth transition for background color */
        }

        .nav-second-level li a:hover {
            background-color: #4c5c70; /* Background color when hovering */
        }

        
    </style>
</head>
<body>

<div id="wrapper">
    <!-- Sidebar -->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <h4 class="text-center" style="color: #ffffff;">Student Dashboard</h4>
                </li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="index.php">
                        <i class="fa fa-th-large"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>

                <!-- Account -->
                <li class="nav-item">
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span class="nav-label">Account</span><span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="edit-photo.php">Edit Photo</a></li>
                        <li><a href="changepassword.php">Change Password</a></li>
                    </ul>
                </li>

                <!-- School Fees -->
                <li class="nav-item">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        <span class="nav-label">School Fees</span><span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="pay-fee.php">Pay School Fee</a></li>
                        <li><a href="fee-history.php">Payment History</a></li>
                    </ul>
                </li>

                <!-- Clearance -->
                <li class="nav-item">
                    <a href="#">
                        <i class="fa fa-upload"></i>
                        <span class="nav-label">Clearance</span><span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="upload-documents.php">Upload Documents</a></li>
                        <li><a href="download-clearance-form.php">Download Clearance Form</a></li>
                    </ul>
                </li>
                <li class="nav-item">
            <a href="request_clearance_form.html" class="nav-link">
              <p>Request for Clearance</p>
            </a>
          </li>
            </ul>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper" class="gray-bg">
        <div class="container">
            <h1>Welcome to the Student Dashboard</h1>
            <p>Your content goes here...</p>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script>
    $(document).ready(function() {
        $('#side-menu').metisMenu(); // Initialize MetisMenu
    });
</script>

</body>
</html>

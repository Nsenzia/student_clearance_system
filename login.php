<?php
session_start();
error_reporting(1);
include('connect2.php');

if (isset($_POST['btnlogin'])) {
    if (!empty($_POST['txtmatric_no']) && !empty($_POST['txtpassword'])) {
        $matric_no = $_POST['txtmatric_no'];
        $password = $_POST['txtpassword'];

        $sql = "SELECT * FROM `students` WHERE `matric_no`=? AND `password`=?";
        $query = $dbh->prepare($sql);
        $query->execute(array($matric_no, $password));
        $row = $query->rowCount();
        $fetch = $query->fetch();

        if ($row > 0) {
            foreach ($fetch as $items => $v) {
                if (!is_numeric($items)) {
                    $_SESSION[$items] = $v;
                }
            }

            // Add session variable for matric_no
            $_SESSION['student_id'] = $fetch['matric_no']; // Using 'matric_no' as the unique identifier

            header("Location: index.php");
        } else {
            $_SESSION['error'] = 'Invalid Matric No/Password';
        }
    } else {
        $_SESSION['error'] = 'Must Fill-in All Fields';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form | Online Student Clearance System</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
       body {
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.1);
        }

        .login-logo img {
            display: block;
            margin: 0 auto 20px;
            width: 150px;
        }

        .login-box-msg {
            font-size: 24px;
            font-weight: bold;
            color:black;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 8px;
            height: 45px;
            font-size: 16px;
        }

        .btn-primary {
    background-color: black;
    border: none; /* Ensure there's no border */
    border-radius: 8px;
    padding: 10px 0;
    font-size: 18px;
    transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease; 
}

.btn-primary:hover {
    background-color: white;
    color: black;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
    cursor: pointer;
}

/* Active state override */
.btn-primary:active {
    background-color: black; /* Keeps the background black */
    color: white; /* Ensures the text stays white */
    box-shadow: none; /* Optional: remove shadow */
    transform: scale(0.98); /* Optional: slight press effect */
}

/* If you want to prevent the blue focus outline */
.btn-primary:focus {
    outline: none; /* Remove focus outline */
    box-shadow: none; /* Remove focus shadow */
}


        .forgot-password-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #6c757d;
        }

        .forgot-password-link:hover {
            text-decoration: underline;
            color: black;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup--visible {
            display: flex;
        }

        .popup__content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .popup__content h3 {
            margin-bottom: 10px;
        }

        .animate__fadeInDown {
            animation-duration: 0.75s;
    
/*The close button color*/
            .btn-black {
    background-color: black; /* Black background */
    color: white; /* White text */
    border: none; /* No border */
    padding: 10px 15px; /* Padding for the button */
    border-radius: 8px; /* Rounded corners */
}

.btn-black:hover {
    background-color: white; /* White background on hover */
    color: black; /* Black text on hover */
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3); /* Optional shadow */
    cursor: pointer; /* Pointer cursor on hover */
}

        }
    </style>
</head>
<body>

<div class="login-box animate__animated animate__fadeInDown">
    <div class="login-logo">
        <img src="images/logo.png" alt="Online Clearance Logo">
    </div>
    <p class="login-box-msg">STUDENT LOGIN FORM</p>
    <form action="" method="POST">
        <div class="form-group">
            <input type="text" name="txtmatric_no" class="form-control" placeholder="Matric No" id="matric_no" required>
        </div>
        <div class="form-group">
            <input type="password" name="txtpassword" class="form-control" placeholder="Password"  id="password" required>
        </div>
        <button type="submit" name="btnlogin" class="btn btn-primary btn-block">Login</button>
        <a href="#" class="forgot-password-link">Forgot password?</a>
    </form>
</div>


<!-- Popup for Success or Error -->
<?php if (!empty($_SESSION['success'])) { ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
    <div class="popup__content">
        <h3><strong>Success</strong></h3>
        <p><?php echo $_SESSION['success']; ?></p>
        <button class="btn btn-primary" data-for="js_success-popup">Close</button> <!-- Changed to btn-primary -->
    </div>
</div>
<?php unset($_SESSION['success']); } ?>

<?php if (!empty($_SESSION['error'])) { ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
    <div class="popup__content">
        <h3><strong>Error</strong></h3>
        <p><?php echo $_SESSION['error']; ?></p>
        <button class="btn btn-primary" data-for="js_error-popup">Close</button> <!-- Changed to btn-primary -->
    </div>
</div>
<?php unset($_SESSION['error']); } ?>

<script>
    document.querySelectorAll('button[data-for]').forEach(function (el) {
        el.addEventListener('click', function () {
            document.querySelector('.' + el.dataset.for).classList.toggle('popup--visible');
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

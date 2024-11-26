<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "student_clearance"; // Replace with your DB name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all admin roles from the database
$sql = "SELECT ID, designation FROM admin"; // Changed 'admins' to 'admin'
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Comment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Comment</h2>

        <form action="add_comment.php" method="POST">
            <!-- Admin Role Selection -->
            <div class="form-group">
                <label for="admin_role">Your Role</label>
                <select name="admin_id" id="admin_role" class="form-control" required>
                    <option value="">Select your role</option>
                    <?php
                    // Loop through admin roles and add them to the select dropdown
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['ID'] . "'>" . $row['designation'] . "</option>"; // Changed 'role' to 'designation'
                    }
                    ?>
                </select>
            </div>

            <!-- Student Number Input -->
            <div class="form-group">
                <label for="student_id">Student Number</label>
                <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter student number" required>
            </div>

            <!-- Comment Input -->
            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Write your comment" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit Comment</button>
        </form>
        
    </div>
</body>
</html>

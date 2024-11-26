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

// Check if comments table exists, if not create it
$table_check = $conn->query("SHOW TABLES LIKE 'comments'");
if ($table_check->num_rows == 0) {
    $create_table_sql = "CREATE TABLE comments (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        student_id INT(11) UNSIGNED NOT NULL,
        admin_id INT(11) UNSIGNED NOT NULL,
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    if ($conn->query($create_table_sql) === TRUE) {
        echo "<div class='alert alert-info'>Comments table created successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error creating comments table: " . $conn->error . "</div>";
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['admin_id'];
    $student_number = $_POST['student_id'];
    $comment = $_POST['comment'];

    // First, get the student's ID using their student number
    $stmt = $conn->prepare("SELECT ID FROM students WHERE matric_no = ?");
    $stmt->bind_param("s", $student_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_id = $row['ID'];

        // Now insert the comment using the student's ID
        $stmt = $conn->prepare("INSERT INTO comments (student_id, admin_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $student_id, $admin_id, $comment);

        if ($stmt->execute()) {
            $success_message = "Comment added successfully!";
        } else {
            $error_message = "Error adding comment: " . $conn->error;
        }
    } else {
        $error_message = "Student not found with the given student number.";
    }
}
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

        <?php
        if (isset($success_message)) {
            echo "<div class='alert alert-success'>" . $success_message . "</div>";
        }
        if (isset($error_message)) {
            echo "<div class='alert alert-danger'>" . $error_message . "</div>";
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <!-- Admin Role Selection -->
            <div class="form-group">
                <label for="admin_role">Your Role</label>
                <select name="admin_id" id="admin_role" class="form-control" required>
                    <option value="">Select your role</option>
                    <option value="1">Assistant Registrar (Examination)</option>
                    <option value="2">Assistant Registrar (Student Affairs)</option>
                    <option value="3">Director/Head</option>
                    <option value="4">Librarian</option>
                    <option value="5">Bursar</option>
                    <option value="6">Deputy Registrar (Student Affairs)</option>
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

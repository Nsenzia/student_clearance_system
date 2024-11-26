<?php
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "student_clearance"; // Replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE comments (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id INT(11) UNSIGNED NOT NULL,
    admin_id INT(11) UNSIGNED NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(ID),
    FOREIGN KEY (admin_id) REFERENCES admin(ID)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table comments created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
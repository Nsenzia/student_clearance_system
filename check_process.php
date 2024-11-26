<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connect.php');

if (empty($_SESSION['matric_no'])) {   
    header("Location: login.php"); 
    exit;
}

$matric_no = $_SESSION["matric_no"];

// First, get the student's ID using their matric number
$stmt = $conn->prepare("SELECT ID FROM students WHERE matric_no = ?");
$stmt->bind_param("s", $matric_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $student_id = $row['ID'];

    // Now fetch comments for the student using the correct table name
    $sql_comments = "SELECT c.comment, c.created_at, a.designation 
                     FROM comments c 
                     JOIN admin a ON c.admin_id = a.ID 
                     WHERE c.student_id = ? 
                     ORDER BY c.created_at DESC";
    
    $stmt = $conn->prepare($sql_comments);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result_comments = $stmt->get_result();

    $comments = [];
    if ($result_comments->num_rows > 0) {
        while ($row = $result_comments->fetch_assoc()) {
            $comments[] = [
                'comment' => $row['comment'],
                'date_added' => $row['created_at'],
                'admin_role' => $row['designation']
            ];
        }
    }

    // Determine the status message
    $status_message = 'Pending';
    if (count($comments) > 0) {
        $status_message .= ': Comments available';
    } else {
        $status_message .= ': No comments provided.';
    }
} else {
    $status_message = 'Error: Student not found';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Process | Clearance Comments</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Clearance Status</h1>
        <p class="alert alert-info"><?php echo $status_message; ?></p>
        
        <?php if (!empty($comments)): ?>
            <h3>Comments:</h3>
            <ul class="list-group">
                <?php foreach ($comments as $comment): ?>
                    <li class="list-group-item">
                        <strong><?php echo htmlspecialchars($comment['admin_role']); ?>:</strong>
                        <?php echo htmlspecialchars($comment['comment']); ?>
                        <small class="text-muted d-block">
                            Added on: <?php echo date('F j, Y, g:i a', strtotime($comment['date_added'])); ?>
                        </small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No comments have been added yet.</p>
        <?php endif; ?>

        <a href="index.php" class="btn btn-primary mt-3">Back to Dashboard</a>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
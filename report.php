<?php
session_start();
include('../connect.php');

if (empty($_SESSION['admin-username'])) {   
    header("Location: login.php"); 
    exit;
}

// Fetch cleared students
$sql_cleared = "SELECT * FROM students WHERE is_assistant_registrar_exam_approved = 1
                AND is_assistant_registrar_stud_affairs_approved = 1
                AND is_director_head_approved = 1
                AND is_librarian_approved = 1
                AND is_bursar_approved = 1
                AND is_deputy_registrar_stud_affairs_approved = 1";
$result_cleared = $conn->query($sql_cleared);
$num_cleared = $result_cleared->num_rows;

// Fetch uncleared students
$sql_uncleared = "SELECT * FROM students WHERE is_assistant_registrar_exam_approved = 0
                  OR is_assistant_registrar_stud_affairs_approved = 0
                  OR is_director_head_approved = 0
                  OR is_librarian_approved = 0
                  OR is_bursar_approved = 0
                  OR is_deputy_registrar_stud_affairs_approved = 0";
$result_uncleared = $conn->query($sql_uncleared);
$num_uncleared = $result_uncleared->num_rows;

$total_students = $num_cleared + $num_uncleared;
$cleared_percentage = ($total_students > 0) ? ($num_cleared / $total_students) * 100 : 0;
$uncleared_percentage = ($total_students > 0) ? ($num_uncleared / $total_students) * 100 : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Clearance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .progress {
            height: 25px;
        }
        .progress-bar {
            line-height: 25px;
        }
        .clearance-status {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .clearance-status i {
            margin-right: 10px;
        }
        .cleared {
            color: green;
        }
        .not-cleared {
            color: red;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Student Clearance System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-user"></i> <?php echo $_SESSION['admin-username']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Student Clearance Report</h2>
    
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <p class="card-text display-4"><?php echo $total_students; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Clearance Progress</h5>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $cleared_percentage; ?>%" aria-valuenow="<?php echo $cleared_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo round($cleared_percentage, 1); ?>% Cleared</div>
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $uncleared_percentage; ?>%" aria-valuenow="<?php echo $uncleared_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo round($uncleared_percentage, 1); ?>% Uncleared</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Cleared Students Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Cleared Students: <?php echo $num_cleared; ?></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Student Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result_cleared->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['matric_no']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#studentModal" data-fullname="<?php echo $row['fullname']; ?>" data-matricno="<?php echo $row['matric_no']; ?>" data-clearance="all">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Uncleared Students Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Uncleared Students: <?php echo $num_uncleared; ?></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Student Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result_uncleared->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['matric_no']; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#studentModal" 
                                            data-fullname="<?php echo $row['fullname']; ?>" 
                                            data-matricno="<?php echo $row['matric_no']; ?>"
                                            data-clearance="<?php echo $row['is_assistant_registrar_exam_approved']; ?>,<?php echo $row['is_assistant_registrar_stud_affairs_approved']; ?>,<?php echo $row['is_director_head_approved']; ?>,<?php echo $row['is_librarian_approved']; ?>,<?php echo $row['is_bursar_approved']; ?>,<?php echo $row['is_deputy_registrar_stud_affairs_approved']; ?>">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Report Button -->
    <div class="text-center mb-4">
        <a href="download_report.php" class="btn btn-success">Download Report</a>
    </div>
</div>

<!-- Student Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Full Name:</strong> <span id="modal-fullname"></span></p>
                <p><strong>Student Number:</strong> <span id="modal-matricno"></span></p>
                <div class="clearance-status">
                    <i class="fa fa-check cleared"></i> <span>Cleared by Assistant Registrar (Exams): <span id="modal-assistant-registrar-exam"></span></span>
                </div>
                <div class="clearance-status">
                    <i class="fa fa-check cleared"></i> <span>Cleared by Assistant Registrar (Student Affairs): <span id="modal-assistant-registrar-stud-affairs"></span></span>
                </div>
                <div class="clearance-status">
                    <i class="fa fa-check cleared"></i> <span>Cleared by Director/Head: <span id="modal-director-head"></span></span>
                </div>
                <div class="clearance-status">
                    <i class="fa fa-check cleared"></i> <span>Cleared by Librarian: <span id="modal-librarian"></span></span>
                </div>
                <div class="clearance-status">
                    <i class="fa fa-check cleared"></i> <span>Cleared by Bursar: <span id="modal-bursar"></span></span>
                </div>
                <div class="clearance-status">
                    <i class="fa fa-check cleared"></i> <span>Cleared by Deputy Registrar (Student Affairs): <span id="modal-deputy-registrar-stud-affairs"></span></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fill the modal with student data
    const studentModal = document.getElementById('studentModal');
    studentModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const fullname = button.getAttribute('data-fullname');
        const matricno = button.getAttribute('data-matricno');
        const clearance = button.getAttribute('data-clearance').split(',');

        // Update the modal's content
        studentModal.querySelector('#modal-fullname').textContent = fullname;
        studentModal.querySelector('#modal-matricno').textContent = matricno;

        const clearanceStatuses = [
            'modal-assistant-registrar-exam',
            'modal-assistant-registrar-stud-affairs',
            'modal-director-head',
            'modal-librarian',
            'modal-bursar',
            'modal-deputy-registrar-stud-affairs'
        ];

        clearanceStatuses.forEach((id, index) => {
            const status = clearance[index] == 1 ? 'Cleared' : ' Cleared';
            studentModal.querySelector(`#${id}`).textContent = status;
        });
    });
</script>
</body>
</html>

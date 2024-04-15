<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

$regNo = $_SESSION['regNo']; // Assuming the session variable for the student's unique identifier is 'regNo'

// Function to get attendance history for a specific student
function getAttendanceHistory($regNo) {
    global $mysqli;

    $query = "SELECT * FROM attendance WHERE regNo = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die("Error in prepare statement (getAttendanceHistory): " . $mysqli->error);
    }

    $stmt->bind_param('s', $regNo);
    $stmt->execute();

    $result = $stmt->get_result();
    $attendanceHistory = array();

    while ($row = $result->fetch_assoc()) {
        $attendanceHistory[] = $row;
    }

    $stmt->close();

    return $attendanceHistory;
}

$attendanceHistory = getAttendanceHistory($regNo);
?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>View Attendance History</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("includes/header.php");?>

    <div class="ts-main-content">
        <?php include("includes/sidebar.php");?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title" style="margin-top:4%">View Attendance History</h2>

                        <div class="row">
                            <div class="col-md-12">
                                <?php if (!empty($attendanceHistory)) : ?>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Attendance Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($attendanceHistory as $attendance) : ?>
                                                <tr>
                                                    <td><?= $attendance['date'] ?></td>
                                                    <td><?= $attendance['status'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <p>No attendance records found.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>

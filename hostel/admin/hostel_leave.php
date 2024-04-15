<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    // Retrieve form data
    $regNo = $_POST['student_name'];
    $reason = $_POST['reason'];
    $fromDate = $_POST['from_date'];
    $toDate = $_POST['to_date'];

    // Check if the student exists with the given registration number
    $checkStudentQuery = "SELECT COUNT(*) FROM userRegistration WHERE regNo = ?";
    $stmtCheckStudent = $mysqli->prepare($checkStudentQuery);

    // Check if prepare was successful
    if (!$stmtCheckStudent) {
        die("Error in prepare statement (checkStudentQuery): " . $mysqli->error);
    }

    $stmtCheckStudent->bind_param('s', $regNo);
    $stmtCheckStudent->execute();
    $stmtCheckStudent->bind_result($studentCount);
    $stmtCheckStudent->fetch();
    $stmtCheckStudent->close();

    if ($studentCount > 0) {
        // Insert leave request into hostel_leave_requests table
        $insertQuery = "INSERT INTO hostel_leave_requests (id, reason, from_date, to_date, status) VALUES (?, ?, ?, ?, 'Pending')";
        $stmtInsert = $mysqli->prepare($insertQuery);

        // Check if prepare was successful
        if (!$stmtInsert) {
            die("Error in prepare statement (insertQuery): " . $mysqli->error);
        }

        $stmtInsert->bind_param('ssss', $regNo, $reason, $fromDate, $toDate);

        // Execute the query and check for success
        if ($stmtInsert->execute()) {
            echo "Leave request submitted successfully.";
        } else {
            echo "Error submitting leave request: " . $stmtInsert->error;
        }

        $stmtInsert->close();
    } else {
        echo "Student with registration number $regNo not found.";
    }
}
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

    <title>Hostel Leave</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
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

                        <h2 class="page-title" style="margin-top:4%">Hostel Leave</h2>

                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="student_name">Student Name:</label>
                                        <select name="student_name" id="student_name" class="form-control" required>
                                            <?php
                                                // Ensure the database connection is established
                                                if ($mysqli->connect_error) {
                                                    die("Connection failed: " . $mysqli->connect_error);
                                                }

                                                // Fetch student names from the database
                                                $query = "SELECT regNo, firstName, lastName FROM userRegistration";
                                                $result = $mysqli->query($query);

                                                if ($result) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $fullName = $row['firstName'] . ' ' . $row['lastName'];
                                                        echo "<option value='{$row['regNo']}'>$fullName</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>Error fetching data</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="reason">Reason for Leave:</label>
                                        <textarea name="reason" id="reason" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="from_date">From Date:</label>
                                        <input type="date" name="from_date" id="from_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="to_date">To Date:</label>
                                        <input type="date" name="to_date" id="to_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit Leave Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
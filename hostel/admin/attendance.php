<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    // Process the form submission
    // Perform necessary actions like storing the attendance record in the database
    // Redirect or show a success message as needed

    $attendanceDate = $_POST['attendance_date'];
    $shift = $_POST['shift'];

    // Check if attendance record already exists for the selected date and session
    $checkQuery = "SELECT COUNT(*) FROM attendance WHERE attendanceDate = ? AND shift = ?";
    $stmtCheck = $mysqli->prepare($checkQuery);
    $stmtCheck->bind_param('ss', $attendanceDate, $shift);
    $stmtCheck->execute();
    $stmtCheck->bind_result($attendanceCount);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($attendanceCount > 0) {
        // If attendance record already exists, redirect with an error message or perform any other action
        header("Location: dashboard.php?error=AttendanceAlreadyTaken");
        exit();
    }

    // Get the selected students for confirmation
    $selectedStudents = [];
    foreach ($_POST['attendance'] as $regNo => $status) {
        if ($status === 'Absent') {
            $selectedStudents[] = $regNo;
        }
    }

    // Store attendance data in the database
    foreach ($selectedStudents as $regNo) {
        $status = '1'; // Set status as 1 for Absent
        $insertQuery = "INSERT INTO attendance (regNo, attendanceDate, shift, status) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($insertQuery);
        $stmt->bind_param("ssss", $regNo, $attendanceDate, $shift, $status);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to dashboard
    header("Location: dashboard.php?success=AttendanceSubmitted");
    exit();
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

    <title>Attendance</title>
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

                        <h2 class="page-title" style="margin-top:4%">Attendance</h2>

                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="" name="attendanceForm" onsubmit="return confirmAttendance()">
                                <div class="form-group">
                                        <label for="attendance_date">Attendance Date:</label>
                                        <input type="date" name="attendance_date" id="attendance_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="shift">Session:</label><br>
                                        <label class="radio-inline"><input type="radio" name="shift" value="Morning">Morning</label>
                                        <label class="radio-inline"><input type="radio" name="shift" value="Evening">Evening</label>
                                    </div>    
                                <div class="form-group">
                                        
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Reg No</th>
                                                    <th>Name</th>
                                                    <th>Absent</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    // Fetch student names and registration numbers from the database
                                                    $query = "SELECT regNo, firstName, lastName FROM userRegistration";
                                                    $result = $mysqli->query($query);

                                                    while ($row = $result->fetch_assoc()) {
                                                        $fullName = $row['firstName'] . ' ' . $row['lastName'];
                                                        $isChecked = ($row['regNo'] === 'absent') ? 'checked' : ''; // Modify this condition based on your data
                                                        echo "<tr>
                                                                <td>{$row['regNo']}</td>
                                                                <td>{$fullName}</td>
                                                                <td><input type='checkbox' name='attendance[{$row['regNo']}]' value='Absent' {$isChecked}></td>
                                                            </tr>";
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit Attendance</button>
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

    <script>
        function confirmAttendance() {
            var confirmation = confirm("Are you sure you want to submit the attendance?");
            return confirmation;
        }
    </script>

</body>

</html>

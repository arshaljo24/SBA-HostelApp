<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        // Process the form submission and store the attendance record in the database

        // Assuming you have already processed and stored the attendance, get the details for confirmation
        $attendanceDate = $_POST['attendance_date'];
        $shift = $_POST['shift'];

        $selectedStudents = [];
        foreach ($_POST['attendance'] as $regNo => $status) {
            if ($status === 'Present') {
                $selectedStudents[] = $regNo;
            }
        }
    } else {
        header("Location: attendance.php"); // Redirect to the attendance page if accessed without form submission
        exit();
    }
} else {
    header("Location: attendance.php"); // Redirect to the attendance page if accessed without form submission
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

    <title>Attendance Confirmation</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
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

                        <h2 class="page-title" style="margin-top:4%">Attendance Confirmation</h2>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    <strong>Success!</strong> Attendance submitted successfully.
                                </div>

                                <h4>Confirmation Details:</h4>
                                <p>
                                    Attendance Date: <?php echo $attendanceDate; ?><br>
                                    Shift: <?php echo $shift; ?>
                                </p>

                                <h4>Students with Present Attendance:</h4>
                                <ul>
                                    <?php
                                    foreach ($selectedStudents as $regNo) {
                                        // Fetch student names and registration numbers from the database
                                        $query = "SELECT firstName, lastName FROM userRegistration WHERE regNo = ?";
                                        $stmt = $mysqli->prepare($query);
                                        $stmt->bind_param('s', $regNo);
                                        $stmt->execute();
                                        $stmt->bind_result($firstName, $lastName);
                                        $stmt->fetch();
                                        $stmt->close();

                                        $fullName = $firstName . ' ' . $lastName;
                                        echo "<li>Reg No: {$regNo}, Name: {$fullName}</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

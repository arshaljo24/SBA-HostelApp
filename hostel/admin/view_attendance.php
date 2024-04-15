<!-- Add these styles in the head section of your HTML -->
<style>
    .absentees-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .absentees-table th, .absentees-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .absentees-table th {
        background-color: #f2f2f2;
    }

    .print-button {
        margin-top: 15px;
    }
</style>

<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['view_attendance'])) {
        // Process the form submission
        $attendanceDate = $_POST['attendance_date'];
        $shift = $_POST['shift'];

        // Fetch absentees for the selected date and shift
        $query = "SELECT regNo, firstName, lastName FROM userRegistration WHERE regNo IN (
                    SELECT regNo FROM attendance WHERE attendanceDate = ? AND shift = ? AND status = '1'
                )";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ss', $attendanceDate, $shift);
        $stmt->execute();
        $result = $stmt->get_result();
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

    <title>View Attendance</title>
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

                        <h2 class="page-title" style="margin-top:4%">View Attendance</h2>

                        <div class="row">
                            <div class="col-md-6">
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="attendance_date">Attendance Date:</label>
                                        <input type="date" name="attendance_date" id="attendance_date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="shift">Shift:</label><br>
                                        <label class="radio-inline"><input type="radio" name="shift" value="Morning" required>Morning</label>
                                        <label class="radio-inline"><input type="radio" name="shift" value="Evening" required>Evening</label>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="view_attendance" class="btn btn-primary">View Attendance</button>
                                    </div>
                                </form>

                                <?php
                                if (isset($result)) {
                                    if ($result->num_rows > 0) {
                                        echo "<h4>Absentees List:</h4>";
                                        echo "<table class='absentees-table'>";
                                        echo "<thead><tr><th>Reg No</th><th>Name</th></tr></thead>";
                                        echo "<tbody>";
                                        while ($row = $result->fetch_assoc()) {
                                            $fullName = $row['firstName'] . ' ' . $row['lastName'];
                                            echo "<tr><td>{$row['regNo']}</td><td>{$fullName}</td></tr>";
                                        }
                                        echo "</tbody></table>";
                                        echo "<button class='btn btn-secondary print-button' onclick='window.print()'>Print</button>";
                                    } else {
                                        echo "<p>No absentees for the selected date and shift.</p>";
                                    }
                                }
                                ?>
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

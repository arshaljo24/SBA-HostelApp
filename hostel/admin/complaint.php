<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

$message = ""; // Initialize an empty message

if (isset($_POST['submit'])) {
    // Retrieve form data
    $regNo = $_POST['regNo'];
    $complaintDescription = $_POST['complaint_description'];
    $dateTime = date('Y-m-d H:i:s');

    // Insert complaint into complaint table
    $insertQuery = "INSERT INTO complaint (regNo, complaint_description, date_time) VALUES (?, ?, ?)";
    $stmtInsert = $mysqli->prepare($insertQuery);

    // Check if prepare was successful
    if (!$stmtInsert) {
        die("Error in prepare statement (insertQuery): " . $mysqli->error);
    }

    $stmtInsert->bind_param('sss', $regNo, $complaintDescription, $dateTime);

    // Execute the query and check for success
    if ($stmtInsert->execute()) {
        $message = "Complaint submitted successfully. <a href='#' class='alert-link'>View submitted complaints</a>";
    } else {
        $message = "Error submitting complaint: " . $stmtInsert->error;
    }

    $stmtInsert->close();
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

    <title>Complaint Management</title>
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

                        <h2 class="page-title" style="margin-top:4%">Complaint Management</h2>

                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="regNo">Registration Number:</label>
                                        <input type="text" name="regNo" id="regNo" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="complaint_description">Complaint Description:</label>
                                        <textarea name="complaint_description" id="complaint_description" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit Complaint</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add your script links here -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>

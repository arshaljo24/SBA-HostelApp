<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Function to get all complaints
function getAllComplaints() {
    global $mysqli;

    $query = "SELECT * FROM complaint";
    $result = $mysqli->query($query);

    $complaints = array();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $complaints[] = $row;
        }
    }

    return $complaints;
}

// Function to close a complaint
function closeComplaint($complaintId) {
    global $mysqli;

    $updateQuery = "UPDATE complaint SET status = 'Closed' WHERE id = ?";
    $stmtUpdate = $mysqli->prepare($updateQuery);

    if (!$stmtUpdate) {
        die("Error in prepare statement (updateQuery): " . $mysqli->error);
    }

    $stmtUpdate->bind_param('i', $complaintId);

    if ($stmtUpdate->execute()) {
        return true;
    } else {
        return false;
    }
}

// Check if the close button is clicked
if (isset($_POST['close'])) {
    $complaintIdToClose = $_POST['complaint_id'];

    if (closeComplaint($complaintIdToClose)) {
        $message = "Complaint closed successfully.";
    } else {
        $error = "Error closing complaint.";
    }
}

$complaints = getAllComplaints();
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

    <title>View Complaints</title>
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

                        <h2 class="page-title" style="margin-top:4%">View Complaints</h2>

                        <?php
                        if (isset($message)) {
                            echo '<div class="alert alert-success">' . $message . '</div>';
                        } elseif (isset($error)) {
                            echo '<div class="alert alert-danger">' . $error . '</div>';
                        }
                        ?>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <!-- Remove the following line for "Complaint ID" column -->
                                            <!-- <th>Complaint ID</th> -->
                                            <th>Registration Number</th>
                                            <th>Complaint Description</th>
                                            <th>Date Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($complaints as $complaint) {
                                            echo '<tr>';
                                            // Remove the following line for "Complaint ID" column
                                            // echo '<td>' . $complaint['id'] . '</td>';
                                            echo '<td>' . $complaint['regNo'] . '</td>';
                                            echo '<td>' . $complaint['complaint_description'] . '</td>';
                                            echo '<td>' . $complaint['date_time'] . '</td>';
                                            echo '<td>' . (isset($complaint['status']) ? $complaint['status'] : 'N/A') . '</td>';
                                            echo '<td>';
                                            if ($complaint['status'] !== 'Closed') {
                                                echo '<form method="post" action="">
                                                        <input type="hidden" name="complaint_id" value="' . $complaint['id'] . '">
                                                        <button type="submit" name="close" class="btn btn-danger">Close</button>
                                                      </form>';
                                            } else {
                                                echo 'Closed';
                                            }
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
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

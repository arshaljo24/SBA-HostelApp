<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
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
    
    <title>DashBoard</title>
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

                        <h2 class="page-title" style="margin-top:4%">Dashboard</h2>

                        <div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body bk-primary text-light">
                        <div class="stat-panel text-center">
                            <?php
                            $result ="SELECT count(*) FROM registration ";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($count);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="stat-panel-number h1 "><?php echo $count;?></div>
                            <div class="stat-panel-title text-uppercase"> Students</div>
                        </div>
                    </div>
                    <a href="manage-students.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body bk-success text-light">
                        <div class="stat-panel text-center">
                            <?php
                            $result1 ="SELECT count(*) FROM rooms ";
                            $stmt1 = $mysqli->prepare($result1);
                            $stmt1->execute();
                            $stmt1->bind_result($count1);
                            $stmt1->fetch();
                            $stmt1->close();
                            ?>
                            <div class="stat-panel-number h1 "><?php echo $count1;?></div>
                            <div class="stat-panel-title text-uppercase">Total Rooms </div>
                        </div>
                    </div>
                    <a href="manage-rooms.php" class="block-anchor panel-footer text-center">See All &nbsp; <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body bk-info text-light">
                        <div class="stat-panel text-center">
                            <?php
                            $result2 ="SELECT count(*) FROM courses ";
                            $stmt2 = $mysqli->prepare($result2);
                            $stmt2->execute();
                            $stmt2->bind_result($count2);
                            $stmt2->fetch();
                            $stmt2->close();
                            ?>
                            <div class="stat-panel-number h1 "><?php echo $count2;?></div>
                            <div class="stat-panel-title text-uppercase">Total Courses</div>
                        </div>
                    </div>
                    <a href="manage-courses.php" class="block-anchor panel-footer text-center">See All &nbsp; <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <!-- New panel for Hostel Leave -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body bk-warning text-light">
                        <div class="stat-panel text-center">
                            <div class="stat-panel-number h1">Hostel Leave</div>
                            <div class="stat-panel-title text-uppercase">Hostel Leave</div>
                        </div>
                    </div>
                    <a href="hostel_leave.php" class="block-anchor panel-footer text-center">Go to Hostel Leave &nbsp;<i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <!-- New panel for Attendance -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body bk-danger text-light">
                        <div class="stat-panel text-center">
                            <div class="stat-panel-number h1">Attendance</div>
                            <div class="stat-panel-title text-uppercase">Attendance</div>
                        </div>
                    </div>
                    <a href="attendance.php" class="block-anchor panel-footer text-center">Go to Attendance &nbsp;<i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <!-- New panel for View Attendance -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body bk-primary text-light">
                        <div class="stat-panel text-center">
                            <div class="stat-panel-number h1">View Attendance</div>
                            <div class="stat-panel-title text-uppercase">View Attendance</div>
                        </div>
                    </div>
                    <a href="view_attendance.php" class="block-anchor panel-footer text-center">Go to Attendance &nbsp;<i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <!-- New panel for Complaint -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body bk-success text-light">
                        <div class="stat-panel text-center">
                            <div class="stat-panel-number h1">Complaint Management</div>
                            <div class="stat-panel-title text-uppercase">Complaint Management</div>
                        </div>
                    </div>
                    <a href="complaint.php" class="block-anchor panel-footer text-center">Complaint Management &nbsp;<i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <!-- New panel for View Complaint -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body bk-info text-light">
                        <div class="stat-panel text-center">
                            <div class="stat-panel-number h1">View Complaint Management</div>
                            <div class="stat-panel-title text-uppercase">View Complaint Management</div>
                        </div>
                    </div>
                    <a href="view_complaints.php" class="block-anchor panel-footer text-center">View Complaint Management &nbsp;<i class="fa fa-arrow-right"></i></a>
                </div>
            </div>


        </div>
    </div>
</div>

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
        window.onload = function(){
            // ... (existing chart scripts)
        }
    </script>

</body>

</html>

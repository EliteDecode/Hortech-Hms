<?php

include ('../includes/connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styling/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../styling/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../styling/admin.css" />
    <link rel="stylesheet" href="../styling/header.css" />
    <title>nav</title>
</head>

<style>
.count {
    border: 1px solid #00c3ff;
    background: #00c3ff;
    font-weight: bolder;
    font-size: 9px;
    border-radius: 100px;
    padding: 0% 5%;
    margin-left: 2%;
    position: absolute;
    color: #fff;
}

.countad {
    border: 1px solid #00c3ff;
    background: #00c3ff;
    font-weight: bolder;
    font-size: 8px;
    border-radius: 100px;
    padding: 0% 2%;
    margin-left: 2%;
    position: absolute;
    color: #fff;
}

.active {
    border: 1px solid #8bc34a;
    background: #8bc34a;
    ;
    font-weight: bolder;
    font-size: 8px;
    border-radius: 100px;
    padding: 0% 2%;
    margin-left: 9%;
    position: absolute;
    color: #fff;
}
</style>

<body>


    <div class="sidenav shadow" style="background-color:#fff; border:none; ">

        <ul>
            <a href="index.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-dashboard" style="margin-right:5%"></i>
                <li>Dashboard</li>

            </a>

            <a href="profile.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-users" style="margin-right:5%"></i>
                <li>Profile</li>

            </a>

            <a href="#" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-calendar" style="margin-right:5%"></i>
                <li>Appointments<?php    

                $user = $_SESSION['patient'];
                $sql = "SELECT * FROM appointments WHERE Username = '$user' AND Stats = 'Delivered'";
                $result = mysqli_query($conn, $sql);

                if ($report = mysqli_num_rows($result)) {
                    $show = "<span class='countad'>$report</span>";
                }else{
                    $show = "";
                }

                echo $show;
                ?>
                </li>

            </a>
            <a href="appointments.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-calendar" style="margin-right:5%"></i>
                <li>Request Appointment
                    <?php    

                $user = $_SESSION['patient'];
                $sql = "SELECT * FROM appointments WHERE Username = '$user' AND Stats = 'Pending'";
                $result = mysqli_query($conn, $sql);

                if ($report = mysqli_num_rows($result)) {
                    $show = "<span class='countad'>$report</span>";
                }else{
                    $show = "";
                }

                echo $show;
                ?>

                </li>

            </a>
            <a href="report.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-flag" style="margin-right:5%"></i>

                <li>Reports
                    <?php    

                $user = $_SESSION['patient'];
                $sql = "SELECT * FROM report WHERE Patient = '$user'";
                $result = mysqli_query($conn, $sql);

                if ($report = mysqli_num_rows($result)) {
                    $show = "<span class='countad'>$report</span>";
                }else{
                    $show = "";
                }

                echo $show;
                ?>
                    <?php    

                $user = $_SESSION['patient'];
                $sql = "SELECT * FROM report WHERE Patient = '$user' AND Feedback != 'Not yet'";
                $result = mysqli_query($conn, $sql);

                if ($report = mysqli_num_rows($result)) {
                    $show = "<span class='active'>$report</span>";
                }else{
                    $show = "";
                }

                echo $show;
                ?>
                </li>

            </a>
            <a href="invoice.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-money" style="margin-right:5%"></i>
                <li>Invoice
                    <?php
                    $sql = "SELECT * FROM invoice WHERE Username = '$user'";

                    $response = mysqli_query($conn,$sql);
                    if ($response = mysqli_num_rows($result)) {
                        $show = "<span class='countad'>$response</span>";
                    }else{
                        $show = "";
                    }
    
                    echo $show;

                    ?>
                </li>

            </a>


        </ul>

    </div>
</body>

</html>
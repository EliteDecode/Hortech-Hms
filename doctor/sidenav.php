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
.gif {
    position: absolute;

}

.gif img {
    width: 12%;
    padding: 1.4%;
    border-radius: 100px;
    border: 2px solid #17a2b8;
    margin-left: -85%;
    margin-top: -8%;
}

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

            <a href="patient.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-bed" style="margin-right:5%"></i>
                <li>Patient
                    <?php

                    $user = $_SESSION['doctor'];
                    $sql = "SELECT * FROM report WHERE Doctor = '$user'";
                    $result = mysqli_query($conn, $sql);

                    if ($active =  mysqli_num_rows($result)) {
                        $show = "<span class='countad'>$active</span>";
                    }else{
                        $show = "";
                    }

                    echo $show;

                    ?>
                </li>

            </a>
            <a href="appointments.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-calendar" style="margin-right:5%"></i>
                <li>Pending Appointments<?php    

                $user = $_SESSION['doctor'];
                $sql = "SELECT * FROM appointments WHERE Doctor = '$user' AND Stats = 'Delivered'";
                $result = mysqli_query($conn, $sql);

                if ($report = mysqli_num_rows($result)) {
                    $show = "<span class='countad'>$report</span>";
                }else{
                    $show = "";
                }

                echo $show;
                ?></li>

            </a>
            <a href="finished_appointments.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-calendar" style="margin-right:5%"></i>
                <li>Closed Appointments<?php    

                $user = $_SESSION['doctor'];
                $sql = "SELECT * FROM appointments WHERE Doctor = '$user' AND Stats = 'Finished'";
                $result = mysqli_query($conn, $sql);

                if ($report = mysqli_num_rows($result)) {
                    $show = "<span class='countad'>$report</span>";
                }else{
                    $show = "";
                }

                echo $show;
                ?></li>

            </a>
            <a href="appointment_request.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-calendar" style="margin-right:5%"></i>
                <li>Appointment Request<?php    

                $user = $_SESSION['doctor'];
                $sql = "SELECT * FROM appointments WHERE Doctor = '$user' AND Stats = 'Pending'";
                $result = mysqli_query($conn, $sql);

                if ($report = mysqli_num_rows($result)) {
                    $show = "<span class='countad'>$report</span>";
                }else{
                    $show = "";
                }

                echo $show;
                ?></li>

            </a>
            <a href="report.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-flag" style="margin-right:5%"></i>

                <li>Report <?php

                $user = $_SESSION['doctor'];
                 $sql = "SELECT * FROM report WHERE Doctor = '$user' And stats= 'Pending'";
                 $result = mysqli_query($conn, $sql);

                 if ($active =  mysqli_num_rows($result)) {
                    $show = "<span class='countad'>$active</span>";
                 }else{
                    $show = "";
                }

                echo $show;

                ?></li>

            </a>
            <a href="documented_report.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-flag" style="margin-right:5%"></i>

                <li>Checked Reports <?php

                $user = $_SESSION['doctor'];
                 $sql = "SELECT * FROM report WHERE Doctor = '$user' AND Stats = 'Delivered'";
                 $result = mysqli_query($conn, $sql);

                 if ($active =  mysqli_num_rows($result)) {
                    $show = "<span class='countad'>$active</span>";
                 }else{
                    $show = "";
                }

                echo $show;

                ?></li>

            </a>
            <a href="message.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-file" style="margin-right:5%"></i>
                <li>Message<?php

                $user = $_SESSION['doctor'];
                $sql = "SELECT * FROM `message` WHERE Reciever = '$user'";
                $result = mysqli_query($conn, $sql);
               
                

                if ($num =mysqli_num_rows($result) != 0) {
                   
                    $show = "<span class='countad'>$num</span>";
                    
                }else{
                    $show = "";
                }

                echo $show;

                ?></li>

            </a>

        </ul>

    </div>
</body>

</html>
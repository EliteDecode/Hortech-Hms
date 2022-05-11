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

.active {
    border: 1px solid #48d494;
    background: #48d494;
    ;
    font-weight: bolder;
    font-size: 8px;
    border-radius: 100px;
    padding: 0% 2%;

    margin-left: 9%;
    position: absolute;
    color: #fff;
}

.gif {
    position: absolute;

}

.gif img {
    width: 12%;
    padding: 1.4%;
    border-radius: 100px;
    border: 2px solid red;
    margin-left: -85%;
    margin-top: -8%;
}


.countad {
    border: 1px solid #00c3ff;
    background: #00c3ff;
    font-weight: bolder;
    font-size: 8px;
    border-radius: 100px;
    padding: 0% 2%;
    margin-left: 1.5%;
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

            <!-- <?php

             $sql = 'SELECT * FROM admin LIMIT 1';

             $result = mysqli_query($conn, $sql);
             $row = mysqli_fetch_assoc($result);

             $username = $row['Username'];

            
             $uname = $_SESSION['admin'];
           
             if (isset($_SESSION['admin'])){

                $uname = $_SESSION['admin'];
                $query = 'SELECT * FROM `admin` ';
                $response = mysqli_query($conn, $query);
                 $num = mysqli_num_rows($response);

                if ($uname == $username) {
                    $show = " <a href='admin.php' style='color: #085e79; font-weight:bolder;'>
                    <i class='fa fa-gears' style='margin-right:5%'></i>
                    <li>Administrator <span class='countad'>$num</span></li>
                            </a>";
                }else{
                 $show = "";
             }

             echo $show;

            }
             ?> -->

            <a href='admin.php' style='color: #085e79; font-weight:bolder;'>
                <i class='fa fa-gears' style='margin-right:5%'></i>
                <li>Administrator <span class='countad'>$num</span></li>
            </a>





            <a href="profile.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-users" style="margin-right:5%"></i>
                <li>Profile</li>

            </a>
            <a href="doctor.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-user-md" style="margin-right:5%"></i>
                <li>Doctors
                    <?php    
                $sql = "SELECT * FROM doctor WHERE Stats = 'approved'";
                $result = mysqli_query($conn, $sql);

                if ($doctors = mysqli_num_rows($result)) {
                    $show = "<span class='countad'>$doctors</span>";
                }else{
                    $show = "";
                }

                echo $show;
                ?>

                    <?php
                 $sql = "SELECT * FROM doctor WHERE Active = 'ONLINE' AND Stats='approved'";
                 $result = mysqli_query($conn, $sql);

                 if ($active =  mysqli_num_rows($result)) {
                    $show = "<span class='active'>$active</span>";
                 }else{
                    $show = "";
                }

                echo $show;

                ?>


                </li>

            </a>
            <a href="patient.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-bed" style="margin-right:5%"></i>
                <li>Patient
                    <?php    
                $sql = "SELECT * FROM patient";
                $result = mysqli_query($conn, $sql);

                if ($patient = mysqli_num_rows($result)) {
                    $show = "<span class='countad'>$patient</span>";
                }else{
                    $show = "";
                }

                echo $show;
                ?>
                    <?php
                 $sql = "SELECT * FROM patient WHERE Active = 'ONLINE' ";
                 $result = mysqli_query($conn, $sql);

                 if ($active =  mysqli_num_rows($result)) {
                    $show = "<span class='active'>$active</span>";
                 }else{
                    $show = "";
                }

                echo $show;

                ?>
                </li>

            </a>
            <a href="report.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-flag" style="margin-right:5%"></i>

                <li>Report <?php
                 $sql = "SELECT * FROM report";
                 $result = mysqli_query($conn, $sql);

                 if ($active =  mysqli_num_rows($result)) {
                    $show = "<span class='gif'><img src = '../images/giphy.gif'/></span>";
                 }else{
                    $show = "";
                }

                echo $show;

                ?></li>

            </a>
            <a href="jobs.php
            " style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-briefcase" style="margin-right:5%"></i>
                <li style="position:relative">Doctor's Request <?php 
                  
                $job = "SELECT * FROM doctor WHERE Stats = 'pending'";
                $result = mysqli_query($conn, $job);

                if ($jobs = mysqli_num_rows($result)) {
                    $show = "<span class='count'>$jobs</span>";
                }else{
                    $show = "";
                }

                echo $show;
                ?>
                </li>

            </a>
            <a href="invoice.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-money" style="margin-right:5%"></i>
                <li>Total Income</li>

            </a>
            <a href="message.php" style="color: #085e79; font-weight:bolder;">
                <i class="fa fa-file" style="margin-right:5%"></i>
                <li>Message
                    <?php

                $user = $_SESSION['admin'];
                $sql = "SELECT * FROM `message` WHERE Reciever = '$user'";
                $result = mysqli_query($conn, $sql);



                if ($num =mysqli_num_rows($result) != 0) {
                
                    $show = "<span class='countad'>$num</span>";
                    
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
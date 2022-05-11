<?php
  session_start();

  if (!isset($_SESSION['admin'])) {
    header('location: adminLogin.php');
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styling/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../styling/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../styling/admin.css" />
    <link rel="stylesheet" href="../styling/header.css" />
    <title>Admin Dashboard</title>
</head>



<body>
    <?php

     include('header.php');
     include('../includes/connect.php');
?>

    <section class="adminIndexWrap container-fluid">
        <div class="row">
            <div class="col-md-2 col-lg-2 col-xl-2" style="margin: 0%; padding: 0%">
                <?php include('sidenav.php')?>
            </div>
            <div class="col-md-10 col-lg-10 col-xl-10" style="background-color: rgba(255, 255, 255, 0.207);">
                <div class="row container" style="display:flex; justify-content:center; align-items:center;">

                    <?php

                        $sql = 'SELECT * FROM admin LIMIT 1';

                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $username = $row['Username'];
                        if (isset($_SESSION['admin'])){

                        $uname = $_SESSION['admin'];

                        $query = 'SELECT * FROM `admin` ';
                        $response = mysqli_query($conn, $query);
                         $num = mysqli_num_rows($response);

                        if ($uname == $username) {
                            echo "  <div class='col-md-3 col-xl-3 col-lg-3 bg-success admin_cards shadow'>
                            <div class='admin_card_title'>
                                <h2>Total</h2>
                                <h2>Admin</h2>
       
                               
                    <h2>$num</h2>
                </div>
                <a href='admin.php'>
                    <div class='admin_card_icon'>
                        <i class='fa fa-gears'></i>
                    </div>
                </a>
            </div>";
            }else{
            echo "<div class='col-md-3 col-xl-3 col-lg-3 bg-success admin_cards shadow'>
                <div class='admin_card_title'>
                    <h2>Admin</h2>
                    <h2>Profile</h2>


                </div>
                <a href='profile.php'>
                    <div class='admin_card_icon'>
                        <i class='fa fa-gears'></i>
                    </div>
                </a>
            </div>";
            }

            }
            ?>


                    <div class="col-md-3 col-xl-3 col-lg-3 bg-info admin_cards shadow">
                        <div class="admin_card_title">
                            <h2>Total</h2>
                            <h2>Doctors</h2>
                            <?php    
                            $sql = "SELECT * FROM doctor WHERE Stats = 'approved'";
                            $result = mysqli_query($conn, $sql);

                            if ($doctors = mysqli_num_rows($result)) {
                                $show = " <h2>$doctors</h2>";
                            }else{
                                $show = " <h2>0</h2>";
                            }

                            echo $show;
                            ?>

                        </div>
                        <a href="doctor.php">
                            <div class="admin_card_icon">
                                <i class="fa fa-user-md"></i>
                            </div>
                        </a>

                    </div>
                    <div class="col-md-3 col-xl-3 col-lg-3 bg-warning admin_cards shadow">
                        <div class="admin_card_title">
                            <h2>Total</h2>
                            <h2>Patient</h2>
                            <?php    
                            $sql = "SELECT * FROM patient";
                            $result = mysqli_query($conn, $sql);

                            if ($patient = mysqli_num_rows($result)) {
                                $show = "<h2>$patient</h2>";
                            }else{
                                $show = "<h2>0</h2>";
                            }

                            echo $show;
                              ?>

                        </div>
                        <a href="patient.php">
                            <div class="admin_card_icon">
                                <i class="fa fa-bed"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xl-3 col-lg-3 bg-dark admin_cards2 shadow">
                        <div class="admin_card_title">
                            <h2>Total</h2>
                            <h2>Report</h2>\
                            <h2>0</h2>
                        </div>
                        <div class="admin_card_icon">
                            <i class="fa fa-flag"></i>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-3 col-lg-3 bg-danger admin_cards2 shadow">

                        <div class="admin_card_title">
                            <h2>Job</h2>
                            <h2>Request</h2>

                            <?php 
                             $job = "SELECT * FROM doctor WHERE Stats = 'pending'";
                             $result = mysqli_query($conn, $job);
 
                             if ($jobs = mysqli_num_rows($result)) {
                             $show = "<h2>$jobs</h2>";
                             }else{
                             $show = " <h2>0</h2>";
                             }
 
                             echo $show;
                             ?>


                        </div>
                        <a href="jobs.php">
                            <div class="admin_card_icon">
                                <i class="fa fa-briefcase"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xl-3 col-lg-3 bg-success admin_cards2 shadow">
                        <div class="admin_card_title">
                            <h2>Total</h2>
                            <h2>income</h2>
                            <h2><i class="fa fa-euro"></i>0000</h2>
                        </div>
                        <div class="admin_card_icon">
                            <i class="fa fa-money"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
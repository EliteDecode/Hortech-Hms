<?php
  session_start();
  include('../includes/connect.php');

  if (!isset($_SESSION['patient'])) {
    
    header('location: patientlogin.php');
  }elseif (isset($_SESSION['patient'])) {
      $un = $_SESSION['patient'];
      $date =date("jS M Y H:i:s"); 
      $sql = "UPDATE patient SET Active ='ONLINE', loginTime = '$date', logoutTime = '' WHERE Username = '$un'";
      $result = mysqli_query($conn, $sql);
 
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
    <title>Patient Dashboard</title>
</head>



<body>
    <?php

     include('header.php');
    
?>

    <section class="adminIndexWrap container-fluid">
        <div class="row">
            <div class="col-md-2 col-lg-2 col-xl-2" style="margin: 0%; padding: 0%">
                <?php include('sidenav.php')?>
            </div>
            <div class="col-md-10 col-lg-10 col-xl-10" style="background-color: rgba(255, 255, 255, 0.207);">
                <div class="row container" style="display:flex; justify-content:center; align-items:center;">

                    <div class='col-md-3 col-xl-3 col-lg-3 bg-success admin_cards shadow'>
                        <div class='admin_card_title'>
                            <h2>My</h2>
                            <h2>Profile</h2>
                        </div>
                        <a href='profile.php'>
                            <div class='admin_card_icon'>
                                <i class='fa fa-user-circle'></i>
                            </div>
                        </a>
                    </div>


                    <div class="col-md-3 col-xl-3 col-lg-3 bg-info admin_cards shadow">
                        <div class="admin_card_title">
                            <h2>Total</h2>
                            <h2>Invoice</h2>
                            <h2>0</h2>

                        </div>
                        <a href="doctor.php">
                            <div class="admin_card_icon">
                                <i class="fa fa-money"></i>
                            </div>
                        </a>

                    </div>
                    <div class="col-md-3 col-xl-3 col-lg-3 bg-warning admin_cards shadow">
                        <div class="admin_card_title">
                            <h2>Appointment</h2>
                            <h2>Request</h2>
                            <?php    

                            $user = $_SESSION['patient'];
                            $sql = "SELECT * FROM appointments WHERE Username = '$user' AND Stats = 'Pending'";
                            $result = mysqli_query($conn, $sql);

                            if ($report = mysqli_num_rows($result)) {
                                $show = "<h2>$report</h2>";
                            }else{
                                $show = " <h2>0</h2>";
                            }

                            echo $show;
                            ?>

                        </div>
                        <div class="admin_card_icon">
                            <i class="fa fa-calendar" style="margin-left:80%"></i>
                        </div>
                    </div>


                    <div class="col-md-3 col-xl-3 col-lg-3 bg-primary admin_cards2 shadow">
                        <div class="admin_card_title">
                            <h2>Booked</h2>
                            <h2>Appointment</h2>
                            <?php    

                            $user = $_SESSION['patient'];
                            $sql = "SELECT * FROM appointments WHERE Username = '$user' AND Stats = 'Delivered'";
                            $result = mysqli_query($conn, $sql);

                            if ($report = mysqli_num_rows($result)) {
                                $show = "<h2>$report</h2>";
                            }else{
                                $show = " <h2>0</h2>";
                            }

                            echo $show;
                            ?>

                        </div>
                        <div class="admin_card_icon">
                            <i class="fa fa-calendar-o" style="margin-left:80%"></i>
                        </div>
                    </div>


                    <div class="col-md-3 col-xl-3 col-lg-3 bg-dark admin_cards2 shadow">
                        <div class="admin_card_title">
                            <h2>Total</h2>
                            <h2>Report</h2>
                            <?php    

                            $user = $_SESSION['patient'];
                            $sql = "SELECT * FROM report WHERE Patient = '$user'";
                            $result = mysqli_query($conn, $sql);

                            if ($report = mysqli_num_rows($result)) {
                                $show = "  <h2>$report</h2>";
                            }else{
                                $show = "  <h2>0</h2>";
                            }

                            echo $show;
                            ?>

                        </div>
                        <a href="report.php">
                            <div class="admin_card_icon">
                                <i class="fa fa-flag"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-xl-3 col-lg-3 bg-info admin_cards2 shadow">
                        <div class="admin_card_title">
                            <h2>Message</h2>
                            <h2>Box</h2>
                            <?php    

                        $user = $_SESSION['patient'];
                        $sql = "SELECT * FROM report WHERE Patient = '$user' AND Feedback != 'Not yet'";
                        $result = mysqli_query($conn, $sql);

                        if ($report = mysqli_num_rows($result)) {
                            $show = "<h2>$report</h2>";
                        }else{
                            $show = "  <h2>0</h2>";
                        }

                        echo $show;
                        ?>

                        </div>
                        <a href="report.php">
                            <div class="admin_card_icon">
                                <i class="fa fa-file"></i>
                            </div>
                        </a>
                    </div>




                </div>
            </div>
        </div>
    </section>
</body>

</html>
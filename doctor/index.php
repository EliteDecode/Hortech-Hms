<?php
  session_start();
  include('../includes/connect.php');

  if (!isset($_SESSION['doctor'])) {
    
    header('location: doctorlogin.php');
  }elseif (isset($_SESSION['doctor'])) {
      $un = $_SESSION['doctor'];
      $date =date("jS M Y H:i:s"); 
      $sql = "UPDATE doctor SET Active ='ONLINE', loginTime = '$date', logoutTime = '' WHERE Username = '$un'";
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
    <title>Doctor Dashboard</title>


    <style>
    .gif {
        position: absolute;

    }

    .giffy img {
        width: 25%;
        padding: 4%;
        border-radius: 100px;
        border: 2px solid #17a2b8;
        margin-left: 10%;
        margin-top: -8%;
    }

    .available {
        margin-top: 1%;
    }

    .available .details {
        margin-left: 8%;
        color: #085e79;
    }

    .available .details button {
        margin-bottom: 1%;
    }

    .admin_cards {
        margin-top: 2% !important;
    }
    </style>

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
            <div class="col-md-10 col-lg-10 col-xl-10"
                style="background-color: rgba(255, 255, 255, 0.207); position:relative">
                <div class="row container" style="display:flex; justify-content:center; align-items:center;">

                    <div class="available col-12">
                        <div class="details">
                            <?php
                                 $user = $_SESSION['doctor'];

                                 $sql = "SELECT * FROM doctor WHERE Username = '$user'";
                                 $result = mysqli_query($conn,$sql);

                                 $row = mysqli_fetch_assoc($result);
                                 $aa = $row['Available'];
                                 if ($aa == 'no') {
                                    $show = "Currently Busy, No Appointment can be made";
                                    $color = '#f23a2e';
                                 }elseif ($aa == 'yes'){
                                    $show = "Currently Available, Appointments can be made";
                                    $color=' #8bc34a';
                                 }
                            ?>
                            <h6>Available for appointments?</h6>
                            <button class="btn btn-info" onclick='available(this)' id='<?php echo $user ?>'>Yes</button>
                            <button class="btn btn-primary" onclick='busy(this)' id='<?php echo $user ?>'>No</button>
                            <h6>Status: <span id='msg' style='color:<?php echo $color ?>'><?php echo $show ?></span>
                            </h6>
                        </div>
                    </div>

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
                            <h2>Patient</h2>
                            <h2>0</h2>

                        </div>
                        <a href="doctor.php">
                            <div class="admin_card_icon">
                                <i class="fa fa-bed"></i>
                            </div>
                        </a>

                    </div>
                    <div class="col-md-3 col-xl-3 col-lg-3 bg-warning admin_cards shadow">
                        <div class="admin_card_title">
                            <h2>Pending</h2>
                            <h2>Appointment</h2>
                            <?php    

                            $user = $_SESSION['doctor'];
                            $sql = "SELECT * FROM appointments WHERE Doctor = '$user' AND Stats = 'Delivered'";
                            $result = mysqli_query($conn, $sql);

                            if ($report = mysqli_num_rows($result)) {
                                $show = "<h2>$report</h2>";
                            }else{
                                $show = " <h2>0</h2>";
                            }

                            echo $show;
                            ?>

                        </div>
                        <a href="appointment_request.php">
                            <div class="admin_card_icon">
                                <i class="fa fa-calendar" style="margin-left:80%"></i>
                            </div>
                        </a>
                    </div>


                    <div class="col-md-3 col-xl-3 col-lg-3 bg-primary admin_cards2 shadow">
                        <div class="admin_card_title">
                            <h2>Appointment</h2>
                            <h2>Request</h2>
                            <?php    

                            $user = $_SESSION['doctor'];
                            $sql = "SELECT * FROM appointments WHERE Doctor = '$user' AND Stats = 'Pending'";
                            $result = mysqli_query($conn, $sql);

                            if ($report = mysqli_num_rows($result)) {
                                $show = "<h2>$report</h2>";
                            }else{
                                $show = " <h2>0</h2>";
                            }

                            echo $show;
                            ?>

                        </div>

                        <a href="appointments.php">
                            <div class="admin_card_icon">
                                <i class="fa fa-calendar-o" style="margin-left:80%"></i>
                            </div>
                        </a>
                    </div>


                    <div class="col-md-3 col-xl-3 col-lg-3 bg-dark admin_cards2 shadow">
                        <div class="admin_card_title">
                            <h2>Total</h2>
                            <h2>Report</h2>
                            <?php

                            $user = $_SESSION['doctor'];
                            $sql = "SELECT * FROM report WHERE Doctor = '$user'";
                            $result = mysqli_query($conn, $sql);

                            if ($active =  mysqli_num_rows($result)) {
                                $show = " <h2>$active</h2>";
                            }else{
                                $show = " <h2>0</h2>";
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

                        $user = $_SESSION['doctor'];
                        $sql = "SELECT * FROM `message` WHERE Reciever = '$user'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                       
                        

                        if ($num =mysqli_num_rows($result) != 0) {
                   
                            $show = "<h2>$num</h2>";
                            
                        }else{
                            $show = "<h2>0</h2>";
                        }
        
                        echo $show;

                        ?>

                        </div>
                        <a href="message.php">
                            <div class="admin_card_icon">
                                <i class="fa fa-file"></i>
                            </div>
                        </a>
                    </div>




                </div>
            </div>
        </div>
    </section>




    <script>
    function busy(e) {
        var busy_id = e.id;

        var busy = new XMLHttpRequest();

        var method = 'POST';
        var url = "../admin/ajax/ajax_doctor_busy.php";
        var vars = "username=" + busy_id;



        console.log(vars);
        busy.open(method, url, true);

        busy.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        busy.onreadystatechange = function() {
            if (busy.readyState == 4 && busy.status == 200) {
                var data = busy.responseText;
                console.log(data);
                document.getElementById('msg').innerHTML = data;

            }
        }

        busy.send(vars);
    }

    function available(e) {
        var available_id = e.id;

        var available = new XMLHttpRequest();

        var method = 'POST';
        var url = "../admin/ajax/ajax_doctor_available.php";
        var vars = "username=" + available_id;



        console.log(vars);
        available.open(method, url, true);

        available.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        available.onreadystatechange = function() {
            if (available.readyState == 4 && available.status == 200) {
                var data = available.responseText;
                console.log(data);
                document.getElementById('msg').innerHTML = data;

            }
        }

        available.send(vars);
    }
    </script>
</body>

</html>
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
    <title>Doctors</title>

    <style>
    .available {
        margin-top: 10%;
    }

    .available .details {
        margin-left: 3%;
        color: #085e79;
        box-shadow: 2px 4px 13px #008cba;
        width: 50%;
        padding: 3% 3%;
        margin-top: 10%;
    }

    .available .details button {
        margin-bottom: 1%;
    }

    .report_form {
        box-shadow: 2px 4px 13px #008cba;
    }

    .button {
        font-weight: bold;
    }

    .doctorscard {

        height: 470px;
        width: 80%;
        margin: -3% 0% 0% 5%;
        padding: 5% 5%;
    }

    .img {

        height: 120px;
        width: 50%;
        border-radius: 100%;
        margin-bottom: 5%;
    }

    .doctorscard h6,
    #add_form h6 {
        color: #085e79;
        margin-bottom: 6%;
        font-weight: 600;
    }

    .doctorscard h6 span {
        font-weight: bolder;
        margin-left: 2%;
        font-size: 14px;
    }

    .salary_form {
        width: 90%;
        margin: 20% 0% 0% 0%;
        padding: 4% 4%;
        box-shadow: 2px 4px 13px #008cba;
    }

    .send_form {
        width: 90%;
        margin: 20% 0% 0% 0%;
        padding: 4% 4%;
        box-shadow: 2px 4px 13px #008cba;
        position: relative;

    }


    .salary_form h6 {
        color: #085e79;
    }

    .form-group label {
        color: #085e79;
    }

    .form-group input {
        font-size: 14px;
        font-weight: bolder;
        color: #085e79;
    }

    .status {
        box-shadow: 2px 4px 13px #008cba;
        margin-top: 20%;
        width: 90%;
        padding: 4% 5%;
        height: 150px;
    }

    .status h6 {
        color: #17a2b8;
    }

    .status .online {
        color: #48d494;
        font-weight: bold;
        ;
    }

    .status .offline {
        color: #6c757d;
        font-weight: bold;
        ;
    }

    #add_form {
        box-shadow: 2px 4px 13px #008cba;
        width: 50%;
        padding: 3% 3%;
        margin-top: 10%;
        margin-left: 5%;
    }
    </style>
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
            <div class="col-md-10 col-lg-10 col-xl-10"
                style="background-color: rgba(255, 255, 255, 0.207); position:relative ">

                <div class="row">

                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-4">

                        <div class="doctorscard">



                            <?php
                            $user = $_SESSION['doctor'];
                          if (isset($_GET['view'])) {
                              $id = $_GET['view'];

                              $sql = "SELECT * FROM appointments WHERE id = $id";
                              $result = mysqli_query($conn,$sql);

                              while($row = mysqli_fetch_assoc($result)){
                                $Patientid = $row['Patientid'];
                                $Passport = $row['Passport'];
                                $Firstname = $row['Firstname'];
                                $Lastname = $row['Lastname'];
                                $Username = $row['Username'];
                                $Gender = $row['Gender'];
                                $Email = $row['Email'];
                                $Dateapp = $row['DateApp'];
                                $Datebooked = $row['DateBooked'];
                                $title=$row['Title'];
                                $reason = $row['Reason'];
                                
                               
                               

                                echo "
                                <div class='img'>
                                <img src='../doctor/images/$Passport' alt='' style='border-radius:100%; width:100%; height:120px'>
                                </div>
                                <h6>Patient's Id: <span>$Patientid</span></h6>
                                <h6>Firstname:<span>$Firstname</span></h6>
                                <h6>Lastname:<span>$Lastname</span></h6>
                                <h6>Username:<span>$Username</span></h6>
                                
                                <h6>Email :<span>$Email</span></h6>
                                <h6>Gender:<span>$Gender</span></h6>
                                <h6>Title of Appointment:<span>$title</span></h6>
                                <h6> Reason for Appointments:<span>$reason</span></h6>
                                <h6>Application of Application:<span>$Dateapp</span></h6>
                                <h6>Application Date:<span>$Datebooked</span></h6>";
                                
                               
                              }
                          }
                        ?>

                        </div>
                    </div>


                    <div class="col-md-8 col-lg-8 col-xl-8">
                        <button class="btn btn-info "
                            style="margin: 3% 0% 5% 5%; position:absolute;font-weight:bold; font-size:14px"
                            id="add_btn">
                            View Patient Invoice
                        </button>
                        <button class="btn btn-primary "
                            style="margin: 3% 0% 5% 30%; position:absolute;font-weight:bold; font-size:14px"
                            id="view_details">
                            Status of Patient
                        </button>
                        <div class="available col-12" style='display:none' id='details'>
                            <div class="details">

                                <h6>Status: <span id='msg' style='color:#8bc34a;'>Patient Discharged</span>
                                    <?php
                                 $user = $_SESSION['doctor'];

                                 $sql = "SELECT * FROM appointments WHERE Doctor = '$user' AND Title = '$title'";
                                 $result = mysqli_query($conn,$sql);

                                 
                                 while($row = mysqli_fetch_assoc($result)){
                                     $date = $row['DateFinished'];
                                 }
                            ?>
                                    <h6>Discharged date: <span id='msg'
                                            style='color:#8bc34a;'><?php echo $date ?></span>
                                    </h6>
                            </div>
                        </div>


                        <div id='add_form' style="display:none">
                            <?php

                                        
                    $user = $_SESSION['doctor'];
                    $id = $_GET['view'];
                    $sql = "SELECT * FROM invoice WHERE Doctor = '$user' AND Title = '$title'";
                    $result = mysqli_query($conn, $sql);

                    while($row = mysqli_fetch_assoc($result)){
                            $fee = $row['fee'];
                            $descrip = $row['Descrip'];
                            echo "   
                            <h6 style='font-weight:bolder'>Fee: <span style='font-weight:lighter'> $fee </span> </h6>
                            <h6 style='font-weight:bolder'>Title: <span style='font-weight:lighter'>
                                     $title
                                </span> </h6>
                            <h6 style='font-weight:bolder'>Description: <span style='font-weight:lighter'>$descrip</span> </h6>
                            ";
                            }
                            ?>

                        </div>











                    </div>
                </div>
            </div>
        </div>
    </section>




    <script>
    document.getElementById('add_btn').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = " block"
        var addForm = document.getElementById('details').style.display = " none"
    })


    document.getElementById('view_details').addEventListener('click', e => {
        var addForm = document.getElementById('details').style.display = " block"
        var addForm = document.getElementById('add_form').style.display = "none"
    })
    </script>
</body>

</html>
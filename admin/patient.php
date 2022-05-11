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
    .wrap_doctor {
        width: 40%;
        margin-top: -28%;
        float: right;
        z-index: 222 !important;

    }

    .wrap_doctor form {
        position: relative;
        width: 80%;
        margin: 0% 0% 0% 20%;
        padding: 3% 4%;
        z-index: 222 !important;
        background-color: #fff;
        box-shadow: 2px 4px 13px #008cba;
        border-radius: 10px;
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
                <div id="msg"></div>

                <?php 
                     

                    include_once('../includes/connect.php');

                    $sql = "SELECT * FROM patient ORDER BY DateReg ASC";

                    $result = mysqli_query($conn, $sql);


                    $output = "";

                    $output .= "<table class='table table-bordered   text-center' style='z-index:0;margin-top:5%; color:#085e79;'>
                                <tr> 
                                <th style='font-size:13px'>Status</th>
                                <th style='font-size:13px'>Firstname</th>
                                <th style='font-size:13px'>Lastname</th>
                                <th style='font-size:13px'>Username</th>
                             
                                
                                <th style='font-size:13px'>Email</th>
                                
                            
                                <th style='font-size:13px'>Action</th>
                                
                                
                                </tr>";

                    if (mysqli_num_rows($result) < 1) {
                        $output .= "<tr><td colspan='11'>No Patient currently.</td></tr>";
                    }elseif (mysqli_num_rows($result)) {
                        while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $patientid = $row['Patientid'];
                            $Firstname = $row['Firstname'];
                            $Lastname = $row['Lastname'];
                            $Username = $row['Username'];
                            $Gender = $row['Gender'];
                            $Passport = $row['Passport'];
                            $Email = $row['Email'];
                            $DateReg = $row['DateReg'];
                            $active = $row['Active'];

                            
                            
                            $output .= "<tr> 
                                        <td style='font-size:12px; font-weight:600; color:#00c3ff;'>$active</td>
                                        <td style='font-size:12px; font-weight:600;'>$Firstname</td>
                                        <td style='font-size:12px; font-weight:600;'>$Lastname</td>
                                        <td style='font-size:12px; font-weight:600;'>$Username</td>
                                        <td style='font-size:12px; font-weight:600;'>$Email</td>
                                        <td font-weight:600;'>
                                        <a href='viewpatient.php?editid=$id'><button class='btn btn-success text-white' style='font-size:12px;
                                        font-weight:bold;'>View</button></a>
                                        </td>"
                                        ;
                        }
                    }

                    $output .= "</tr>
                                </table>";
                    echo $output;
                    ?>
            </div>
        </div>
    </section>




    <script>

    </script>
</body>

</html>
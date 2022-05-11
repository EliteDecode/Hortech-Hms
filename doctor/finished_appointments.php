<?php
  session_start();

  if (!isset($_SESSION['doctor'])) {
    header('location: doctorlogin.php');
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
    <title> Doctors Appointment</title>

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
                 $user = $_SESSION['doctor'];

                 $sql = "SELECT * FROM appointments WHERE Stats='Finished' AND Doctor = '$user' ORDER BY DateFinished ASC";

                $result = mysqli_query($conn, $sql);


                   
                    $output = "";

                    $output .= "<table class='table table-bordered shadow  text-center' style='margin-top:2%; color:#085e79;'>
                                <tr> 
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Username</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th >Date Of Appointment</th>
                                <th >Date Of Booking</th>
                                <th>Action</th>
                                
                                
                                </tr>";

                    if (mysqli_num_rows($result) < 1) {
                        $output .= "<tr><td colspan='9'>No Application Request.</td></tr>";
                    }elseif (mysqli_num_rows($result)) {
                        while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $Firstname = $row['Firstname'];
                            $Lastname = $row['Lastname'];
                            $Username = $row['Username'];
                            $Gender = $row['Gender'];
                            $Email = $row['Email'];

                            $Dateapp = $row['DateApp'];
                            $Datebook = $row['DateBooked'];


                            $output .= "<tr> 
                                        <td style='font-size:14px; font-weight:600;'>$Firstname</td>
                                        <td style='font-size:14px; font-weight:600;'>$Lastname</td>
                                        <td style='font-size:14px; font-weight:600;'>$Username</td>
                                        <td>$Gender</td>
                                        
                                        <td style='font-size:14px; font-weight:600;'>$Email</td>
                                        <td style='font-size:14px; font-weight:600;'>$Dateapp</td>
                                        <td style='font-size:14px; font-weight:600;'>$Datebook</td>
                                        <td font-weight:bold;'>
                                        <a href='view_finished_appointments.php?view=$id'>
                                        <button class='btn btn-success text-white' style='font-size:12px;
                                        font-weight:bold;'>View</button></a>
                                        </td>
                                        
                                        </tr>";

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
    function finish(e) {
        var finish_id = e.id;


        var vars = "finish_id=" + finish_id;

        var finish = new XMLHttpRequest();

        var method = "POST";
        var url = "../admin/ajax/ajax_finished_appointment.php";
        var sync = true;

        finish.open(method, url, sync);

        finish.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        finish.onreadystatechange = function() {
            if (finish.readyState == 4 && finish.status == 200) {
                var data = finish.responseText;
                console.log(data);
                document.getElementById('msg').innerHTML = data;

            }
        }

        finish.send(vars);

    }
    </script>
</body>

</html>
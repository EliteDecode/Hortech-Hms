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

                    $user = $_SESSION['doctor'];

                    $sql = "SELECT * FROM report WHERE Doctor = '$user' And Stats = 'Delivered' ORDER BY DateReg ASC";

                    $result = mysqli_query($conn, $sql);

                 


                    $output = "";

                    $output .= "<table class='table table-bordered   text-center' style='z-index:0;margin-top:5%; color:#085e79;'>
                                <tr> 
                                <th style='font-size:13px'>Patient Username</th>
                                <th style='font-size:13px'>Title</th>
                                <th style='font-size:13px'>Date of Report</th> 
                                <th style='font-size:13px'>Action</th>
                                
                                
                                </tr>";

                    if (mysqli_num_rows($result) < 1) {
                        $output .= "<tr><td colspan='11'>No Checked Report currently.</td></tr>";
                    }elseif (mysqli_num_rows($result)) {
                        while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $patient = ucfirst($row['Patient']);
                            $doctor = $row['Doctor'];
                            $title = $row['Title'];
                            $date = $row['DateReg'];
                            
                            $val = $row['Stats'];

                          
                            
                            
                            $output .= "<tr> 
                                        <td style='font-size:12px; font-weight:bolder;'>$patient</td>
                                      
                                        <td style='font-size:12px; font-weight:bold;'>$title</td>
                                        <td style='font-size:12px; font-weight:bold;'>$date</td>
                                       
                                        <td font-weight:bold;'>
                                        <a href='viewreport.php?editid=$patient'>
                                        <button class='btn btn-success text-white' style='font-size:12px;
                                        font-weight:bold;'>View</button></a>
                                        <button class='btn btn-info text-white' style='font-size:12px;
                                        font-weight:bold; 
                                        id='$id' onclick='seen(this)' >Seen</button>
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
    function seen(e) {
        var seen_id = e.id;

        var seen_report = new XMLHttpRequest();

        var method = 'POST';
        var url = "../admin/ajax/ajaxseen_report.php";
        var vars = "username=" + seen_id;



        console.log(vars);
        seen_report.open(method, url, true);

        seen_report.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        seen_report.onreadystatechange = function() {
            if (seen_report.readyState == 4 && seen_report.status == 200) {
                var data = seen_report.responseText;


            }
        }

        seen_report.send(vars);



    }
    </script>
</body>

</html>
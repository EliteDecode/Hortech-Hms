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
    <title> Admin Doctors</title>

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

                    $sql = "SELECT * FROM doctor WHERE Stats='approved' ORDER BY DateReg ASC";

                    $result = mysqli_query($conn, $sql);


                    $output = "";

                    $output .= "<table class='table table-bordered   text-center' style='z-index:0;margin-top:5%; color:#085e79;'>
                                <tr> 
                                <th style='font-size:13px'>Status</th>
                                <th style='font-size:13px'>Firstname</th>
                                <th style='font-size:13px'>Lastname</th>
                                <th style='font-size:13px'>Username</th>
                             
                                
                                <th style='font-size:13px'>Email</th>
                                <th style='font-size:13px' >Salary</th>
                            
                                <th style='font-size:13px'>Action</th>
                                
                                
                                </tr>";

                    if (mysqli_num_rows($result) < 1) {
                        $output .= "<tr><td colspan='11'>No Registered Doctor.</td></tr>";
                    }elseif (mysqli_num_rows($result)) {
                        while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $doctorid = $row['Doctorid'];
                            $Firstname = $row['Firstname'];
                            $Lastname = $row['Lastname'];
                            $Username = $row['Username'];
                            $Gender = $row['Gender'];
                            $Passport = $row['Passport'];
                            $Resume = $row['Cv'];
                            $Email = $row['Email'];
                            $DateReg = $row['DateReg'];
                            $salary = $row['Salary'];
                            $active = $row['Active'];

                            if ($active == 'ONLINE') {
                               $color = '#00c3ff';
                            }else{
                                $color='#6c757d';
                            }

                            
                            
                            $output .= "<tr> 
                                        <td style='font-size:12px; font-weight:bold; color:$color;'>$active</td>
                                        <td style='font-size:12px; font-weight:bold;'>$Firstname</td>
                                        <td style='font-size:12px; font-weight:bold;'>$Lastname</td>
                                        <td style='font-size:12px; font-weight:bold;'>$Username</td>
                                      
                                        
                                        <td style='font-size:12px; font-weight:bold;'>$Email</td>
                                        <td style='font-size:12px; font-weight:bold;'><i class='fa fa-euro'></i>&nbsp$salary</td>
                                        
                                        <td font-weight:bold;'>
                                        <a href='edit.php?editid=$id'><button class='btn btn-success text-white' style='font-size:12px;
                                        font-weight:bold;'>View</button></a>
                                        </td>
                                        <td ><button class='btn btn-danger' onclick='remove(this)'
                                         id='$id' style='font-size:12px; font-weight:bold;'>Delete</button></td>
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
    function remove(e) {
        var remove_id = e.id;


        var vars = "remove_id=" + remove_id;

        var remove = new XMLHttpRequest();

        var method = "POST";
        var url = "ajax/ajaxremove.php";
        var sync = true;

        remove.open(method, url, sync);

        remove.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        remove.onreadystatechange = function() {
            if (remove.readyState == 4 && remove.status == 200) {
                var data = remove.responseText;
                console.log(data);
                document.getElementById('msg').innerHTML = data;

            }
        }

        remove.send(vars);

    }
    </script>
</body>

</html>
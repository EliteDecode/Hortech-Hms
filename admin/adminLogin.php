<?php

session_start();
 include ('../includes/connect.php');
 

 
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
    <title>Admin Login</title>
</head>

<style>
.adminLoginBgImg {
    height: 440px;
    width: 75%;
    margin-left: 15%;
    background: url("../images/doctor.svg");
    background-size: 100% 100%;
}
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white text-dark">
        <div class="navbar-brand">
            <img src="../images/logo.png" alt="logo" style="width: 45%; height:70px; margin-top:-3%" />
            <h4>
                Hortech <span style="color: #00c3ff; font-family: segoe ui">HMS</span>
            </h4>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav" style="justify-content: flex-end">
            <ul class="navbar-nav" style="margin-right: 10%; margin-top: -0.5%">
                <li class="nav-item">
                    <a href="../home.php" class="nav-link">Home</a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link">Admin</a>
                </li>
                <li class="nav-item">
                    <a href="../doctor/doctorlogin.php" class="nav-link">Doctor</a>
                </li>
                <li class="nav-item">
                    <a href="../patient/patientlogin.php" class="nav-link">Patient</a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="admin_wrap container-fluid">
        <div class="row">
            <div class="col-md-7 col-xl-7 col-lg-7">
                <div class="adminLoginBgImg"></div>
            </div>
            <div class="col-md-5 col-xl-5 col-lg-5">

                <!---Php script for login-->

                <?php
             
             if (isset($_POST['submit'])) {
              $username = $_POST['username'];
              $password = $_POST['password'];

              
            
              $error = array();
            
              if (empty($username)) {
                $error['admin'] = 'Provide your Admin Username';
              }elseif (empty($password)) {
               $error['admin'] = 'Provide your Admin Password';
              }elseif (empty($username) && empty($password)) {
                $error['admin'] = 'Provide your Admin Username and Password';
              }
            
              if (count($error)==0) {
                 $query = "SELECT * FROM `admin` WHERE Username = '$username' AND Pwd = '$password'";
                 $result = mysqli_query($conn, $query);
            
                 if (mysqli_num_rows($result) == 1) {
                   $_SESSION['admin'] = $username;
                   header('location: index.php');
                   exit();
                 }else{
                   $show = '
                   <script>
                   function hide(){
                      var error = document.getElementById("error").style.display="none";
                   }
                   setTimeout("hide()", 3000)
                   </script>
                   
                   <div style="top:10%; position:absolute;" id="error"><h6 class="alert alert-danger" >Admin Record not found</h6></div>';
                 }
            
                 echo $show;
              }
            
            
            
            
            }
                    ?>
                <!-- error display -->

                <?php 
                         if (isset($error['admin'])) {
                            $er = $error['admin'];
                            $display = ' <script>
                            function hide(){
                               var error = document.getElementById("error").style.display="none";
                            }
                            setTimeout("hide()", 3000)
                            </script>
                            
                            <div style="top:10%; position:absolute;" id="error">
                            <h6 class="alert alert-danger" >'.$er.'</h6></div>';

                         }else{
                             $display = '';
                         }

                         echo $display
                        
                        ?>

                <form method="post" enctype="multipart/form-data" class="adminLoginForm">

                    <div class="form-group">
                        <label for="username">Admin Username</label>
                        <input type="text" name="username" class="form-control"
                            value="<?php echo isset($_POST["submit"]) ? $_POST["username"] : '';?>"
                            placeholder="Your Admin username..." />
                    </div>
                    <div class="form-group">
                        <label for="password">Admin Password</label>
                        <input type="password" name="password" class="form-control"
                            value="<?php echo isset($_POST["submit"]) ? $_POST["username"] : '';?>"
                            placeholder="Your Admin password..." />
                    </div>

                    <button class="btn text-white" style="
                background-color: #0066ff;
                font-size: 14px;
                font-weight: bold;
              " name="submit">
                        LOGIN
                    </button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
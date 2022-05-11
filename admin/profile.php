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

<body>
    <?php
        include ('header.php');
     ?>

    <section class="adminIndexWrap container-fluid">
        <div class="row">
            <div class="col-md-2 col-lg-2 col-xl-2" style="margin: 0%; padding: 0%">
                <?php include('sidenav.php')?>
            </div>
            <div class="col-md-10 col-lg-10 col-xl-10">
                <div class="row">
                    <div class="col-md-5 col-lg-5 col-xl-5 col-sm-12">
                        <div class="profile_board shadow "
                            style="height:300px; width:90%; margin:25% 0% 0% 10%; padding:4% 4%; ">
                            <h3 class="text-center"
                                style="font-size:16px; text-transform:uppercase; color:#085e79;font-weight:bolder;">
                                Admin Profile
                                Board</h3>

                            <?php
                                    $ad = $_SESSION['admin'];
                                     $sql = "SELECT * FROM admin WHERE Username = '$ad'";
                                     $result = mysqli_query($conn,$sql);

                                     while ($row = mysqli_fetch_array($result)) {
                                         $firstname = $row['Firstname'];
                                         $lastname = $row['Lastname'];
                                         $username = $row['Username'];
                                         $id = $row['Adminid'];

                                         echo  ' <div style="margin-top:15%; color:#085e79;">
                                         <h5 style="font-size:18px; margin-bottom:5%; font-weight:600;">Firstname: <span
                                                 style="font-weight:bolder">'.$firstname.'</span></h5>
                                         <h5 style="font-size:18px; margin-bottom:5%; font-weight:600; ">Lastname: <span
                                                 style="font-weight:bolder">'.$lastname.'</span></h5>
                                         <h5 style="font-size:18px; margin-bottom:5%; font-weight:600;">Username: <span
                                                 style="font-weight:bolder">'.$username.'</span></h5>
                                         <h5 style="font-size:18px; margin-bottom:5%; font-weight:600;">ID: <span
                                                 style="font-weight:bolder">'.$id.'</span> </h5>
                                     </div>';
                                     }
                                ?>
                        </div>
                    </div>

                    <div class="col-md-7 col-lg-7 col-xl-7 col-sm-12">
                        <div style="width:80%; margin:5% 15% 0% 5%">
                            <div class="profile-btns">
                                <button class="btn btn-info" style="font-weight:bold; font-size:14px"
                                    id="update_name">Update
                                    Name</button>
                                <button class="btn btn-info" id="update_pwd"
                                    style="font-weight:bold; font-size:14px">Update
                                    Password</button>
                            </div>

                            <div class="profile_forms">


                                <?php 


                                  $ad = $_SESSION['admin'];

                                  if (isset($_POST['updateName'])) {
                                     $firstname = $_POST['firstname'];
                                     $lastname = $_POST['lastname'];
                                     $username = $_POST['username'];
                                  
                                  $sql = "update  `admin` set FirstName = ?, LastName = ?, Username= ? where Username = '$ad'";

                                  //preparing a prepared statement
                              
                                  $stmt = mysqli_stmt_init($conn);
                              
                                  mysqli_stmt_prepare($stmt, $sql);
                              
                                  mysqli_stmt_bind_param($stmt, 'sss', $firstname, $lastname, $username);
                                   $result = mysqli_stmt_execute($stmt);

                                   if ($result) {

                                      $_SESSION['admin'] = $username;
                                       $show = '<script>
                                       function hide(){
                                          var error = document.getElementById("error").style.display="none";
                                       }
                                       setTimeout("hide()", 3000)
                                       </script>
                                       
                                       <div style=" position:absolute; width:70%; margin:-6% 10% 5% 0%" id="error">
                                       <h6 class="alert alert-success text-dark" >Admin added succesfuly</h6></div>';
                                   }
                                  mysqli_stmt_close($stmt);
                                   echo $show;
                                  }



                                  if (isset($_SESSION['admin'])) {
                                     $ad = $_SESSION['admin'];

                                     $sql = "SELECT * FROM admin WHERE Username = '$ad'";

                                     $result = mysqli_query($conn, $sql);

                                     while($row = mysqli_fetch_assoc($result)){
                                         $username = $row['Username'];
                                         $lastname = $row['Lastname'];
                                         $firstname = $row['Firstname'];
                                         
                                     }
                                  }
                                
                                ?>
                                <!---Update name-->
                                <form method="post"
                                    style="width:80%; margin:5% 20% 0% 0%; display:none; z-index:555; position:relative; border-radius:10px;padding:5%"
                                    class="shadow" id="name_form">
                                    <i class="fa fa-close"
                                        style="position:absolute;margin-left:84%; margin-top:-3%; color: #00c3ff; cursor:pointer "
                                        id='close'></i>
                                    <div class="form-group" style="">
                                        <label for="username" style="font-size:12px; font-weight:bold;">Admin
                                            Firstname</label>
                                        <input type="text" name="firstname" class="form-control"
                                            placeholder="Add Admin Firstname..." value="<?php echo $firstname?>"
                                            style="border:2px solid   #00c3ff; padding:6% 4%; border-radius:10px; background-color:#fff;" />
                                    </div>
                                    <div class="form-group" style="">
                                        <label for="username" style="font-size:12px; font-weight:bold;">Admin
                                            Lastname</label>
                                        <input type="text" name="lastname" class="form-control"
                                            placeholder="Add Admin Lastname..." value="<?php echo $lastname?>"
                                            style="border:2px solid   #00c3ff; padding:6% 4%; border-radius:10px; background-color:#fff;" />
                                    </div>
                                    <div class="form-group" style="">
                                        <label for="username" style="font-size:12px; font-weight:bold;">Admin
                                            Username</label>
                                        <input type="text" name="username" class="form-control"
                                            placeholder="Add Admin username..." value="<?php echo $username?>"
                                            style="border:2px solid   #00c3ff; padding:6% 4%; border-radius:10px; background-color:#fff;" />
                                    </div>


                                    <button class="btn  btn-info text-white" style="font-size: 14px; font-weight: bold;"
                                        name="updateName">
                                        Update
                                    </button>
                                </form>
                                <!--end form name edit-->

                                <?php 


                                            $ad = $_SESSION['admin'];

                                            

                                            if (isset($_POST['updatepwd'])) {
                                            $oldpwd = $_POST['password_old'];
                                            $newpwd = $_POST['password_new'];
                                            $newpwd2 = $_POST['password_new2'];

                                           

                                            $error = array();

                                            if (empty($oldpwd)) {
                                                $error['update_pwd'] = "Provide Old Password";
                                            }elseif (empty($newpwd)) {
                                                $error['update_pwd'] = "Provide New Password";
                                            }elseif (empty($newpwd2)) {
                                                $error['update_pwd'] = "Provide Password Confirmation";
                                            }

                                            $query = "SELECT * FROM admin WHERE Username = '$ad'";
                                            $result = mysqli_query($conn,$query);


                                            while ($row = mysqli_fetch_array($result)) {
                                                $password = $row['Pwd'];
                                                 if ($oldpwd !== $password) {
                                                    $error['update_pwd'] = "Incorrect Old Password";
                                                 }elseif ($newpwd !== $newpwd2) {
                                                    $error['update_pwd'] = "New password must match";
                                                 }
                                            }

                                            if (count($error) == 0) {
                                              
                                            $sql = "update  `admin` set Pwd = ? where Username = '$ad'";

                                            //preparing a prepared statement

                                            $stmt = mysqli_stmt_init($conn);

                                            mysqli_stmt_prepare($stmt, $sql);

                                            mysqli_stmt_bind_param($stmt, 's', $newpwd);
                                            $result = mysqli_stmt_execute($stmt);

                                            if ($result) {
                                                $show = '<script>
                                                function hide(){
                                                    var error = document.getElementById("error").style.display="none";
                                                }
                                                setTimeout("hide()", 3000)
                                                </script>
                                                
                                                <div style=" position:absolute; width:70%; margin:-6% 10% 5% 0%" id="error">
                                                <h6 class="alert alert-success text-dark" >Admin added succesfuly</h6></div>';
                                            }
                                            mysqli_stmt_close($stmt);
                                            echo $show;
                                            }

                                           
                                            }

                                            ?>

                                <?php 
                                            if (isset($error['update_pwd'])) {
                                                $er = $error['update_pwd'];
                                                $display = '<script>
                                                function hide(){
                                                    var error = document.getElementById("error").style.display="none";
                                                }
                                                setTimeout("hide()", 3000)
                                                </script>
                                                
                                                <div style=" position:absolute; width:70%; margin:-6% 10% 5% 0%" id="error">
                                                <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

                                            }else{
                                                $display = '';
                                            }

                                            echo $display
                                            
                                            ?>
                                <!---Update Password-->
                                <form method="post"
                                    style="width:80%; margin:5% 20% 0% 0%; display:none; position:relative; z-index:555; border-radius:10px;padding:5%"
                                    class="shadow" id="password_form">
                                    <i class="fa fa-close"
                                        style="position:absolute;margin-left:84%; margin-top:-3%; color: #00c3ff; cursor:pointer "
                                        id='close_pwd'></i>

                                    <div class="form-group" style="">
                                        <label for="username" style="font-size:12px; font-weight:bold;"> Old
                                            Password</label>
                                        <input type="password" name="password_old" class="form-control"
                                            placeholder="Add Admin password..."
                                            style="border:2px solid   #00c3ff; padding:6% 4%; border-radius:10px; background-color:#fff;" />
                                    </div>
                                    <div class="form-group" style="">
                                        <label for="username" style="font-size:12px; font-weight:bold;"> New
                                            Password</label>
                                        <input type="password" name="password_new" class="form-control"
                                            placeholder="Add Admin password..."
                                            style="border:2px solid   #00c3ff; padding:6% 4%; border-radius:10px; background-color:#fff;" />
                                    </div>
                                    <div class="form-group" style="">
                                        <label for="username" style="font-size:12px; font-weight:bold;">New
                                            Password</label>
                                        <input type="password" name="password_new2" class="form-control"
                                            placeholder="Add Admin password..."
                                            style="border:2px solid   #00c3ff; padding:6% 4%; border-radius:10px; background-color:#fff;" />
                                    </div>
                                    <button class="btn  btn-info text-white" style="font-size: 14px; font-weight: bold;"
                                        name="updatepwd">
                                        Update
                                    </button>
                                </form>
                                <!--end form password update-->
                            </div>
                        </div>


                    </div>
                </div>
            </div>



            <script>
            document.getElementById('update_name').addEventListener('click', e => {
                document.getElementById('name_form').style.display = "block";
                document.getElementById('password_form').style.display = "none";
            });

            document.getElementById('close').addEventListener('click', e => {
                document.getElementById('name_form').style.display = "none";
            });

            document.getElementById('update_pwd').addEventListener('click', e => {
                document.getElementById('password_form').style.display = "block";
                document.getElementById('name_form').style.display = "none";
            });

            document.getElementById('close_pwd').addEventListener('click', e => {
                document.getElementById('password_form').style.display = "none";
            });
            </script>

</body>

</html>
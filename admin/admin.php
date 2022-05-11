<?php
 session_start();

 if (!isset($_SESSION['admin'])) {
    header('location: adminLogin.php');
 }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styling/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../styling/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../styling/admin.css" />
    <link rel="stylesheet" href="../styling/header.css" />
    <title>Admin</title>

    <style>
    .show {
        display: block;
    }

    .color {
        color: red;
    }
    </style>

</head>

<body>
    <?php  

        include('../includes/connect.php');

        include('header.php');

        ?>
</body>
<section class="adminIndexWrap container-fluid">
    <div class="row">
        <div class="col-md-2 col-lg-2 col-xl-2" style="margin: 0%; padding: 0%">
            <?php include('sidenav.php')?>
        </div>
        <div class="col-md-10 col-lg-10 col-xl-10">
            <div class="admin_add row" style=" width:80%; margin:5% 10%;">
                <div class="col-md-6 col-lg-6 col-xl-6">


                    <?php 
                             $username = $_SESSION['admin'];
                             $query = "SELECT * FROM `admin` WHERE Username != '$username'";
                             $result = mysqli_query($conn, $query);
                                                    

                             $output = '<table class="table table-bordered">
                                        <tr> <th>ID</th>
                                        <th>Username</th>
                                        <th>Action</th> <tr>';

                                    if (mysqli_num_rows($result) < 1) {
                                        $output .= '<tr><td class="text-center" colspan="3">No Admin Data</td></tr>';
                                    }
                                    while($row = mysqli_fetch_array($result)){
                                     
                                        $id = $row['Adminid'];
                                        $username = $row['Username'];
                                       
                                      

                                        $output .= "<tr> 
                                                     <td>$id</td>
                                                     <td>$username</td>
                                                     <td>
                                                     <button onclick='view(this)' class='btn btn-secondary' id='$id' >View</button>
                                                     <button onclick='edit(this)' class='btn btn-info' id='$id'>Edit</button>
                                                     <a href='admin.php?deleteid=$id'><button  class='btn btn-danger'>Remove</button></a>
                                                     
                                                    </td>
                                                     ";
                                    }
                                    $output .= "</tr> </table>";

                                    echo $output;

                                       
                            //delete id.
                            if (isset($_GET['deleteid'])) {
                            
                                $id = $_GET['deleteid'];
                            
                                $sql = "delete from `admin` where Adminid = $id";
                            
                                $result = mysqli_query($conn, $sql);
                            
                            
                            }
                            ?>


                </div>
                <div class="col-md-6 col-lg-6 col-xl-6">

                    <?php
                          if (isset($_POST['add'])) {
                            $username =  ucfirst($_POST['username']) ;
                            $firstname = ucfirst($_POST['firstname']);
                            $lastname = ucfirst($_POST['lastname']);
                            $password = $_POST['password'];
                            $adminid = $_POST['adminid'];

                            $error = array();

                            if (empty($username)) {
                                $error['add'] = "Provide Admin Username";
                            }elseif (empty($password)) {
                                $error['add'] = "Provide Admin Passoword";
                            }elseif (empty($adminid)) {
                                $error['add'] = "Provide Admin ID";
                            }elseif (empty($firstname)) {
                                $error['add'] = "Provide Admin Firstname";
                            }elseif (empty($lastname)) {
                                $error['add'] = "Provide Admin Lastname";
                            }

                            if (count($error) == 0) {
                                 $sql = "SELECT * FROM admin WHERE Username = '$username'";
                                 $result = mysqli_query($conn, $sql);
                                 $query = "SELECT * FROM admin WHERE Adminid = '$adminid'";
                                 $response = mysqli_query($conn, $query);

                                 if (mysqli_num_rows($result) > 0) {
                                    $show = '<script>
                                    function hide(){
                                       var error = document.getElementById("error").style.display="none";
                                    }
                                    setTimeout("hide()", 3000)
                                    </script>
                                    
                                    <div style=" position:absolute; width:75%; margin:-3% 10% 5% 3%" id="error">
                                    <h6 class="alert alert-danger text-dark" >Admin Username Already exits</h6></div>';
                                 }else if (mysqli_num_rows($response) > 0) {
                                    $show = '<script>
                                    function hide(){
                                       var error = document.getElementById("error").style.display="none";
                                    }
                                    setTimeout("hide()", 3000)
                                    </script>
                                    
                                    <div style=" position:absolute; width:75%; margin:-3% 10% 5% 3%" id="error">
                                    <h6 class="alert alert-danger text-dark" >Admin ID Already exits</h6></div>';
                                 }
                                 elseif (mysqli_num_rows($result) == 0 && mysqli_num_rows($response) == 0) {
                                     
                                 
                                     $sql = "INSERT INTO `admin` (Firstname, Lastname,Username, Pwd, Adminid)
                                      VALUES (?,?,?,?,?);";
                                     //preparing a prepared statement

                                    $stmt = mysqli_stmt_init($conn);

                                     mysqli_stmt_prepare($stmt, $sql);
                                     
                                    mysqli_stmt_bind_param($stmt, 'ssssi', $firstname, $lastname, $username, $password, $adminid);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_close($stmt);

                                     $show = ' <script>
                                     function hide(){
                                        var error = document.getElementById("error").style.display="none";
                                     }
                                     setTimeout("hide()", 3000)
                                     </script>
                                     
                                     <div style=" position:absolute; width:75%; margin:-1% 10% 5% 2%" id="error">
                                     <h6 class="alert alert-success text-dark" >Admin added succesfuly</h6></div>';
                                    
                                 }

                                 echo $show;
                          }

                        }
                       ?>
                    <!-- error display -->

                    <?php 
                         if (isset($error['add'])) {
                            $er = $error['add'];
                            $display = ' <script>
                            function hide(){
                               var error = document.getElementById("error").style.display="none";
                            }
                            setTimeout("hide()", 3000)
                            </script>
                            
                            <div style=" position:relative; width:75%; margin:-5% 10% 5% 9%" id="error">
                            <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

                         }else{
                             $display = '';
                         }

                         echo $display
                        
                        ?>


                    <!-- ------------------------------Add admin form-------------------------------- -->
                    <button class="btn btn-info " style="margin: 0% 0% 5% 5%; font-weight:bold; font-size:12px"
                        id="add_btn">Add
                        Admin <i class="fa fa-plus"></i></button>

                    <form action="" class="add_admin shadow" method="post" id="add_form"
                        style="width:90%; margin:-4.5% 5%; border:2px solid  position:relative; #00c3ff; padding:2% 6%;display:none;  height:430px;">
                        <i class="fa fa-close"
                            style="position:absolute; margin-left:70%; color:#00c3ff; cursor:pointer "
                            id="close_addform"></i>
                        <div class="form-group" style="margin-top:-1%">
                            <label for="AdminId" style="font-size:12px; font-weight:bold; color:#085e79;">Admin
                                ID</label>
                            <input type="number" name="adminid" class="form-control" placeholder="Add Admin Id..."
                                style="border:2px solid   #00c3ff; padding:2% 3%;; font-size:13px; margin-top:-1.5%; border-radius:10px; background-color:#fff;" />
                        </div>
                        <div class="form-group" style="margin-top:-1%">
                            <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">Admin
                                Firstname</label>
                            <input type="text" name="firstname" class="form-control" placeholder="Add Admin username..."
                                style="border:2px solid   #00c3ff; padding:2% 3%;; font-size:13px; margin-top:-1.5%; border-radius:10px; background-color:#fff;" />
                        </div>
                        <div class="form-group" style="margin-top:-1%">
                            <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">Admin
                                Lastname</label>
                            <input type="text" name="lastname" class="form-control" placeholder="Add Admin username..."
                                style="border:2px solid   #00c3ff; padding:2% 3%;; font-size:13px; margin-top:-1.5%; border-radius:10px; background-color:#fff;" />
                        </div>
                        <div class="form-group" style="margin-top:-1%">
                            <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">Admin
                                Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Add Admin username..."
                                style="border:2px solid   #00c3ff; padding:2% 3%;; font-size:13px; margin-top:-1.5%; border-radius:10px; background-color:#fff;" />
                        </div>
                        <div class="form-group" style="margin-top:-1%">
                            <label for="password" style="font-size:12px; font-weight:bold; color:#085e79;">Admin
                                Password</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Add Admin password..."
                                style="border:2px solid   #00c3ff; padding:2% 3%;; font-size:13px; margin-top:-1.5%; border-radius:10px; background-color:#fff;" />
                        </div>

                        <button class="btn  btn-info text-white" style="
                                 
                                    font-size: 14px;
                                    font-weight: bold;
                                " name="add">
                            Add Admin
                        </button>

                    </form>


                    <?php

                if (isset($_POST['edit'])) {
                    $username = ucfirst( $_POST['username']);
                    $adminid = $_POST['adminid'];
                    $password = $_POST['password'];
                    $fake = $_POST['fake_id'];
                    $error = array();


                    $query = "SELECT * FROM admin WHERE Adminid != $fake ";
                    $resp = mysqli_query($conn, $query);

                    if (empty($username)) {
                        $error['add'] = "Provide Admin Username";
                    }elseif (empty($password)) {
                        $error['add'] = "Provide Admin Passoword";
                    }elseif (empty($adminid)) {
                        $error['add'] = "Provide Admin ID";
                    }

                    while($row = mysqli_fetch_assoc($resp)){
                        $un = $row['Username'];
                        $adid = $row['Adminid'];

                        if ($un == $username) {
                            $error['add'] = "Username Already exists";
                        }else if ($adid == $adminid){
                            $error['add'] = "Admin ID Already exists";
                        }
                    }

                    if (count($error) == 0) {
                    
                            $sql = "UPDATE  `admin` SET Username = ?, Pwd = ?, Adminid = ? WHERE Adminid =  '$fake'";

                            //preparing a prepared statement
            
                            $stmt = mysqli_stmt_init($conn);
            
                            mysqli_stmt_prepare($stmt, $sql);
            
                            mysqli_stmt_bind_param($stmt, 'ssi', $username, $password, $adminid);
                            $result = mysqli_stmt_execute($stmt);
            
                            if ($result) {
                                $show = '<script>
                                function hide(){
                                    var error = document.getElementById("error").style.display="none";
                                }
                                setTimeout("hide()", 3000)
                                </script>
                                
                                <div style=" position:relative; width:70%; margin:-15% 10% 5% 0%" id="error">
                                <h6 class="alert alert-success text-dark" >Admin Updated succesfuly</h6></div>';
                            }
                            mysqli_stmt_close($stmt);
                            echo $show;
                            }
                            
            
                        }
                    

                        if (isset($error['add'])) {
                            $er = $error['add'];
                            $display = ' <script>
                            function hide(){
                                var error = document.getElementById("error").style.display="none";
                            }
                            setTimeout("hide()", 3000)
                            </script>
                            
                            <div style=" position:relative; width:70%; margin:-15% 10% 5% 0%" id="error">
                                <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

                         }else{
                             $display = '';
                         }

                         echo $display
               

                   ?>



                    <!--------------------------------Edit admin form-------------------------------- -->
                    <form action="" class="add_admin shadow" method="post" id="edit_form"
                        style="width:90%; margin:0% 5%; border:2px solid #00c3ff; padding:4% 4%; height:400px; display:none; position:relative">
                        <i class="fa fa-close"
                            style="position:absolute; margin-left:87%; color:#00c3ff; cursor:pointer "
                            id="close_editform"></i>
                        <div id="show_input"></div>

                        <input type="text" class="form-control" id="hidden_input" value="" name="fake_id" hidden>



                    </form>

                    <!--view admin details-->
                    <div>
                        <div class="profile_board shadow "
                            style="height:300px; width:90%; margin:0% 0% 0% 5%; padding:4% 4%; display:none; "
                            id="board" ;>
                            <i class="fa fa-close"
                                style="position:absolute; margin-left:73%; color:#00c3ff; cursor:pointer "
                                id="close_card"></i>
                            <h3 class="text-center"
                                style="font-size:16px; text-transform:uppercase; color:#085e79;font-weight:bolder;">
                                Admin Profile
                                Board</h3>

                            <div style="margin-top:15%; color:#085e79;" id="status">
                            </div>

                            <input type="text" id="view_input" hidden>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>





<?php include_once('adminfooter.php')?>
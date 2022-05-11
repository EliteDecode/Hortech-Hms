<?php
  session_start();
  include('../includes/connect.php');

  if (!isset($_SESSION['patient'])) {
    header('location: patientlogin.php');
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
    <title>Patient Profile</title>

    <style>
    .doctorscard {

        height: 470px;
        width: 80%;
        margin: 3% 0% 0% 5%;
        padding: 5% 5%;
    }

    .img {

        height: 120px;
        width: 50%;
        border-radius: 100%;
        margin-bottom: 5%;
    }

    .doctorscard h6 {
        color: #085e79;
        margin-bottom: 9%;
        font-weight: 600;
    }

    .doctorscard h6 span {
        font-weight: bolder;
        margin-left: 2%;
        font-size: 14px;
    }

    .salary_form {
        width: 90%;
        margin: 7% 0% 0% 0%;
        padding: 4% 4%;
        box-shadow: 2px 4px 13px #008cba;
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
                style="background-color: rgba(255, 255, 255, 0.207); position:relative ">

                <div class="row">
                    <div class="col-md-4 col-lg-4 col-xl-4 col-sm-4">
                        <div class="doctorscard">



                            <?php
                          if (isset($_SESSION['patient'])) {
                              $un = $_SESSION['patient'];

                              $sql = "SELECT * FROM patient WHERE Username = '$un'";
                              $result = mysqli_query($conn,$sql);

                              while($row = mysqli_fetch_assoc($result)){
                                $patientid = $row['Patientid'];
                                $Firstname = $row['Firstname'];
                                $Lastname = $row['Lastname'];
                                $Username = $row['Username'];
                                $Gender = $row['Gender'];
                                $Passport = $row['Passport'];
                               
                                $Email = $row['Email'];
                                $DateReg = $row['DateReg'];
                               
                                $password = $row['Pwd'];

                                echo "
                                <div class='img'>
                                <img src='images/$Passport' alt='' style='border-radius:100%; 
                                width:100%; height:120px' >
                                </div>
                               
                                <h6>Patients Id: <span>$patientid</span></h6>
                                <h6>Firstname:<span>$Firstname</span></h6>
                                <h6>Lastname:<span>$Lastname</span></h6>
                                <h6>Username:<span>$Username</span></h6>
                                <h6>Email :<span>$Email</span></h6>
                                <h6>Gender:<span>$Gender</span></h6>
                                
                               
                                <h6>Application Date:<span>$DateReg</span></h6>"
                               ;
                              }
                          }
                        ?>

                        </div>
                    </div>



                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <?php include_once('profilehandle.php')?>



                        <button class="btn btn-info" style="font-size:13px; font-weight:bold; margin-top:2%"
                            id="btn_picture">Update
                            Profile
                            Picture</button>


                        <form action="" class=" salary_form" method="post" id="display_profile"
                            enctype="multipart/form-data" style="display:none">
                            <h6>Profile Picture</h6>
                            <i class="fa fa-close"
                                style="position:absolute; margin-top:-7%; margin-left:72%; color:#085e79;  cursor:pointer"
                                id="close_profile"></i>
                            <div class="form-group">
                                <label for="salary" style="font-size:12px; font-weight:bold;">Salary</label>
                                <input type="file" name="passport" class="form-control" />
                            </div>
                            <button class="btn  btn-info text-white" style="font-size: 14px; font-weight: bold;"
                                name="update_p">
                                Update Picture
                            </button>

                        </form>

                    </div>

                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <!--------------------------------Edit admin form-------------------------------- -->
                        <?php

                            if (isset($_POST['edit'])) {
                             
                                $uname = $_SESSION['patient'];
                                
                                $username = ucfirst($_POST['username']);
                                $lastname = ucfirst($_POST['lastname']);
                                $email = lcfirst($_POST['email']);
                                $firstname = $_POST['firstname'];
                                $password = $_POST['password'];
     
                                $sql = "SELECT * FROM patient WHERE Username != '$uname'";
                                $result = mysqli_query($conn,$sql);
                               
                                $error = array();

                                if (empty($username)) {
                                $error['edit'] = "Input Username";
                                }else if (empty($firstname)) {
                                    $error['edit'] = "Input Firstname";
                                 }else if (empty($lastname)) {
                                    $error['edit'] = "Input Lastname";
                                 }else if (empty($email)) {
                                    $error['edit'] = "Input Email";
                                 }else if (empty($password)) {
                                    $error['edit'] = "Input Password";
                                 }

                                 while($row = mysqli_fetch_assoc($result)){
                                    $em = $row ['Email'];
                                    $un = $row['Username'];
                                   if ($un == $username) {
                                        $error['edit'] = "Username Already Taken";
                                     }elseif ($em == $email) {
                                        $error['edit'] = "Email Already Exists";
                                     }
                                }

                                if (count($error) == 0) {
                                    $sql = "UPDATE  `patient` SET Firstname = ?, Lastname = ?, Username = ?,
                                     Email = ?, Pwd= ? WHERE Username = '$uname'";

                                    //preparing a prepared statement

                                    $stmt = mysqli_stmt_init($conn);

                                    mysqli_stmt_prepare($stmt, $sql);

                                    mysqli_stmt_bind_param($stmt, 'sssss',$firstname, $lastname, $username, $email, $password);
                                    $result = mysqli_stmt_execute($stmt);

                                    if ($result) {
                                        $_SESSION['patient'] = $username;
                                        $show = '<script>
                                        function hide(){
                                        var error = document.getElementById("error").style.display="none";
                                        }
                                        setTimeout("hide()", 3000)
                                        </script>
                                        
                                        <div style=" position:absolute; width:83%; margin:1.5% 10% 5% 0%" id="error">
                                        <h6 class="alert alert-success text-dark" > Info Updated succesfuly</h6></div>';
                                    }
                                    mysqli_stmt_close($stmt);
                                    echo $show;
                                    }

                                }

                                if (isset($error['edit'])) {
                                    $er = $error['edit'];
                                    $display = ' <script>
                                    function hide(){
                                    var error = document.getElementById("error").style.display="none";
                                    }
                                    setTimeout("hide()", 3000)
                                    </script>
                                    
                                    <div style=" position:absolute; width:83%; margin:1% 10% 5% 0%" id="error">
                                        <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

                                }else{
                                    $display = '';
                                }

                                echo $display

                            
                                ?>

                        <button class="btn btn-info" style="font-size:13px; font-weight:bold; margin-top:2%; z-index:0;"
                            id="btn_edit"> Update
                            Details
                        </button>
                        <form action="" class=" salary_form" method="post" style="margin-top:2%; display:none;"
                            id="form_e">
                            <i class="fa fa-close"
                                style="position:absolute; margin-top:0%; margin-left:74%; color:#085e79; cursor:pointer"
                                id="close_edit"></i>
                            <h6> Info Edit</h6>

                            <div class="form-group">
                                <label for="firstname" style="font-size:12px; font-weight:bold;">Firstname</label>
                                <input type="text" name="firstname" class="form-control"
                                    value="<?php echo isset($_SESSION["patient"]) ? $Firstname : '';?>" />
                            </div>
                            <div class="form-group">
                                <label for="lastname" style="font-size:12px; font-weight:bold;">Lastname</label>
                                <input type="text" name="lastname" class="form-control"
                                    value="<?php echo isset($_SESSION["patient"]) ? $Lastname : '';?>" />
                            </div>
                            <div class="form-group">
                                <label for="email" style="font-size:12px; font-weight:bold;">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?php echo isset($_SESSION["patient"]) ? $Email : '';?>" />
                            </div>
                            <div class="form-group">
                                <label for="username" style="font-size:12px; font-weight:bold;">Username</label>
                                <input type="text" name="username" class="form-control"
                                    value="<?php echo isset($_SESSION["patient"]) ? $Username : '';?>" />
                            </div>
                            <div class="form-group">
                                <label for="password" style="font-size:12px; font-weight:bold;">Password</label>
                                <input type="password" name="password" class="form-control"
                                    value="<?php echo isset($_SESSION["patient"]) ? $password : '';?>" />
                            </div>
                            <button class="btn  btn-info text-white" style="font-size: 14px; font-weight: bold;"
                                name="edit">
                                Update Info
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>




    <script>
    document.getElementById('btn_picture').addEventListener('click', e => {

        document.getElementById('display_profile').style.display = "block";
    });

    document.getElementById('btn_edit').addEventListener('click', e => {
        document.getElementById('form_e').style.display = "block";
        this.style.display = "none";
    });
    document.getElementById('close_edit').addEventListener('click', e => {
        document.getElementById('form_e').style.display = "none";
        document.getElementById('btn_edit').style.display = "block";

    });


    document.getElementById('close_profile').addEventListener('click', e => {
        document.getElementById('display_profile').style.display = "none";

    });
    </script>
</body>

</html>
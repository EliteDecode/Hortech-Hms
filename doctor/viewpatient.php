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
    .button {
        font-weight: bold;
    }

    .doctorscard {

        height: 470px;
        width: 80%;
        margin: 0% 0% 0% 5%;
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
                          if (isset($_GET['editid'])) {
                              $id = $_GET['editid'];

                              $sql = "SELECT * FROM patient WHERE id = $id";
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
                                <img src='../doctor/images/$Passport' alt='' style='border-radius:100%; width:100%; height:120px'>
                                </div>
                                <h6>Doctors Id: <span>$patientid</span></h6>
                                <h6>Firstname:<span>$Firstname</span></h6>
                                <h6>Lastname:<span>$Lastname</span></h6>
                                <h6>Username:<span>$Username</span></h6>
                                <h6>Email :<span>$Email</span></h6>
                                <h6>Gender:<span>$Gender</span></h6>
                                <h6>Application Date:<span>$DateReg</span></h6>";
                               
                              }
                          }
                        ?>

                        </div>
                    </div>


                    <div class="col-md-4 col-lg-4 col-xl-4">




                    </div>

                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <!--------------------------------Edit admin form-------------------------------- -->
                        <?php

                            if (isset($_POST['edit'])) {
                                $patientid = $_POST['patientid'];
                                
     
                                $sql = "SELECT * FROM patient WHERE id != '$id'";
                                $result = mysqli_query($conn,$sql);

                                $error = array();

                                 if (empty($patientid)) {
                                    $error['edit'] = "Input Id";
                                 }

                                 while($row = mysqli_fetch_assoc($result)){
                                    $dd = $row['Patientid'];
                               
                                    if ($dd == $patientid){
                                        $error['edit'] = "ID Already Taken";
                                     }
                                }

                                if (count($error) == 0) {
                                    $sql = "UPDATE  `patient` SET Patientid = ? WHERE id = $id";

                                    //preparing a prepared statement

                                    $stmt = mysqli_stmt_init($conn);

                                    mysqli_stmt_prepare($stmt, $sql);

                                    mysqli_stmt_bind_param($stmt, 'i',  $patientid);
                                    $result = mysqli_stmt_execute($stmt);

                                    if ($result) {
                                        $show = '
                                        <script>
                                        function hide(){
                                           var error = document.getElementById("error").style.display="none";
                                        }
                                        setTimeout("hide()", 3000)
                                        </script>
                                        
                                        <div style=" position:absolute; width:83%; margin:3% 10% 5% 0%" id="error">
                                        <h6 class="alert alert-success text-dark" >Doctors Info Updated succesfuly</h6></div>';
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
                                    
                                    <div style=" position:absolute; width:83%; margin:3% 10% 5% 0%" id="error">
                                        <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

                                }else{
                                    $display = '';
                                }

                                echo $display
                                ?>

                        <button class="btn btn-info" id="btn_update"
                            style="margin-top:5%; margin-right:9%; float:right; font-weight: bold; font-size:13px ">Update
                            Info</button>
                        <button class="btn btn-info" id="btn_status"
                            style="margin-top:5%; margin-right:9%; float:right; font-weight: bold;font-size:13px ">
                            Status</button>

                        <form action="" class=" salary_form" method="post" id="form_u"
                            style="position:relative; display:none;">
                            <i class="fa fa-close" style="position:absolute; left:90%; color:#17a2b8; cursor:pointer;"
                                id="close_u"></i>
                            <h6>Assign Patient ID</h6>

                            <div class="form-group">
                                <label for="doctorid" style="font-size:12px; font-weight:bold;">Patient Id</label>
                                <input type="number" name="patientid" class="form-control"
                                    value="<?php echo isset($_GET["editid"]) ? $patientid : '';?>" />
                            </div>

                            <button class="btn  btn-info text-white" style="font-size: 14px; font-weight: bold;"
                                name="edit">
                                Update ID
                            </button>

                        </form>

                        <div class="status " id="status" style="position:relative; display:none">
                            <i class="fa fa-close" style="position:absolute; left:90%; color:#17a2b8; cursor:pointer"
                                id="close_status"></i>

                            <?php
                                 if (isset($_GET['editid'])) {
                                    $id = $_GET['editid'];

                                    $sql = "SELECT * FROM patient WHERE id = $id";
                                    $result = mysqli_query($conn,$sql);

                                  

                                    while(  $row = mysqli_fetch_assoc($result)){

                                        $active = $row['Active'];
                                        $login = $row['loginTime'];
                                        $logout = $row['logoutTime'];

                                    if ($active == 'ONLINE') {
                                        echo "  <h6>Staus: <span class='online'>ONLINE</span> </h6>";
                                    }elseif($active != 'ONLINE'){
                                        echo "  <h6>Staus: <span class='offline'>OFFLINE</span> </h6>";
                                    }

                                }
                                 }

                             ?>

                            <h6>Login Time: <span class='offline'><?php echo $login?></span> </h6>
                            <h6>Logout Time: <span class='offline'><?php echo $logout?></span> </h6>



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>




    <script>
    document.getElementById('btn_status').addEventListener('click', e => {
        document.getElementById('form_u').style.display = "none";
        document.getElementById('status').style.display = "block";
    })
    document.getElementById('btn_update').addEventListener('click', e => {
        document.getElementById('form_u').style.display = "block";
        document.getElementById('status').style.display = "none";
    })


    document.getElementById('close_u').addEventListener('click', e => {
        document.getElementById('form_u').style.display = "none";

    })

    document.getElementById('close_status').addEventListener('click', e => {
        document.getElementById('status').style.display = "none";
    })
    </script>
</body>

</html>
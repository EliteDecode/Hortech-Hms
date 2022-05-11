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
    <title>Admin View report</title>

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
                              $user = $_GET['editid'];

                              $sql = "SELECT * FROM patient WHERE Username = '$user'";
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
                                <h6>Patient's Id: <span>$patientid</span></h6>
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
                        <div class='profile_board shadow ' style='height:330px; width:94%; background-color:#fff;
                        margin:18.5% 0% 0% -15%;z-index:10; position:absolute; padding:4% 4%; color:#085e79;   '
                            id='board' ;>

                            <h3 class='text-center'
                                style='font-size:16px; text-transform:uppercase; color:#085e79;font-weight:bolder;'>
                                Report Details</h3>

                            <div style='margin-top:2%; color:#085e79;' id='status'>

                                <?php

                        if (isset($_GET['editid'])) {
                            # code...
                        
                        $user = $_GET['editid'];

                        $sql = "SELECT * FROM report WHERE Patient= '$user'";



                        $result = mysqli_query($conn, $sql);

                        while($row = mysqli_fetch_assoc($result)){

                        $report = $row['Report'];
                        $title = $row['Title'];
                        $doctor = $row['Doctor'];
                        $status = $row['Stats'];
                        $dateView = $row['DateReg'];
                        $feedback = $row['Feedback'];
                        $dateFeedback = $row['FeedbackDate'];


                        $show = "
                       
                       <h5 style='font-size:15px; margin-bottom:3%; font-weight:bold;'>Title: <span
                       style='font-weight:lighter'>$title</span></h5>
                        <h5 style='font-size:15px; margin-bottom:3%; font-weight:bold; '>Doctor: <span
                                style='font-weight:lighter'>$doctor</span></h5>
                        <h5 style='font-size:15px; margin-bottom:3%; font-weight:bold;'>Status: <span
                                style='font-weight:lighter'>$status</span></h5>
                        <h5 style='font-size:15px; margin-bottom:3%; font-weight:bold;'>Report: <span
                                style='font-weight:lighter'>$report</span> </h5>
                        <h5 style='font-size:15px; margin-bottom:3%; font-weight:bold;'>Sent at: <span
                                style='font-weight:lighter'>$dateView</span> </h5>
                        <h5 style='font-size:15px; margin-bottom:3%; font-weight:bold;'>Report: <span
                                style='font-weight:lighter'>$feedback</span> </h5>
                        <h5 style='font-size:15px; margin-bottom:3%; font-weight:bold;'>Sent at: <span
                                style='font-weight:lighter'>$dateFeedback</span> </h5>
                       
                       
                        ";

                        }

                        echo $show;

                      
                    }

                     ?>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <!--------------------------------Edit admin form-------------------------------- -->


                        <form action="" class=" salary_form" method="post" id="form_u" style="position:relative; ">
                            <!-- <i class="fa fa-close" style="position:absolute; left:90%; color:#17a2b8; cursor:pointer;"
                                id="close_u"></i> -->
                            <h6>Send Message To Dr <?php echo $doctor?></h6>

                            <div class="form-group" style="margin-top:-1%">
                                <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                                    Message</label>
                                <textarea name="report" id="" cols="30" value="<?php echo $feedback?>" rows="5"
                                    placeholder="Your Message...." class="form-control"
                                    style="border:2px solid #00c3ff; padding:4% 3%;
                                     font-size:13px; margin-top:-1.5%;font-weight:bold; color:#085e79; border-radius:10px; background-color:#fff;"></textarea>
                            </div>

                            <button class="btn  btn-info text-white" style="font-size: 14px; font-weight: bold;"
                                name="edit">
                                Send
                            </button>

                        </form>

                        <div class="status " id="status" style="position:relative;">

                            <?php
                                 if (isset($_GET['editid'])) {
                                    $user = $_GET['editid'];

                                    $sql = "SELECT * FROM patient WHERE Username = '$user'";
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

    </script>
</body>

</html>
<?php

include("../includes/connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styling/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../styling/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../styling/doctor.css" />
    <link rel="stylesheet" href="../styling/header.css" />

    <style>
    .wrap_bg {
        background-image: url('../images/patient4.jpg');
        background-size: 100% 100%;
    }

    .wrap_form {
        box-shadow: 2px 4px 13px #008cba;
        margin-top: 3%;
        position: relative;
    }

    .form-group {
        width: 90%;
        margin: 6% 5%;
        position: relative;
    }

    .form-group label {
        color: #085e79;
    }

    .form-group input {
        margin-top: -1.5%;

        padding: 6.5% 3%;
        border-radius: 10px;
    }

    .form-group select {

        border-radius: 10px;

    }
    </style>
</head>

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
                    <a href="../admin/adminLogin.php" class="nav-link">Admin</a>
                </li>
                <li class="nav-item">
                    <a href="../doctor/doctorlogin.php" class="nav-link">Doctor</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Patient</a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="register container">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-lg-8 col-xl-8">
                <div style=" height:450px; margin-top:5%; margin-left:0%" class="wrap_bg">

                </div>

            </div>

            <div class="col-md-4 col-sm-4 col-lg-4 col-xl-4 wrap_form ">
                <?php
                    include('registervalidation.php')
                    ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <h4 class="text-center" style="font-size:16px; margin:8% 0%; color:#085e79;">Start your health care
                        Journey
                    </h4>

                    <!--first batch -->
                    <div id="firstbatch">
                        <div class="form-group">
                            <label for="firstname" style="font-size:14px; font-weight:bold;"> Firstname</label>
                            <input type="text"
                                value="<?php echo isset($_POST["register"]) ? $_POST["Firstname"] : '';?>"
                                name="Firstname" class="form-control" placeholder="Your firstname..." />
                        </div>
                        <div class="form-group">
                            <label for="lastname" style="font-size:14px; font-weight:bold;"> Lastname</label>
                            <input type="text" name="Lastname"
                                value="<?php echo isset($_POST["register"]) ? $_POST["Lastname"] : '';?>"
                                class="form-control" placeholder="Your lastname..." />
                        </div>
                        <div class="form-group" style="font-size:14px; font-weight:bold;">
                            <label for="username"> Username</label>
                            <input type="text" value="<?php echo isset($_POST["register"]) ? $_POST["Username"] : '';?>"
                                name="Username" class="form-control" placeholder="Your username..." />
                        </div>
                        <h6 style="font-size:12px; margin-top:5px; margin-left:25px;">Alrady Registered with
                            Hortech?
                            <a href="patientlogin.php" style="color:#0066ff; margin-left:1px;">Login</a>
                        </h6>

                        <button class="btn text-white" style="
                            background-color: #008cba;
                            font-size: 14px;
                            font-weight: bold;
                            margin-left:69%;
                            margin-top:5%;
                            padding:2% 6%;
                        " id="btn">

                            Next
                            <i class="fa fa-arrow-right" style="margin-left:4%"></i>
                        </button>
                    </div>
                    <!--second batch -->
                    <div id="secondBatch" style="display:none">

                        <i class="fa fa-arrow-left"
                            style="margin-top:-10%; position:absolute; margin-left:4%; color:#008cba; cursor:pointer;"
                            id="back"></i>
                        <div class="form-group">
                            <label for="gender" style="font-size:14px; font-weight:bold;"> Gender</label>
                            <select name="Gender" id="" class="form-control"
                                value="<?php echo isset($_POST["register"]) ? $_POST["Gender"] : '';?>">

                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="passport" style="font-size:14px; font-weight:bold;">Passport</label>
                            <input type="file" name="Passport" class="form-control" placeholder="Your passport..."
                                style="padding:2% 0%" />
                        </div>
                        <div class="form-group">
                            <label for="username" style="font-size:14px; font-weight:bold;"> Email</label>
                            <input type="email" name="Email"
                                value="<?php echo isset($_POST["register"]) ? $_POST["Email"] : '';?>"
                                class="form-control" placeholder="Your username..." />
                        </div>


                        <h6 style="font-size:12px; margin-top:5px; margin-left:25px;">Already registered with
                            Hortech?
                            <a href="patientlogin.php" style="color:#0066ff; margin-left:1px;">Login</a>
                        </h6>

                        <button class="btn text-white" style="
                            background-color: #008cba;
                            font-size: 14px;
                            font-weight: bold;
                            margin-left:69%;
                            margin-top:5%;
                            padding:2% 6%;
                            margin-bottom:5%;
                        " id="btn2">

                            Next
                            <i class="fa fa-arrow-right" style="margin-left:4%"></i>
                        </button>
                    </div>
                    <!--third batch -->
                    <div id="thirdBatch" style="display:none">
                        <i class="fa fa-arrow-left"
                            style="margin-top:-10%; position:absolute; margin-left:4%; color:#008cba; cursor:pointer;"
                            id="back2"></i>


                        <div class="form-group" style="font-size:14px; font-weight:bold;">
                            <label for="password"> Password</label>
                            <input type="password" name="Password"
                                value="<?php echo isset($_POST["register"]) ? $_POST["Password"] : '';?>"
                                class="form-control" placeholder="Your password..." />
                        </div>
                        <div class="form-group" style="font-size:14px; font-weight:bold;">
                            <label for="password">Confirm Password</label>
                            <input type="password" name="Repassword"
                                value="<?php echo isset($_POST["register"]) ? $_POST["Repassword"] : '';?>"
                                class="form-control" placeholder="Confirm Your password..." />
                        </div>
                        <h6 style="font-size:12px; margin-top:5px; margin-left:25px;">A registered doctor with
                            Hortech?
                            <a href="doctorlogin.php" style="color:#0066ff; margin-left:1px;">Login</a>
                        </h6>

                        <button class="btn text-white" style="
                            background-color: #008cba;
                            font-size: 14px;
                            font-weight: bold;
                            margin-left:62%;
                            margin-top:5%;
                            padding:2% 6%;
                            margin-bottom:5%;
                        " id="btn" name="register">


                            Register
                            <i class="fa fa-arrow-right" style="margin-left:4%"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>




    <script>
    document.getElementById('btn').addEventListener('click', e => {
        e.preventDefault();

        document.getElementById('firstbatch').style.display = 'none';
        document.getElementById('secondBatch').style.display = 'block';

    })

    document.getElementById('btn2').addEventListener('click', e => {
        e.preventDefault();
        document.getElementById('firstbatch').style.display = 'none';
        document.getElementById('secondBatch').style.display = 'none';
        document.getElementById('thirdBatch').style.display = 'block';
    })

    document.getElementById('back2').addEventListener('click', e => {
        e.preventDefault();
        document.getElementById('firstbatch').style.display = 'none';
        document.getElementById('secondBatch').style.display = 'block';
        document.getElementById('thirdBatch').style.display = 'none';
    })

    document.getElementById('back').addEventListener('click', e => {
        e.preventDefault();
        document.getElementById('firstbatch').style.display = 'block';
        document.getElementById('secondBatch').style.display = 'none';
        document.getElementById('thirdBatch').style.display = 'none';
    })
    </script>

</body>

</html>
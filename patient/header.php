<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../styling/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../styling/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../styling/header.css" />
</head>

<body>

    <?php
              if (isset($_SESSION['patient'])){
                  $username = $_SESSION['patient'];

                  $sql = "SELECT * FROM patient WHERE Username = '$username'";

                  $result = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_assoc($result);
                  $sex = $row['Gender'];
              }
            ?>


    <nav class="navbar navbar-expand-lg navbar-light text-dark shadow" style="background-color: #fff; ">
        <a class="navbar-brand" href="../home.php">
            <img src="../images/logo.png" alt="logo" style="width: 45%; height:70px; margin-top:-3%" />
            <h4>
                Hortech <span style="color: #00c3ff; font-family: segoe ui">HMS</span>
            </h4>

        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav" style="justify-content: flex-end">
            <ul class="navbar-nav" style="margin-right: 10%; margin-top: -0.5%">
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: #085e79;"> <i class="fa fa-user"></i>&nbsp<?php if ($sex == 'Male') {
                                echo "Mr  ", $username;
                            }else{
                                echo "Mrs  ", $username;
                            }  ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link" style="color: #085e79;"><i
                            class="fa fa-sign-out"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>



</body>

</html>
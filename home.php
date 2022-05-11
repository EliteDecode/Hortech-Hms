<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="styling/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="styling/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="styling/home.css" />
    <link rel="stylesheet" href="styling/header.css" />

    <title>Welcome to Hortech HMS</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white text-dark">
        <div class="navbar-brand">
            <img src="images/logo.png" alt="logo" style="width: 45%; height:70px; margin-top:-2.6%" />
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
                    <a href="admin/adminLogin.php" class="nav-link">Admin</a>
                </li>
                <li class="nav-item">
                    <a href="doctor/doctorlogin.php" class="nav-link">Doctor</a>
                </li>
                <li class="nav-item">
                    <a href="patient/patientlogin.php" class="nav-link">Patient</a>
                </li>
            </ul>
        </div>
    </nav>
    <section class="wrap container">
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <div class="card shadow">
                    <img src="images/doctors1).jpeg" alt="" style="width:100%; " />
                    <h6>
                        Not a registered doctor with Hortech Hospitals? click the button, to get
                        started.
                    </h6>
                    <a href="doctor/register.php"><button class="btn btn-info">Register Now</button></a>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="card shadow">
                    <img src="images/patient.jpg" alt="" style="width:100%" />
                    <h6>
                        Put your health and that of your loved one's in our hands.
                        Register with us today
                    </h6>
                    <a href="patient/register.php"><button class="btn btn-info">Register Now</button></a>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="card shadow">
                    <img src="images/info.jpeg" alt="" style="width:100%" />
                    <h6>
                        Find out more about HORTECH
                        <span style="color: #00c3ff; font-family: segoe ui">SOLUTIONS</span>
                        <br />
                        <br />
                        <br />
                    </h6>
                    <button class="btn btn-info">Apply Now</button>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
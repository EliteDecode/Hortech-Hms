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
    <title>Admin Dashboard</title>
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
            <div class="col-md-10 col-lg-10 col-xl-10" style="background-color: rgba(255, 255, 255, 0.207);">
                <div id="msg"></div>
                <div id="show">

                </div>
            </div>
        </div>
    </section>



    <script>
    var jobs = new XMLHttpRequest();

    var method = 'POST';
    var url = "ajax/ajaxjobs.php";

    jobs.open(method, url, true);

    jobs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    jobs.onreadystatechange = function() {
        if (jobs.readyState == 4 && jobs.status == 200) {
            var data = jobs.responseText;
            console.log(data);
            document.getElementById('show').innerHTML = data;

        }
    }

    jobs.send();


    function approve(e) {
        var approve_id = e.id;

        var approve = new XMLHttpRequest();

        var method = 'POST';
        var url = "ajax/ajaxapprove.php";
        var vars = "id=" + approve_id;



        console.log(vars);
        approve.open(method, url, true);

        approve.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        approve.onreadystatechange = function() {
            if (approve.readyState == 4 && approve.status == 200) {
                var data = approve.responseText;
                console.log(data);
                document.getElementById('msg').innerHTML = data;

            }
        }

        approve.send(vars);


    }

    function reject(e) {
        var reject_id = e.id;

        var reject = new XMLHttpRequest();

        var method = 'POST';
        var url = "ajax/ajaxreject.php";
        var vars = "id=" + reject_id;



        console.log(vars);
        reject.open(method, url, true);

        reject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        reject.onreadystatechange = function() {
            if (reject.readyState == 4 && reject.status == 200) {
                var data = reject.responseText;
                console.log(data);
                document.getElementById('msg').innerHTML = data;

            }
        }

        reject.send(vars);


    }
    </script>
</body>

</html>
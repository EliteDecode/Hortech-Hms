<?php
  session_start();
  include('../includes/connect.php');

  if (!isset($_SESSION['patient'])) {
    
    header('location: patientlogin.php');
  }elseif (isset($_SESSION['patient'])) {
      $un = $_SESSION['patient'];
      $date =date("jS M Y H:i:s"); 
      $sql = "UPDATE patient SET Active ='ONLINE', loginTime = '$date', logoutTime = '' WHERE Username = '$un'";
      $result = mysqli_query($conn, $sql);
 
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
    <title>Patient Dashboard</title>


    <style>
    .report_form {
        box-shadow: 2px 4px 13px #008cba;
    }

    .blur {
        filter: blur(2px);


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
            <div class="col-md-10 col-lg-10 col-xl-10" style="background-color: rgba(255, 255, 255, 0.207);">
                <div class="row container">

                    <div class="col-md-6 col-lg-6 col-xl-6 col-sm-6">


                        <?php

                          $user = $_SESSION['patient'];
                          if (isset($_POST['add'])) {
                            $patient =  ucfirst($_POST['patient']) ;
                            $doctor = ucfirst($_POST['doctor']);
                            $title = ucfirst($_POST['title']);
                            $report = $_POST['report'];

                           
                            
                           $sql = "SELECT * FROM report WHERE Patient ='$user'";
                           $result = mysqli_query($conn,$sql);
                           
                          


                            $error = array();

                            if (empty($patient)) {
                                $error['add'] = "Provide Your Username";
                            }elseif (empty($doctor)) {
                                $error['add'] = "Provide Doctor's Name";
                            }elseif (empty($title)) {
                                $error['add'] = "Provide Report Title";
                            }elseif (empty($report)) {
                                $error['add'] = "Add Your Report";
                            }elseif ($user != $patient) {
                                $error['add'] = "Invalid Patient Username";
                            }

                            while( $row = mysqli_fetch_assoc($result)
                        ){
                            if (isset($row)) {
                                $tt = $row['Title'];
                               if($title == $tt){
                                   $error['add'] = "You've sent a Report with same Title";
                               }
                           }
    
                        }

                          

                            if (count($error) == 0) {
                                 
                         $sql = "INSERT INTO `report` (Patient, Doctor,Title, Report, Feedback, DateReg, Stats)
                          VALUES (?,?,?,?,?,?,?);";
                                     //preparing a prepared statement

                                    $stmt = mysqli_stmt_init($conn);
                                    $date =date("jS M Y H:i:s"); 
                                    $stats = 'Pending';
                                    $feedback = "Not yet";
                                     mysqli_stmt_prepare($stmt, $sql);
                                     
                                    mysqli_stmt_bind_param($stmt, 'sssssss', $patient, $doctor, 
                                    $title, $report,$feedback, $date,$stats);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_close($stmt);

                                     echo ' <script>
                                     function hide(){
                                        var error = document.getElementById("error").style.display="none";
                                     }
                                     setTimeout("hide()", 3000)
                                     </script>
                                     
                                     <div style=" position:absolute; width:66%; margin:3% 10% 5% 5%; z-index:222;" id="error">
                                     <h6 class="alert alert-success text-dark" >Report Sent succesfuly</h6></div>';
                                    
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
                            
                            <div style=" position:absolute; width:66%; margin:3% 10% 5% 5%; z-index:222;" id="error">
                            <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

                         }else{
                             $display = '';
                         }

                         echo $display
                        
                        ?>
                        <!-- ------------------------------Add admin form-------------------------------- -->
                        <button class="btn btn-info "
                            style="margin: 5% 0% 5% 5%; position:absolute;font-weight:bold; font-size:12px"
                            id="add_btn">Send Report
                        </button>
                        <form action="" class="report_form" method="post" id="add_form" style="width:70%; margin:12.5% 5% 0% 5%; border:2px solid 
                             position:relative; #00c3ff; padding:5% 6%;  height:500px; display:none">
                            <i class="fa fa-close"
                                style="position:absolute; margin-left:55%; margin-top:-2%; color:#00c3ff; cursor:pointer "
                                id="close_addform"></i>

                            <div class="form-group" style="margin-top:-1%">
                                <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                                    Username</label>
                                <input type="text" name="patient" class="form-control"
                                    placeholder="Add Admin username..." value="<?php echo $user ?>"
                                    style="border:2px solid #00c3ff; padding:6.5% 3%;
                                    font-size:13px; margin-top:-1.5%; font-weight:bold; border-radius:10px; background-color:#fff; color:#085e79;" />
                            </div>
                            <div class="form-group" style="margin-top:-1%">
                                <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                                    Doctor's Name</label> <br>
                                <select name="doctor" id=""
                                    style="border:2px solid #00c3ff; width:100%; padding:3.5% 3%;
                                    font-size:13px; margin-top:-1.5%; font-weight:bold; border-radius:10px;outline:none; color:#085e79;  ">

                                    <?php  
                                        $sql = "SELECT * FROM doctor WHERE Stats = 'approved'";
                                        $result = mysqli_query($conn,$sql);

                                       while($row = mysqli_fetch_assoc($result)){
                                        $doctorName = $row['Username'];
                                        echo "
                                        <option value='$doctorName'>$doctorName</option>";
                                       
                                    }
                                     ?>

                                </select>
                            </div>
                            <div class="form-group" style="margin-top:-1%">
                                <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                                    Title</label>
                                <input type="text" name="title"
                                    value="<?php echo isset($_POST["add"]) ? $_POST["title"] : '';?>"
                                    class="form-control" placeholder="Add Title..."
                                    style="border:2px solid #00c3ff; padding:6.5% 3%;
                                     font-size:13px; margin-top:-1.5%; color:#085e79; font-weight:bold;border-radius:10px; background-color:#fff;" />
                            </div>
                            <div class="form-group" style="margin-top:-1%">
                                <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                                    Report</label>
                                <textarea name="report" id="" cols="30"
                                    value="<?php echo isset($_POST["add"]) ? $_POST["report"] : '';?>" rows="5"
                                    placeholder="Add report...." class="form-control"
                                    style="border:2px solid #00c3ff; padding:4% 3%;
                                     font-size:13px; margin-top:-1.5%;font-weight:bold; color:#085e79; border-radius:10px; background-color:#fff;"></textarea>
                            </div>


                            <button class="btn  btn-info text-white" style="
                                 
                                    font-size: 14px;
                                    font-weight: bold;
                                " name="add">
                                Send report
                            </button>

                        </form>

                    </div>

                    <div class="col-md-6 col-lg-6 col-xl-6 col-sm-6">
                        <button class="btn btn-info "
                            style="margin: 5% 0% 5% 5%; position:absolute;font-weight:bold; font-size:12px"
                            id="view_report">View Reports
                        </button>

                        <div>
                            <div class="profile_board shadow " style="height:330px; width:94%; background-color:#fff;
                                 margin:12% 0% 0% 0%;z-index:10; position:absolute; padding:4% 4%; display:none;  "
                                id="board" ;>
                                <i class="fa fa-close"
                                    style="position:absolute; margin-left:90%; margin-top:-.1%; color:#00c3ff; cursor:pointer "
                                    id="close_card"></i>
                                <h3 class="text-center"
                                    style="font-size:16px; text-transform:uppercase; color:#085e79;font-weight:bolder;">
                                    Report Details</h3>

                                <div style="margin-top:2%; color:#085e79;" id="status">
                                </div>


                            </div>
                        </div>

                        <div id="table" class="shadow" style=" padding:3% 3%; margin-top:13%; position:relative">
                            <i class="fa fa-close"
                                style="position:absolute; margin-left:90%; margin-top:0%; color:#00c3ff; cursor:pointer "
                                id="close_reports"></i>
                            <?php 
                                        $username = $_SESSION['patient'];
                                        $query = "SELECT * FROM `report` WHERE Patient = '$username'";
                                        $result = mysqli_query($conn, $query);
                                                                            

                         $output = '<table class="table table-bordered "  style="margin-top:10%; color:#085e79;">

                                        <tr  font-size:10px> <th>Title</th>
                                        <th  font-size:10px>Doctor</th>
                                        <th  font-size:10px>Date of report</th>
                                        <th  font-size:10px>Status</th>
                                        <th  font-size:10px>Action</th>
                                        <tr>';

                                        while($row = mysqli_fetch_array($result)){ 
                                        $id = $row['id'];
                                        $report = $row['Report'];
                                        $title = $row['Title'];
                                        $doctor = $row['Doctor'];
                                        $date = $row['DateReg'];
                                        $status = $row['Stats'];


                                        if ($status == 'Delivered') {
                                           
                                            $bg = ' #8bc34a;';
                                            $border = '1px solid #8bc34a';
                                            
                                        }else{
                                           
                                            $bg = '#f37121;';
                                            $border = '1px solid #f37121';
                                        }

                                        if (empty($doctor)) {
                                        $output .= '<tr><td class="text-center" colspan="3">No Report sent</td></tr>';
                                        }else{
                                                                
                                        $output .= "<tr> 
                                        <td style='font-weight:bold; font-size:10px'>$title</td>
                                        <td style='font-weight:bold; font-size:10px'>Dr $doctor</td>
                                        <td style='font-weight:bold; font-size:10px'>$date</td>
                                        <td style='font-weight:bold; font-size:10px'><button
                                         class='btn btn-primary'
                                          style='font-weight:bold; font-size:10px; background-color:$bg;
                                          border:$border;'>$status</button></td>
                                        <td>
                                        <button onclick='view(this)'
                                        style='font-weight:bold; font-size:10px'class='btn btn-info' 
                                        id='$id' >View</button> </td>
                                        <td>
                                    <a href='report.php?deleteid=$id'>
                                    <button style='font-weight:bold; font-size:10px'
                                     class='btn btn-danger'>Remove</button></a>
                                                                                
                                        </td>
                                        ";
                                    }
                                    }
                                        $output .= "</tr> </table>";

                                    

                                        echo $output;
                            
                                                            
                                                    //delete id.
                                                    if (isset($_GET['deleteid'])) {
                                                    
                                                        $id = $_GET['deleteid'];
                                                    
                                                        $sql = "delete from `report` where id = $id";
                                                    
                                                        $result = mysqli_query($conn, $sql);
                                                    }
                                                    ?>


                        </div>

                    </div>



                </div>
            </div>
        </div>
    </section>

    <script>
    document.getElementById('add_btn').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = " block"
    })
    document.getElementById('close_addform').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = "none"
    })
    document.getElementById('view_report').addEventListener('click', e => {
        document.getElementById('table').style.display = "block";
    })
    document.getElementById('close_reports').addEventListener('click', e => {
        document.getElementById('table').style.display = "none";
    })
    document.getElementById('close_card').addEventListener('click', e => {
        document.getElementById('board').style.display = "none";
        document.getElementById('table').classList.remove('blur');

    })


    function view(view) {
        var report_id = view.id;
        console.log(report_id);
        document.getElementById('board').style.display = "block";
        document.getElementById('table').classList.add('blur');



        var xml = new XMLHttpRequest();


        var url = "../admin/ajax/report_view.php";


        var vars = "reportid=" + report_id;

        xml.open("POST", url, true);



        xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xml.onreadystatechange = function() {
            if (xml.readyState == 4 && xml.status == 200) {
                var data = xml.responseText;
                console.log(data);
                document.getElementById('status').innerHTML = data;

            }
        }

        xml.send(vars);

    }
    </script>
</body>

</html>
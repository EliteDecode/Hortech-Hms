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
            <div class="col-md-10 col-lg-10 col-xl-10  container" style="background-color: rgba(255, 255, 255, 0.207);">

                <button class="btn btn-info "
                    style="margin: 1% 0% 5% 5%; position:absolute;font-weight:bold; font-size:14px" id="add_btn">
                    Book An Appointment
                </button>
                <button class="btn btn-info "
                    style="margin: 1% 0% 5% 25%; position:absolute;font-weight:bold; font-size:14px"
                    id="view_report">View Appointments
                </button>



                <?php
                $user = $_SESSION['patient'];
                $sql = "SELECT * FROM patient WHERE Username = '$user'";
                $result = mysqli_query($conn,$sql);

                while ($row = mysqli_fetch_assoc($result)) {
                   $username = $row['Username'];
                   $firstname = $row['Firstname'];
                   $lastname = $row['Lastname'];
                   $email = $row['Email'];
                   $gender = $row['Gender'];
                   $passport = $row['Passport'];
                   $patientid = $row['Patientid'];
                }

                if (isset($_POST['add'])) {
                 
                    $doctor = ucfirst($_POST['doctor']);
                    $title = ucfirst($_POST['title']);
                    $reason = $_POST['reason'];
                    $dateapp = $_POST['date'];

                   $sql = "SELECT * FROM appointments WHERE Username  ='$user'";
                   $result = mysqli_query($conn,$sql);
                   $error = array();

                    if (empty($dateapp)) {
                        $error['add'] = "Provide Your Appointment Date";
                    }elseif (empty($doctor)) {
                        $error['add'] = "Provide Doctor's Name";
                    }elseif (empty($title)) {
                        $error['add'] = "Provide Appointment Title";
                    }elseif (empty($reason)) {
                        $error['add'] = "Add Your Reason For Appointment";
                    }

                    while( $row = mysqli_fetch_assoc($result)
                ){
                    if (isset($row)) {
                        $tt = $row['Title'];
                        $dd = $row['DateApp'];
                       if($title == $tt){
                           $error['add'] = "You've booked an appointment with same Title";
                       }elseif($dd == $dateapp){
                        $error['add'] = "You've booked an appointment on this date";
                       }
                   }

                }
                    if (count($error) == 0) {
                         
                 $sql = "INSERT INTO `appointments` 
                 (Patientid,Firstname, Lastname,Username, Email, Gender, Passport, Doctor, 
                 Title, Reason, DateApp,Datebooked, Feedback, Stats)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                             //preparing a prepared statement

                            $stmt = mysqli_stmt_init($conn);
                            $date =date("jS M Y H:i:s"); 
                            $stats = 'Pending';
                            $feedback = "Not yet";
                             mysqli_stmt_prepare($stmt, $sql);
                             
                            mysqli_stmt_bind_param($stmt, 'isssssssssssss', $patientid,
                             $firstname, $lastname, $username, $email, $gender, $passport, $doctor, 
                            $title, $reason,$dateapp, $date, $feedback,$stats);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);

                             echo ' <script>
                             function hide(){
                                var error = document.getElementById("error").style.display="none";
                             }
                             setTimeout("hide()", 3000)
                             </script>   
                             <div style=" position:absolute; width:66%; margin:1% 10% 5% 5%; z-index:222;" id="error">
                             <h6 class="alert alert-success text-dark" >Appointment Request sent succesfuly</h6></div>';
                            
                            }
                }
                ?>

                <?php 
                         if (isset($error['add'])) {
                            $er = $error['add'];
                            $display = ' <script>
                            function hide(){
                               var error = document.getElementById("error").style.display="none";
                            }
                            setTimeout("hide()", 3000)
                            </script>
                            <div style=" position:absolute; width:66%; margin:1% 10% 5% 5%; z-index:222;" id="error">
                            <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

                         }else{
                             $display = '';
                         }

                         echo $display
                        
                        ?>
                <form action="" class="report_form" method="post" id="add_form" style="width:35%; margin:5% 5% 0% 5%; border:2px solid 
                             position:relative; #00c3ff; padding:4% 4%;  height:500px; display:none">
                    <i class="fa fa-close"
                        style="position:absolute; margin-left:25%; margin-top:-2%; color:#00c3ff; cursor:pointer "
                        id="close_addform"></i>

                    <div class="form-group" style="margin-top:-1%">
                        <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                            Date of Appointment</label>
                        <input type="date" name="date" class="form-control" placeholder="Add Admin username..."
                            value="<?php echo $user ?>"
                            style="border:2px solid #00c3ff; padding:6.5% 3%;
                                    font-size:13px; margin-top:-1.5%; font-weight:bold; border-radius:10px; background-color:#fff; color:#085e79;" />
                    </div>
                    <div class="form-group" style="margin-top:-1%">
                        <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                            Available Doctors</label> <br>
                        <select name="doctor" id=""
                            style="border:2px solid #00c3ff; width:100%; padding:3.5% 3%;
                                    font-size:13px; margin-top:-1.5%; font-weight:bold; border-radius:10px;outline:none; color:#085e79;  ">

                            <?php  
                                        $sql = "SELECT * FROM doctor WHERE Stats = 'approved' AND Available='yes'";
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
                            Title of Appointment</label>
                        <input type="text" name="title"
                            value="<?php echo isset($_POST["add"]) ? $_POST["title"] : '';?>" class="form-control"
                            placeholder="Add Title..."
                            style="border:2px solid #00c3ff; padding:6.5% 3%;
                                     font-size:13px; margin-top:-1.5%; color:#085e79; font-weight:bold;border-radius:10px; background-color:#fff;" />
                    </div>
                    <div class="form-group" style="margin-top:-1%">
                        <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                            Reason for Appointment</label>
                        <textarea name="reason" id="" cols="30" rows="5" placeholder="Add report...."
                            class="form-control" maxlength="70"
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


                <!--view appointment-->



                <div>
                    <div class="profile_board shadow " style="height:330px; width:100%; background-color:#fff;
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


                <?php 
                                        $username = $_SESSION['patient'];
                                        $query = "SELECT * FROM `appointments` WHERE Username = '$user'";
                                        $result = mysqli_query($conn, $query);
                                                                            

                         $output = '<table class="table table-bordered "  style="margin-top:10%; color:#085e79;" id="table">
                                          
                                        <tr  style="font-size:11px"> 
                                        <th>Reason For Appointment</th>
                                        <th>Title</th>
                                        <th>Fee</th>
                                        <th  style="font-size:11px">Doctor</th>
                                        <th  style="font-size:11px">Date of Appointment</th>
                                        <th  style="font-size:11px">Date Booked</th>
                                        <th  style="font-size:11px">Status</th>
                                        <th  style="font-size:11px">Action</th>
                                        <tr>';

                                        while($row = mysqli_fetch_array($result)){ 
                                        $id = $row['id'];
                                        $reason = $row['Reason'];
                                        $title = $row['Title'];
                                        $doctor = $row['Doctor'];
                                        $dateapp = $row['DateApp'];
                                        $datebooked = $row['DateBooked'];
                                        $status = $row['Stats'];
                                       
                                        $sql = "SELECT * FROM invoice WHERE Username = '$user' AND Title = '$title'";

                                        $response = mysqli_query($conn,$sql);

                                        $res = mysqli_fetch_assoc($response);
                                        if (isset($res)) {
                                            $fee = $res['Fee'];
                                        }else{
                                            $fee = 'Not Yet Fixed';
                                        }
                                        


                                        if ($status == 'Delivered') {
                                           
                                            $bg = ' #8bc34a;';
                                            $border = '1px solid #8bc34a';
                                            
                                        }elseif ($status == 'Finished'){
                                          
                                            $bg = '#343a40';
                                            $border = '1px solid #343a40';
                                        }else{
                                            $bg = '#f37121';
                                            $border = '1px solid #f37121';
                                        }

                                        if (empty($doctor)) {
                                        $output .= '<tr><td class="text-center" colspan="3">No Appointments Currently</td></tr>';
                                        }else{
                                                                
                                        $output .= "<tr> 
                                       
                                        <td style='font-weight:bold; font-size:10px'>$reason</td>
                                        <td style='font-weight:bold; font-size:10px'>$title</td>
                                        <td style='font-weight:bold; font-size:10px'>$fee</td>
                                        <td style='font-weight:bold; font-size:10px'>Dr $doctor</td>
                                        <td style='font-weight:bold; font-size:10px'>$dateapp</td>
                                        <td style='font-weight:bold; font-size:10px'>$datebooked</td>
                                       
                                        <td style='font-weight:bold; font-size:10px'><button
                                         class='btn btn-primary'
                                          style='font-weight:bold; font-size:10px; background-color:$bg;
                                          border:$border;'>$status</button></td>
                                      
                                        <td>
                                    <a href='appointments.php?deleteid=$id'>
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
                                                    
                                                        $sql = "delete from `appointments` where id = $id";
                                                    
                                                        $result = mysqli_query($conn, $sql);
                                                    }
                                                    ?>






            </div>
        </div>
    </section>




    <script>
    document.getElementById('add_btn').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = " block"
        document.getElementById('table').style.display = "none";
    })
    document.getElementById('close_addform').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = "none"
    })
    document.getElementById('view_report').addEventListener('click', e => {
        document.getElementById('table').style.display = "block";
        var addForm = document.getElementById('add_form').style.display = " none"
    })
    document.getElementById('close_reports').addEventListener('click', e => {
        document.getElementById('table').style.display = "none";
    })
    document.getElementById('close_card').addEventListener('click', e => {
        document.getElementById('board').style.display = "none";
        document.getElementById('table').classList.remove('blur');

    })
    </script>
</body>

</html>
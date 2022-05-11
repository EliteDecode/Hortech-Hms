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
    .available {
        margin-top: 10%;
    }

    .available .details {
        margin-left: 3%;
        color: #085e79;
    }

    .available .details button {
        margin-bottom: 1%;
    }

    .report_form {
        box-shadow: 2px 4px 13px #008cba;
    }

    .button {
        font-weight: bold;
    }

    .doctorscard {

        height: 470px;
        width: 80%;
        margin: -3% 0% 0% 5%;
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
        margin-bottom: 6%;
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
                            $user = $_SESSION['doctor'];
                          if (isset($_GET['view'])) {
                              $id = $_GET['view'];

                              $sql = "SELECT * FROM appointments WHERE id = $id";
                              $result = mysqli_query($conn,$sql);

                              while($row = mysqli_fetch_assoc($result)){
                                $Patientid = $row['Patientid'];
                                $Passport = $row['Passport'];
                                $Firstname = $row['Firstname'];
                                $Lastname = $row['Lastname'];
                                $Username = $row['Username'];
                                $Gender = $row['Gender'];
                                $Email = $row['Email'];
                                $Dateapp = $row['DateApp'];
                                $Datebooked = $row['DateBooked'];
                                $title=$row['Title'];
                                $reason = $row['Reason'];
                                
                               
                               

                                echo "
                                <div class='img'>
                                <img src='../doctor/images/$Passport' alt='' style='border-radius:100%; width:100%; height:120px'>
                                </div>
                                <h6>Patient's Id: <span>$Patientid</span></h6>
                                <h6>Firstname:<span>$Firstname</span></h6>
                                <h6>Lastname:<span>$Lastname</span></h6>
                                <h6>Username:<span>$Username</span></h6>
                                
                                <h6>Email :<span>$Email</span></h6>
                                <h6>Gender:<span>$Gender</span></h6>
                                <h6>Title of Appointment:<span>$title</span></h6>
                                <h6> Reason for Appointments:<span>$reason</span></h6>
                                <h6>Application of Application:<span>$Dateapp</span></h6>
                                <h6>Application Date:<span>$Datebooked</span></h6>";
                                
                               
                              }
                          }
                        ?>

                        </div>
                    </div>


                    <div class="col-md-8 col-lg-8 col-xl-8">
                        <button class="btn btn-info "
                            style="margin: 3% 0% 5% 5%; position:absolute;font-weight:bold; font-size:14px"
                            id="add_btn">
                            Add Patient Invoice
                        </button>
                        <button class="btn btn-primary "
                            style="margin: 3% 0% 5% 30%; position:absolute;font-weight:bold; font-size:14px"
                            id="view_details">
                            Status of Patient
                        </button>
                        <div class="available col-12" style='display:none' id='details'>
                            <div class="details">
                                <?php
                                 $user = $_SESSION['doctor'];

                                 $sql = "SELECT * FROM appointments WHERE Doctor = '$user' AND Title = '$title'";
                                 $result = mysqli_query($conn,$sql);

                                 $row = mysqli_fetch_assoc($result);
                                 $aa = $row['Stats'];
                                 if ($aa == 'Pending') {
                                    $show = "Patient on Hold, Patient Still Attended To.";
                                    $color = '#f23a2e';
                                 }elseif ($aa == 'Delivered'){
                                    $show = "Patient Discharged";
                                    $color=' #8bc34a';
                                 }
                            ?>
                                <input type="text" value='<?php echo $title?>' id='hidden' hidden>
                                <h6>Done with Appointment?</h6>
                                <button class="btn btn-info" onclick='available(this)'
                                    id='<?php echo $user ?>'>Yes</button>
                                <button class="btn btn-primary" onclick='busy(this)'
                                    id='<?php echo $user ?>'>No</button>
                                <h6>Status: <span id='msg' style='color:<?php echo $color ?>'><?php echo $show ?></span>
                                </h6>
                            </div>
                        </div>

                        <?php
                $user = $_SESSION['doctor'];
                $id = $_GET['view'];
                $sql = "SELECT * FROM appointments WHERE id = '$id'";
                $result = mysqli_query($conn,$sql);

                while ($row = mysqli_fetch_assoc($result)) {
                   $username = $row['Username'];
                   $firstname = $row['Firstname'];
                   $lastname = $row['Lastname'];
                   $email = $row['Email'];
                   $gender = $row['Gender'];
                   $passport = $row['Passport'];
                   $patientid = $row['Patientid'];
                   $title = $row['Title'];
                }

                if (isset($_POST['add'])) {
                 
                    $status = ucfirst($_POST['status']);
                    $description = ucfirst($_POST['description']);
                    $fee = $_POST['fee'];
                    $tilts = $_POST['title'];
                   

                   $sql = "SELECT * FROM invoice WHERE Doctor  ='$user'";
                   $result = mysqli_query($conn,$sql);
                   $error = array();

                    if (empty($fee)) {
                        $error['add'] = "Provide Patient Fee";
                    }elseif (empty($description)) {
                        $error['add'] = "Provide Invoice Description";
                    }elseif($title != $tilts){
                        $error['add'] = "Invalid Invoice Title";
                    }
                    while( $row = mysqli_fetch_assoc($result)
                    ){
                        if (isset($row)) {
                            $tt = $row['Title'];
                           if($title == $tt){
                               $error['add'] = "You've Sent an Invioce on This.";
                           }
                       }
    
                    }

                   
                    if (count($error) == 0) {
                         
                 $sql = "INSERT INTO `invoice` 
                 (Fee,Descrip, Stats,Paid, Doctor, Firstname, Lastname, Username, Email, Passport, Patientid,
                 Gender, DateDischarged, DatePayment, Title
                )
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                             //preparing a prepared statement

                            $stmt = mysqli_stmt_init($conn);
                            
                            $paid = 'Pending';
                            $datePaid = 'Not yet';
                            $dateDischarged = 'Not yet';
                             mysqli_stmt_prepare($stmt, $sql);
                             
                            mysqli_stmt_bind_param($stmt, 'isssssssssissss', $fee, $description, $status, $paid,
                             $user, $firstname, $lastname, $username, $email, $passport, $patientid,  $gender, 
                            $dateDischarged, $datePaid, $title);
                            mysqli_stmt_execute($stmt);
                            $execute = mysqli_stmt_close($stmt);
                             

                            if ($execute) {
                                $date =date("jS M Y H:i:s"); 
                                $sql = "UPDATE invoice SET DateDischarged = '$date' WHERE Doctor = '$user'
                                 AND Title = '$title'";
                                $response = mysqli_query($conn,$sql);

                                echo ' <script>
                                function hide(){
                                   var error = document.getElementById("error").style.display="none";
                                }
                                setTimeout("hide()", 3000)
                                </script>   
                                <div style=" position:absolute; width:66%; margin:2% 10% 5% 5%; z-index:222;" id="error">
                                <h6 class="alert alert-success text-dark" >Appointment Request sent succesfuly</h6></div>';
                               
                            }
                           
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
                            <div style=" position:absolute; width:66%; margin:2% 10% 5% 5%; z-index:222;" id="error">
                            <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

                         }else{
                             $display = '';
                         }

                         echo $display
                        
                        ?>
                        <form action="" class="report_form" method="post" id="add_form"
                            style="width:55%; margin:9.5% 5% 0% 5%; border:2px solid 
                             position:relative; #00c3ff; padding:4% 4%;  height:500px; display:none; border-radius:10px;">
                            <i class="fa fa-close"
                                style="position:absolute; margin-left:43%; margin-top:-2%; color:#00c3ff; cursor:pointer "
                                id="close_addform"></i>
                            <div class="form-group" style="margin-top:-1%">
                                <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                                    Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Add Patient Fee..."
                                    value="<?php echo $title ?>"
                                    style="border:2px solid #00c3ff; padding:6.5% 3%;
                                    font-size:13px; margin-top:-1.5%; font-weight:bold; border-radius:10px; background-color:#fff; color:#085e79;" />
                            </div>

                            <div class="form-group" style="margin-top:-1%">
                                <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                                    Patient Fee</label>
                                <input type="number" name="fee" class="form-control" placeholder="Add Patient Fee..."
                                    style="border:2px solid #00c3ff; padding:6.5% 3%;
                                    font-size:13px; margin-top:-1.5%; font-weight:bold; border-radius:10px; background-color:#fff; color:#085e79;" />
                            </div>
                            <div class="form-group" style="margin-top:-1%">
                                <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                                    Status</label> <br>
                                <select name="status" id=""
                                    style="border:2px solid #00c3ff; width:100%; padding:3.5% 3%;
                                    font-size:13px; margin-top:-1.5%; font-weight:bold; border-radius:10px;outline:none; color:#085e79;  ">

                                    <option value="Discharged">Discharged</option>
                                    <option value="Hospitalized">Hospitalized</option>

                                </select>
                            </div>

                            <div class="form-group" style="margin-top:-1%">
                                <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                                    Description</label>
                                <textarea name="description" id="" cols="30" rows="5"
                                    placeholder="Add invoice discription...." class="form-control" maxlength="70"
                                    style="border:2px solid #00c3ff; padding:4% 3%;
                                     font-size:13px; margin-top:-1.5%;font-weight:bold; color:#085e79; border-radius:10px; background-color:#fff;"></textarea>
                            </div>


                            <button class="btn  btn-info text-white" style="
                                 
                                    font-size: 14px;
                                    font-weight: bold;
                                " name="add">
                                Send Invoice
                            </button>

                        </form>






                    </div>
                </div>
            </div>
        </div>
    </section>




    <script>
    document.getElementById('add_btn').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = " block"
        var addForm = document.getElementById('details').style.display = " none"
    })
    document.getElementById('close_addform').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = "none"
    })
    document.getElementById('add_btn').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = " block"
    })
    document.getElementById('close_addform').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = "none"
    })
    document.getElementById('view_details').addEventListener('click', e => {
        var addForm = document.getElementById('details').style.display = " block"
        var addForm = document.getElementById('add_form').style.display = "none"
    })

    function busy(e) {
        var busy_id = e.id;
        var title = document.getElementById('hidden').value;
        var busy = new XMLHttpRequest();

        var method = 'POST';
        var url = "../admin/ajax/ajax_appointment_hold.php";
        var vars = "username=" + busy_id + "&title=" + title;



        console.log(vars);
        busy.open(method, url, true);

        busy.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        busy.onreadystatechange = function() {
            if (busy.readyState == 4 && busy.status == 200) {
                var data = busy.responseText;
                console.log(data);
                document.getElementById('msg').innerHTML = data;

            }
        }

        busy.send(vars);
    }

    function available(e) {
        var available_id = e.id;
        var title = document.getElementById('hidden').value;
        var available = new XMLHttpRequest();

        var method = 'POST';
        var url = "../admin/ajax/ajax_appointment_done.php";
        var vars = "username=" + available_id + "&title=" + title;



        console.log(vars);
        available.open(method, url, true);

        available.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        available.onreadystatechange = function() {
            if (available.readyState == 4 && available.status == 200) {
                var data = available.responseText;
                console.log(data);
                document.getElementById('msg').innerHTML = data;

            }
        }

        available.send(vars);
    }
    </script>
</body>

</html>
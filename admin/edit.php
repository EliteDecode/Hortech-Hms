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

                              $sql = "SELECT * FROM doctor WHERE id = $id";
                              $result = mysqli_query($conn,$sql);

                              while($row = mysqli_fetch_assoc($result)){
                                $doctorid = $row['Doctorid'];
                                $Firstname = $row['Firstname'];
                                $Lastname = $row['Lastname'];
                                $Username = $row['Username'];
                                $Gender = $row['Gender'];
                                $Passport = $row['Passport'];
                                $Resume = $row['Cv'];
                                $Email = $row['Email'];
                                $DateReg = $row['DateReg'];
                                $Salary = $row['Salary'];
                                $password = $row['Pwd'];

                                echo "
                                <div class='img'>
                                <img src='../doctor/images/$Passport' alt='' style='border-radius:100%; width:100%; height:120px'>
                                </div>
                                <h6>Doctors Id: <span>$doctorid</span></h6>
                                <h6>Firstname:<span>$Firstname</span></h6>
                                <h6>Lastname:<span>$Lastname</span></h6>
                                <h6>Username:<span>$Username</span></h6>
                                <h6>Email :<span>$Email</span></h6>
                                <h6>Gender:<span>$Gender</span></h6>
                                
                                <h6>Resume:<span><a href ='../doctor/pdf/$Resume' style='color:#00c3ff'>View Resume</a></span></h6>
                                <h6>Application Date:<span>$DateReg</span></h6>
                                <h6>Salary:<span><i class='fa fa-euro'></i>&nbsp$Salary</span></h6>";
                              }
                          }
                        ?>

                        </div>
                    </div>


                    <div class="col-md-4 col-lg-4 col-xl-4">


                        <!--update salary form-->

                        <?php

                        

                        if (isset($_POST['update'])) {
                           
                            
                            $Salary = $_POST['salary'];

                            
                            $error = array();

                            if (empty($Salary)) {
                               $error['salary'] = "Input Doctor's Salary";
                            }

                            if (count($error) == 0) {
                                $sql = "UPDATE  `doctor` SET Salary = ? WHERE id = $id";

                                //preparing a prepared statement
    
                                $stmt = mysqli_stmt_init($conn);
    
                                mysqli_stmt_prepare($stmt, $sql);
    
                                mysqli_stmt_bind_param($stmt, 'i', $Salary);
                                $result = mysqli_stmt_execute($stmt);
    
                                if ($result) {
                                    $show = '<script>
                                    function hide(){
                                       var error = document.getElementById("error").style.display="none";
                                    }
                                    setTimeout("hide()", 3000)
                                    </script>
                                    
                                    <div style=" position:absolute; width:83%; margin:3% 10% 5% 0%" id="error">
                                    <h6 class="alert alert-success text-dark" >Doctors Salary Updated succesfuly</h6></div>';
                                }
                                mysqli_stmt_close($stmt);
                                echo $show;
                                }
    
                            }

                            if (isset($error['salary'])) {
                                $er = $error['salary'];
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
                        <button class="btn btn-info" id="btn_s"
                            style="margin-top:5%; margin-right:9%; float:right; font-weight: bold; font-size:13px">Update
                            Salary</button>
                        <button class="btn btn-info" id="btn_m"
                            style="margin-top:5%; margin-right:9%; float:right;font-weight: bold;font-size:13px ">Send
                            Message</button>

                        <form action="" class=" salary_form" method="post" style="position:relative; display:none"
                            id="form_s">
                            <h6>Doctor's Salary</h6>
                            <i class="fa fa-close"
                                style="position:absolute; top:17px; left:90%;color:#17a2b8; cursor:pointer"
                                id="close_s"></i>

                            <div class="form-group">

                                <label for="salary" style="font-size:12px; font-weight:bold;">Salary</label>
                                <input type="text" name="salary" class="form-control"
                                    value="<?php echo isset($_GET["editid"]) ? $Salary : '';?>" />
                            </div>
                            <button class="btn  btn-info text-white" style="font-size: 14px; font-weight: bold;"
                                name="update">
                                Update Salary
                            </button>

                        </form>


                        <?php

                        $user = $_SESSION['admin'];
                        

                       if (isset($_POST['send'])) {
                        $id = $_GET['editid'];

                        $msg = $_POST['msg'];
                        $sentby = $_SESSION['admin'];
                        $title = ucfirst($_POST['title']);
                        $sql = "SELECT * FROM `message` WHERE MsgSentBy ='$user'";
                        $result = mysqli_query($conn,$sql);
                         
                        
                       

                        
                      
                        $error = array();

                        if (empty($msg)) {
                           $error['msg'] = "Whats Your Message?";
                        }elseif(empty($title)){
                            $error['msg'] = "Whats Your Message Title?";
                        }
                        while( $row = mysqli_fetch_assoc($result)
                        ){
                            if (isset($row)) {
                                $tt = $row['Title'];
                               if($title == $tt){
                                   $error['msg'] = "You've sent a Message with same Title";
                               }
                           }
    
                        }

                      

                        

                        if (count($error) == 0) {
                            $sql = "INSERT INTO `message`
                        (MsgSentBy, Reciever,Title, Msg, DateSent, Stats, DateView
                            )
                    VALUES (?,?,?,?,?,?,?);";

                            //preparing a prepared statement

                            $stmt = mysqli_stmt_init($conn);

                            mysqli_stmt_prepare($stmt, $sql);

                            $stat = 'Pending';
                            $date =date("jS M Y H:i:s"); 
                            $date_view = 'Not Yet Viewed';

                            mysqli_stmt_bind_param($stmt, 'sssssss', $sentby, $Username, $title, $msg, $date, $stat,  $date_view );
                            $result = mysqli_stmt_execute($stmt);

                            if ($result) {
                                $show = '<script>
                                function hide(){
                                   var error = document.getElementById("error").style.display="none";
                                }
                                setTimeout("hide()", 3000)
                                </script>
                                
                                <div style=" position:absolute; width:83%; margin:3% 10% 5% 2%" id="error">
                                <h6 class="alert alert-success text-dark" >Message sent succesfuly</h6></div>';
                            }
                            mysqli_stmt_close($stmt);
                            echo $show;
                            }

                        

                        if (isset($error['msg'])) {
                            $er = $error['msg'];
                            $display = ' <script>
                            function hide(){
                               var error = document.getElementById("error").style.display="none";
                            }
                            setTimeout("hide()", 3000)
                            </script>
                            
                            <div style=" position:absolute; width:85%; margin:3% 10% 5% 2%" id="error">
                                <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

                         }else{
                             $display = '';
                         }

                         echo $display;

                        
                       
                    }

                        ?>

                        <form action="" class=" send_form" method="post" id="form_m" style="display:none">
                            <i class="fa fa-close"
                                style="position:absolute; margin-left:85%; color:#17a2b8; cursor:pointer"
                                id="close_m"></i>
                            <div class="form-group" style="margin-top:-1%">
                                <label for="title" style="font-size:12px; font-weight:bold; color:#085e79;">
                                    Title</label>
                                <input type="text" name="title"
                                    value="<?php echo isset($_POST["send"]) ? $_POST["title"] : '';?>"
                                    class="form-control" placeholder="Add Title..."
                                    style="border:2px solid #00c3ff; padding:6.5% 3%;
                                     font-size:13px; margin-top:-1.5%; color:#085e79; font-weight:bold;border-radius:10px; background-color:#fff;" />
                            </div>


                            <div class="form-group">
                                <label for="msg" style="font-size:12px; font-weight:bold;">Messgae</label>
                                <textarea name="msg" id="" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <button class="btn  btn-info text-white" style="font-size: 14px; font-weight: bold;"
                                name="send">
                                SEND
                            </button>

                        </form>

                    </div>

                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <!--------------------------------Edit admin form-------------------------------- -->
                        <?php

                            if (isset($_POST['edit'])) {
                            
                                
                                $username = ucfirst($_POST['username']);
                                $doctorid = $_POST['doctorid'];
                                $password = $_POST['password'];
     
                                $sql = "SELECT * FROM doctor WHERE id != '$id'";
                                $result = mysqli_query($conn,$sql);

                               
                              

                               
                                $error = array();

                                if (empty($username)) {
                                $error['edit'] = "Input Username";
                                }else if (empty($doctorid)) {
                                    $error['edit'] = "Input Id";
                                 }else if (empty($password)) {
                                    $error['edit'] = "Input Password";
                                 }

                                 while($row = mysqli_fetch_assoc($result)){
                                    $dd = $row['Doctorid'];
                                    $un = $row['Username'];
                                    if ($dd == $doctorid){
                                        $error['edit'] = "ID Already Taken";
                                     }elseif ($un == $username) {
                                        $error['edit'] = "Username Already Taken";
                                     }
                                }

                                if (count($error) == 0) {
                                    $sql = "UPDATE  `doctor` SET Username = ?, Doctorid = ?, Pwd= ? WHERE id = $id";

                                    //preparing a prepared statement

                                    $stmt = mysqli_stmt_init($conn);

                                    mysqli_stmt_prepare($stmt, $sql);

                                    mysqli_stmt_bind_param($stmt, 'sis', $username, $doctorid, $password);
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
                            <h6>Doctor's Info Edit</h6>

                            <div class="form-group">
                                <label for="doctorid" style="font-size:12px; font-weight:bold;">Doctor's Id</label>
                                <input type="number" name="doctorid" class="form-control"
                                    value="<?php echo isset($_GET["editid"]) ? $doctorid : '';?>" />
                            </div>
                            <div class="form-group">
                                <label for="username" style="font-size:12px; font-weight:bold;">Username</label>
                                <input type="text" name="username" class="form-control"
                                    value="<?php echo isset($_GET["editid"]) ? $Username : '';?>" />
                            </div>
                            <div class="form-group">
                                <label for="password" style="font-size:12px; font-weight:bold;">Password</label>
                                <input type="password" name="password" class="form-control"
                                    value="<?php echo isset($_GET["editid"]) ? $password : '';?>" />
                            </div>
                            <button class="btn  btn-info text-white" style="font-size: 14px; font-weight: bold;"
                                name="edit">
                                Update Info
                            </button>

                        </form>

                        <div class="status " id="status" style="position:relative; display:none">
                            <i class="fa fa-close" style="position:absolute; left:90%; color:#17a2b8; cursor:pointer"
                                id="close_status"></i>


                            <?php
                                 if (isset($_GET['editid'])) {
                                    $id = $_GET['editid'];

                                    $sql = "SELECT * FROM doctor WHERE id = $id";
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
    document.getElementById('btn_m').addEventListener('click', e => {
        document.getElementById('form_m').style.display = "block";
        document.getElementById('form_s').style.display = "none";
    })
    document.getElementById('btn_s').addEventListener('click', e => {
        document.getElementById('form_s').style.display = "block";
        document.getElementById('form_m').style.display = "none";
    })
    document.getElementById('btn_status').addEventListener('click', e => {
        document.getElementById('form_u').style.display = "none";
        document.getElementById('status').style.display = "block";
    })
    document.getElementById('btn_update').addEventListener('click', e => {
        document.getElementById('form_u').style.display = "block";
        document.getElementById('status').style.display = "none";
    })

    document.getElementById('close_m').addEventListener('click', e => {
        document.getElementById('form_m').style.display = "none";
    })
    document.getElementById('close_u').addEventListener('click', e => {
        document.getElementById('form_u').style.display = "none";

    })
    document.getElementById('close_s').addEventListener('click', e => {
        document.getElementById('form_s').style.display = "none";
    })
    document.getElementById('close_status').addEventListener('click', e => {
        document.getElementById('status').style.display = "none";
    })
    </script>
</body>

</html>
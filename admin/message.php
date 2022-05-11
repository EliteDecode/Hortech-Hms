<?php
  session_start();

  if (!isset($_SESSION['admin'])) {
    header('location: doctorlogin.php');
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
    .wrap_doctor {
        width: 40%;
        margin-top: -28%;
        float: right;
        z-index: 222 !important;

    }

    .wrap_doctor form {
        position: relative;
        width: 80%;
        margin: 0% 0% 0% 20%;
        padding: 3% 4%;
        z-index: 222 !important;
        background-color: #fff;
        box-shadow: 2px 4px 13px #008cba;
        border-radius: 10px;
    }

    .send_form {
        width: 35%;
        margin: 1.2% 0% 0% 0%;
        padding: 4% 4%;
        box-shadow: 2px 4px 13px #008cba;
        position: absolute;
        display: none;
        border-radius: 10px;
        z-index: 2;
        background-color: #fff;
    }


    .report_form {
        box-shadow: 2px 4px 13px #008cba;
        border-radius: 10px;
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
            <div class="col-md-10 col-lg-10 col-xl-10 "
                style="background-color: rgba(255, 255, 255, 0.207); position:relative ">
                <div id="msg"></div>
                <button class="btn btn-info" id='show_recieved'
                    style="margin-top:2%; font-weight:bold; font-size:14px;">Recived Messages</button>
                <button class="btn btn-info" id='show_sent'
                    style="margin-top:2%; font-weight:bold; font-size:14px;">Sent Messages</button>
                <button class="btn btn-info "
                    style="margin: 2% 0% 2% .4%; position:absolute;font-weight:bold; font-size:14px" id="add_btn">Send A
                    Message
                </button>

                <div class='send_form' id="form_m">


                    <?php
                    $user = $_SESSION['admin'];
                    $sqll = "SELECT * FROM `message` WHERE MsgSentBy = '$user'  ";

                    $resultt = mysqli_query($conn, $sqll);

                    $query = "SELECT * FROM `message` WHERE Reciever = '$user'  ";
                    $response = mysqli_query($conn, $query);
                    $rows = mysqli_fetch_assoc($response);
                   
                    if (isset($_POST['reply'])) {
                  
                   
                    $replymsg = $_POST['msg'];
                    $replysentby = $_SESSION['admin'];
                    $replytitle = $_POST['title'];

                    $error = array();

                    if (empty($replymsg)) {
                        $error['reply'] = "Whats Your Message?";
                    }elseif(empty($replytitle)){
                        $error['reply'] = "Whats Your Message Title?";
                    }
                    while( $row = mysqli_fetch_assoc($resultt)
                        ){
                            if (isset($row)) {
                                $tt = $row['Title'];
                               if($title == $tt){
                                   $error['msg'] = "You've sent a Report with same Title";
                               }
                           }
    
                        }
                   

                    if (count($error) == 0) {
                        $sql = "INSERT INTO `message`
                        (MsgSentBy, Reciever,Title, Msg, DateSent, Stats, DateView, Reply
                            )
                    VALUES (?,?,?,?,?,?,?,?);";
                       
                        $replywho = $rows['MsgSentBy'];
                        $titlefromadmin = $rows['Title'];

                            //preparing a prepared statement

                            $stmt = mysqli_stmt_init($conn);

                            mysqli_stmt_prepare($stmt, $sql);

                            $stat = 'Pending';
                            $date =date("jS M Y H:i:s"); 
                            $date_view = 'Not Yet Viewed';
                            $reply = 'adminreplied';

                            mysqli_stmt_bind_param($stmt, 'ssssssss',
                             $replysentby, $replywho, $replytitle, $replymsg, $date, $stat,  $date_view, $reply );
                            $result = mysqli_stmt_execute($stmt);

                        if ($result) {
                            $query = "UPDATE  `message` SET Reply = 'adminreplied' WHERE Reciever = '$user'
                            AND Title = '$replytitle'  ";
   
                           $response = mysqli_query($conn, $query);
                            $show = '<script>
                            alert("Your Reply Have been sent")
                          </script>';
                        }
                        mysqli_stmt_close($stmt);
                        echo $show;
                        }

                    
                     

                        if (isset($error['reply'])) {
                        $er = $error['reply'];
                        $display = '  <script>
                        alert("Something went wrong. you have sent a reply to this message or  inputs are  empty")
                      </script>';

                        }else{
                        $display = '';
                        }

                        echo $display;



                        }

                        ?>

                    <form action="" class=" " method="post">
                        <i class="fa fa-close" style="position:absolute; margin-left:75%; color:#17a2b8; cursor:pointer"
                            id="close_m"></i>
                        <div class="form-group" style="margin-top:-1%">
                            <label for="title" style="font-size:12px; font-weight:bold; color:#085e79;">
                                Title</label>
                            <input type="text" name="title" class="form-control" value='' id='title'
                                placeholder="Add Title..."
                                style="border:2px solid #00c3ff; padding:6.5% 3%;
              font-size:13px; margin-top:-1.5%; color:#085e79; font-weight:bold;border-radius:10px; background-color:#fff;" />
                        </div>


                        <div class="form-group">
                            <label for="msg" style="font-size:12px; font-weight:bold;">Messgae</label>
                            <textarea name="msg" id="" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <button class="btn  btn-info text-white" style="font-size: 14px; font-weight: bold;"
                            name="reply" id=<?php echo  $user ?>>
                            REPLY
                        </button>

                    </form>

                </div>

                <div id="recieved" style='display:none; padding:3%' class="shadow">
                    <i class="fa fa-close" style="position:absolute; margin-left:90%; color:#17a2b8; cursor:pointer"
                        id="close_recieved"></i>
                    <?php 
                     

                    include_once('../includes/connect.php');

                    $user = $_SESSION['admin'];

                    $sql = "SELECT * FROM `message` WHERE Reciever = '$user' ";

                    $result = mysqli_query($conn, $sql);

                 


                    $output = "";

                    $output .= "<table class='table table-bordered   text-center' style='z-index:0;
                    margin-top:7%; color:#085e79;' >
                                <tr> 
                                <th style='font-size:13px'>Sent By</th>
                                <th style='font-size:13px'>Title</th>
                                <th style='font-size:13px'>Message</th>
                                <th style='font-size:13px'>Date Sent</th>
                                <th style='font-size:13px'>Action</th>
                                
                                
                                </tr>";

                    if (mysqli_num_rows($result) < 1) {
                        $output .= "<tr><td colspan='11'>No Message currently.</td></tr>";
                    }elseif (mysqli_num_rows($result)) {
                        while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $who = $row['MsgSentBy'];
                            $title = $row['Title'];
                            $msg = $row['Msg'];
                            $date = $row['DateSent'];
                            $reply = $row['Reply'];

                            if ($reply == 'replied') {
                               $disabled = 'disabled';
                               $bg = 'success';
                               $cont = 'Doctor Replied';
                               $cursor = 'not-allowed';
                            }else if($reply == 'adminreplied'){
                                $disabled = 'disabled';
                                $bg = 'warning';
                                $cont = 'Replied';
                                $cursor = 'not-allowed';
                            }
                            else{
                                $disabled = '';
                                $bg = 'secondary';
                                $cont = 'Reply';
                                $cursor = 'pointer';
                            }
                           
                           
                            
                            $output .= "<tr> 
                                        <td style='font-size:12px; font-weight:bolder;'>Doctor $who</td>
                                        <td style='font-size:12px; font-weight:bolder;'>$title</td>
                                        <td style='font-size:12px; font-weight:bolder;'>$msg</td>
                                        <td style='font-size:12px; font-weight:bolder;'>$date</td>
                                        <td font-weight:bold;'>
                                       
                                        <button class='btn btn-$bg text-white' style='font-size:12px;
                                        font-weight:bold; cursor:$cursor' id='$id'  onclick='show(this)' $disabled>$cont</button>"
                                        
                                        ;
                        }
                    }

                    $output .= "</tr>
                                </table>";
                    echo $output;
                    ?>




                </div>


                <!-- Sent messages -->


                <div id="sent" style='display:none; padding:3%' class="shadow">
                    <i class="fa fa-close" style="position:absolute; margin-left:90%; color:#17a2b8; cursor:pointer"
                        id="close_sent"></i>
                    <?php 
                     

                    include_once('../includes/connect.php');

                    $user = $_SESSION['admin'];

                    $sql = "SELECT * FROM `message` WHERE MsgSentBy = '$user' ";

                    $result = mysqli_query($conn, $sql);

                 


                    $output = "";

                    $output .= "<table class='table table-bordered   text-center' style='z-index:0;
                    margin-top:7%; color:#085e79;' >
                                <tr> 
                                <th style='font-size:13px'>Sent To</th>
                                <th style='font-size:13px'>Title</th>
                                <th style='font-size:13px'>Message</th>
                                <th style='font-size:13px'>Date Sent</th>
                               
                                
                                
                                </tr>";

                    if (mysqli_num_rows($result) < 1) {
                        $output .= "<tr><td colspan='11'>No Message currently.</td></tr>";
                    }elseif (mysqli_num_rows($result)) {
                        while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $who = $row['Reciever'];
                            $title = $row['Title'];
                            $msg = $row['Msg'];
                            $date = $row['DateSent'];
                           
                           
                            
                            $output .= "<tr> 
                                        <td style='font-size:12px; font-weight:bolder;'>Doctor $who</td>
                                        <td style='font-size:12px; font-weight:bolder;'>$title</td>
                                        <td style='font-size:12px; font-weight:bolder;'>$msg</td>
                                        <td style='font-size:12px; font-weight:bolder;'>$date</td>  
                                        "
                                        
                                        ;
                        }
                    }

                    $output .= "</tr>
                                </table>";
                    echo $output;
                    ?>
                </div>



                <!-- ------------------------------send messages-------------------------------- -->
                <?php

                        $user = $_SESSION['admin'];
                        

                       if (isset($_POST['send_msg'])) {
                       

                        $msg = $_POST['msg'];
                        $sentby = $_SESSION['admin'];
                        $title = ucfirst($_POST['title']);
                        $doctor = $_POST['doctor'];
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

                            mysqli_stmt_bind_param($stmt, 'sssssss', $sentby, $doctor, $title, $msg, $date, $stat,  $date_view );
                            $result = mysqli_stmt_execute($stmt);

                            if ($result) {
                                $show = '<script>
                                function hide(){
                                   var error = document.getElementById("error").style.display="none";
                                }
                                setTimeout("hide()", 3000)
                                </script>
                                
                                <div style=" position:absolute; width:83%; margin:-3.5% 10% 5% 0%" id="error">
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
                            
                            <div style=" position:absolute; width:85%; margin:-3.5% 10% 5% 0%" id="error">
                                <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

                         }else{
                             $display = '';
                         }

                         echo $display;

                        
                       
                    }

                        ?>

                <form action="" class="report_form " method="post" id="add_form" style="width:35%; margin:1% 5% 0% 0%; border:2px solid 
                             position:relative; #00c3ff; padding:2% 2%;  height:500px; display:none">
                    <i class="fa fa-close"
                        style="position:absolute; margin-left:29%; margin-top:-1%; color:#00c3ff; cursor:pointer "
                        id="close_addform"></i>

                    <div class="form-group" style="margin-top:-1%">
                        <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                            Username</label>
                        <input type="text" name="sender" class="form-control" placeholder="Add Admin username..."
                            value="<?php echo $user ?>"
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
                            value="<?php echo isset($_POST["add"]) ? $_POST["title"] : '';?>" class="form-control"
                            placeholder="Add Title..."
                            style="border:2px solid #00c3ff; padding:6.5% 3%;
                                     font-size:13px; margin-top:-1.5%; color:#085e79; font-weight:bold;border-radius:10px; background-color:#fff;" />
                    </div>
                    <div class="form-group" style="margin-top:-1%">
                        <label for="username" style="font-size:12px; font-weight:bold; color:#085e79;">
                            Message</label>
                        <textarea name="msg" id="" cols="30"
                            value="<?php echo isset($_POST["add"]) ? $_POST["report"] : '';?>" rows="5"
                            placeholder="Add report...." class="form-control"
                            style="border:2px solid #00c3ff; padding:4% 3%;
                                     font-size:13px; margin-top:-1.5%;font-weight:bold; color:#085e79; border-radius:10px; background-color:#fff;"></textarea>
                    </div>


                    <button class="btn  btn-info text-white" style="
                                 
                                    font-size: 14px;
                                    font-weight: bold;
                                " name="send_msg">
                        Send Message
                    </button>

                </form>

            </div>




        </div>
        </div>
    </section>




    <script>
    document.getElementById('show_recieved').addEventListener('click', e => {
        document.getElementById('recieved').style.display = 'block';
        document.getElementById('sent').style.display = 'none';
        var addForm = document.getElementById('add_form').style.display = " none";

    });
    document.getElementById('close_recieved').addEventListener('click', e => {
        document.getElementById('recieved').style.display = 'none';

    });
    document.getElementById('show_sent').addEventListener('click', e => {
        document.getElementById('sent').style.display = 'block';
        document.getElementById('recieved').style.display = 'none';
        var addForm = document.getElementById('add_form').style.display = " none";

    });
    document.getElementById('close_sent').addEventListener('click', e => {
        document.getElementById('sent').style.display = 'none';

    });
    document.getElementById('close_m').addEventListener('click', e => {
        document.getElementById('form_m').style.display = "none";
    })
    document.getElementById('add_btn').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = " block";
        document.getElementById('sent').style.display = 'none';
        document.getElementById('recieved').style.display = 'none';
    })
    document.getElementById('close_addform').addEventListener('click', e => {
        var addForm = document.getElementById('add_form').style.display = "none"
    })






    function show(e) {
        document.getElementById('form_m').style.display = "block";

        var input_id = e.id;
        console.log('input_id');


        var vars = "id=" + input_id;

        var input = new XMLHttpRequest();

        var method = "POST";
        var url = "ajax/ajax_get_input_title.php";
        var sync = true;

        input.open(method, url, sync);

        input.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        input.onreadystatechange = function() {
            if (input.readyState == 4 && input.status == 200) {
                var data = input.responseText;
                console.log(data);
                document.getElementById('title').value = data;

            }
        }

        input.send(vars);

    }
    </script>
</body>

</html>
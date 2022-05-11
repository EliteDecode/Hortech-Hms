<?php

 
include('../includes/connect.php');
//Updat of profile picture codes
if (isset($_POST['update_p'])) {
    $un = $_SESSION['patient'];
    
    $Passport = $_FILES["passport"]["name"];
    $tempnamePassport = $_FILES["passport"]["tmp_name"];
    $folderpassport = "images/" . $Passport;
    

    
    $error = array();

    if (empty($Passport)) {
    $error['passport'] = "Input Doctor's Profile Picture";
    }

    if (count($error) == 0) {
        $sql = "UPDATE  `patient` SET Passport = ? WHERE Username = '$un'";

        //preparing a prepared statement

        $stmt = mysqli_stmt_init($conn);

        mysqli_stmt_prepare($stmt, $sql);

        mysqli_stmt_bind_param($stmt, 's', $Passport);
        $result = mysqli_stmt_execute($stmt);
        move_uploaded_file($tempnamePassport, $folderpassport);

        if ($result) {
            $show = ' <script>
            function hide(){
            var error = document.getElementById("error").style.display="none";
            }
            setTimeout("hide()", 3000)
            </script>
            
            <div style=" position:absolute; width:83%; margin:1% 10% 5% 0%" id="error">
            <h6 class="alert alert-success text-dark" >Profile picture Updated succesfuly</h6></div>';
        }
        mysqli_stmt_close($stmt);
        echo $show;
        }

    }

    if (isset($error['passport'])) {
        $er = $error['passport'];
        $display = ' 
        
        <div style=" position:absolute; width:83%; margin:1% 10% 5% 0%" id="error">
            <h6 class="alert alert-danger text-dark" >'.$er.'</h6></div>';

    }else{
        $display = '';
    }

    echo $display


    ?>
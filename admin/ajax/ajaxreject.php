<?php
include_once('../../includes/connect.php');
include_once('../../phpmailer/sendmail.php');

$response = $_POST['id'];

$sql = "UPDATE doctor SET Stats = 'rejected' WHERE id = '$response'";

$result = mysqli_query($conn, $sql);

if ($result) {
    $query = "SELECT * FROM doctor WHERE id = '$response'";
    $resp = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($resp)){
      $firstname = $row['Firstname'];
      $lastname = $row['Lastname'];
      $email = $row['Email'];

       //   //
       $mailer = new SendMail();
       $subject = "Application Rejected";
          
        $message = "<div style='display: block; margin: 10px auto; width: 90%; font-family: arial; color: #223b45; text-align: center;'>
        <img src='' />
        <div style='background: #fafafa; border-radius: 5px; margin: 10px 0; padding: 20px;'>
            <h3 style='font-family: arial; font-weight: 300'>Hi ". $firstname.' '.$lastname .",</h3>
            <p style='font-weight: 100;'>Your Application for a role of a Doctor in Hortech Hospitals, Has been Rejected. oops!!!!😊</p>
            
            <p style='font-weight: 100; font-size: 15px'>Please,Try again another time.</p>
            <i style='color: #f0434c; font-size: 12px; font-weight: 100; line-height: 0;'>Click on the link for confirmation Details, or please ignore if you didnt apply as a Doctor.</i>
        </div>
        <h4 style='font-family: arial; font-weight: 100; text-align:center; font-size: 12px; '>Copyright &copy; <a href='https://demo.fybomidetravel.com' target='_blank'>App Name.</a> All rights reserved.</h4>
        </div>";
        $mailer->send_mail($email, $firstname, $lastname, $subject, $message);
        
        echo "<script>
        function hide(){
           var error = document.getElementById('error').style.display='none';
        }
        setTimeout('hide()', 3000)
        </script>
        
        <div style=' width:100%; id='error'>
        <h6 class='alert alert-danger text-dark' >Dr  $firstname  $lastname 
         application rejected successfully </h6></div>";
    }


    
}
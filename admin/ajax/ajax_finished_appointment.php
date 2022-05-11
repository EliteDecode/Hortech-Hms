<?php
include_once('../../includes/connect.php');


$response = $_POST['finish_id'];
$date =date("jS M Y H:i:s"); 
$sql = "UPDATE appointments SET Stats = 'Finished', DateFinished = '$date'  WHERE id = '$response'";

$result = mysqli_query($conn, $sql);

if ($result) {
    $query = "SELECT * FROM appointments WHERE id = '$response'";
    $resp = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($resp)){
      $firstname = $row['Firstname'];
      $lastname = $row['Lastname'];
    
        
        echo "<script>
        function hide(){
           var error = document.getElementById('error').style.display='none';
        }
        setTimeout('hide()', 3000)
        </script>
        
        <div style=' width:100%; id='error'>
        <h6 class='alert alert-success text-dark' >You have Finished an appointment with  $firstname  $lastname 
        dated $date Check Finished Appointments For More details </h6></div>";
    }


    
}
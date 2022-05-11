<?php
include_once('../../includes/connect.php');


$response = $_POST['id'];

$sql = "UPDATE appointments SET Stats = 'Delivered'  WHERE id = '$response'";

$result = mysqli_query($conn, $sql);

if ($result) {
    $query = "SELECT * FROM appointments WHERE id = '$response'";
    $resp = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($resp)){
      $firstname = $row['Firstname'];
      $lastname = $row['Lastname'];
      $date = $row['DateApp'];
        
        echo "<script>
        function hide(){
           var error = document.getElementById('error').style.display='none';
        }
        setTimeout('hide()', 3000)
        </script>
        
        <div style=' width:100%; id='error'>
        <h6 class='alert alert-success text-dark' >You now have an appointment with  $firstname  $lastname 
        at $date Check Booked Appointments For More details </h6></div>";
    }


    
}
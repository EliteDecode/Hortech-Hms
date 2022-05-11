<?php

include_once('../../includes/connect.php');

$remove_id = $_POST['remove_id'];

$sql = "UPDATE doctor SET Stats = 'pending', Salary = 'Freezed' WHERE id = $remove_id";

$result = mysqli_query($conn, $sql);

if ($result) {
    $query = "SELECT * FROM doctor WHERE id = '$remove_id'";
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
        
        <div style=' width:100%;position:absolute' id='error'>
        <h6 class='alert alert-danger text-dark' >Dr  $firstname  $lastname 
         is no longer a registered Doctor in Hortech Hospitals </h6></div>";
    }

}
<?php
include_once('../../includes/connect.php');


$response = $_POST['id'];

$sql = "UPDATE invoice SET Paid = 'Paid'  WHERE id = '$response'";

$result = mysqli_query($conn, $sql);

if ($result) {
    
        $color = 'Paid';
       
   echo $color;
}
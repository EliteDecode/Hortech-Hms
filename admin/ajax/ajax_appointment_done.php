<?php
include_once('../../includes/connect.php');


$response = $_POST['username'];
$title = $_POST['title'];

$date =date("jS M Y H:i:s"); 
$sql = "UPDATE invoice SET DateDischarged = '$date' WHERE Doctor = '$response'  AND Title = '$title'";
$result = mysqli_query($conn,$sql);

if ($result) {
   echo "<span style='color:#8bc34a'>Patient Discharged</span>";
}    


    
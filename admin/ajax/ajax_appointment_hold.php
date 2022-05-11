<?php
include_once('../../includes/connect.php');

$title = $_POST['title'];
$response = $_POST['username'];

$date ='Not yet'; 

$query = "UPDATE invoice SET DateDischarged = '$date' AND Stats = 'Hospitalized' WHERE Doctor = '$response'
AND Title = '$title'";
$result = mysqli_query($conn,$query);

if ($result) {
    echo "<span style='color: #f23a2e'>Patient on Hold, Patient Still Attended To.</span>";
}
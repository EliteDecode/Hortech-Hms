<?php
include_once('../../includes/connect.php');


$response = $_POST['username'];

$sql = "UPDATE doctor SET Available = 'no' WHERE Username = '$response'";

$result = mysqli_query($conn, $sql);




if ($result) {
        echo "<span style='color: #f23a2e;'>Currently Busy, No Appointment can be made</span>";
    }
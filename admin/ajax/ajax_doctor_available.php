<?php
include_once('../../includes/connect.php');


$response = $_POST['username'];


$sql = "UPDATE doctor SET Available = 'yes' WHERE Username = '$response'";

$result = mysqli_query($conn, $sql);


if ($result) {
        echo "<span style='color: #8bc34a;'>Currently Available, Appointments can be made</span>";
    } 
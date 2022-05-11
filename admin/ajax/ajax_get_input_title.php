<?php
include_once('../../includes/connect.php');


$response = $_POST['id'];

$query = "SELECT * FROM `message` WHERE id = '$response'";
$res = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($res);
if (isset($row)) {
    $title = $row['Title'];

   echo $title;
}
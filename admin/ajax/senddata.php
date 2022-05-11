<?php
include_once('../../includes/connect.php');


$response = $_POST['adminid'];

$sql = "SELECT * FROM admin WHERE Adminid = $response";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){

    $firstname = $row['Firstname'];
    $lastname = $row['Lastname'];
    $username = $row['Username'];
    $adminid = $row['Adminid'];
    $password = $row['Pwd'];


   echo  "
    <h5 style='font-size:18px; margin-bottom:5%; font-weight:600;'>Firstname: <span
     style='font-weight:bolder'>$firstname</span></h5>
    <h5 style='font-size:18px; margin-bottom:5%; font-weight:600; '>Lastname: <span
     style='font-weight:bolder'>$lastname</span></h5>
    <h5 style='font-size:18px; margin-bottom:5%; font-weight:600;'>Username: <span
    style='font-weight:bolder'>$username</span></h5>
     <h5 style='font-size:18px; margin-bottom:5%; font-weight:600;'>ID: <span
    style='font-weight:bolder'>$adminid</span> </h5>
    <h5 style='font-size:18px; margin-bottom:5%; font-weight:600;'>Password: <span
    style='font-weight:bolder'>$password</span> </h5>
";
    
}

   
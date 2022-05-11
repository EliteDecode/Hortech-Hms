<?php
include_once('../../includes/connect.php');


$response = $_POST['reportid'];

$sql = "SELECT * FROM report WHERE id = $response";



$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){

    $report = $row['Report'];
    $title = $row['Title'];
    $dateReg = $row['DateReg'];
    $doctor = $row['Doctor'];
    $status = $row['Stats'];
    $feedback = $row['Feedback'];
    $dateView = $row['FeedbackDate'];


   echo  "
    <h5 style='font-size:15px; margin-bottom:2%; font-weight:bold;'>Title: <span
     style='font-weight:lighter'>$title</span></h5>
    <h5 style='font-size:15px; margin-bottom:2%; font-weight:bold; '>Doctor: <span
     style='font-weight:lighter'>$doctor</span></h5>
    <h5 style='font-size:15px; margin-bottom:2%; font-weight:bold;'>Status: <span
    style='font-weight:lighter'>$status</span></h5>
     <h5 style='font-size:15px; margin-bottom:2%; font-weight:bold;'>Report: <span
    style='font-weight:lighter'>$report</span> </h5>
    <h5 style='font-size:15px; margin-bottom:2%; font-weight:bold;'>Report sent at: <span
    style='font-weight:lighter'>$dateReg</span> </h5>
    <h5 style='font-size:15px; margin-bottom:2%; font-weight:bold;'>Feedback from Dr $doctor: <span
    style='font-weight:lighter'>$feedback</span> </h5>
    <h5 style='font-size:15px; margin-bottom:2%; font-weight:bold;'>Feedback Received at: <span
    style='font-weight:lighter'>$dateView</span> </h5>
";
    
}

   
<?php
include_once('../../includes/connect.php');


$response = $_POST['username'];

$query = "SELECT * FROM report WHERE id = $response";
$res = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($res);
if($feed = $row['Feedback']){

if ($feed == 'Not yet') {
    echo ' <script>
    function hide(){
       var error = document.getElementById("error").style.display="none";
    }
    setTimeout("hide()", 3000)
    </script>
    
    <div style=" position:absolute; width:97.5%; margin:1% 10% 5% 0%; z-index:222;" id="error">
    <h6 class="alert alert-danger" >You Have Not Sent A Feedback For This Report</h6></div>';
}else{
    $sql = "UPDATE report SET Stats = 'Delivered' WHERE id = '$response'";

    $result = mysqli_query($conn, $sql);
}
}
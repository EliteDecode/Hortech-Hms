<?php
 session_start();
 include('../includes/connect.php');
 $un = $_SESSION['patient'];
 $date =date("jS M Y H:i:s"); 
      $sql = "UPDATE patient SET Active ='OFFLINE', logoutTime ='$date' WHERE Username = '$un'";
      $result = mysqli_query($conn, $sql);

 unset($_SESSION['patient']);
   header('location: ../home.php');
 


?>
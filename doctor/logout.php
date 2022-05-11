<?php
 session_start();
 include('../includes/connect.php');
 $un = $_SESSION['doctor'];
 $date =date("jS M Y H:i:s"); 
      $sql = "UPDATE doctor SET Active ='OFFLINE', logoutTime ='$date' WHERE Username = '$un'";
      $result = mysqli_query($conn, $sql);

 unset($_SESSION['doctor']);
   header('location: ../home.php');
 


?>
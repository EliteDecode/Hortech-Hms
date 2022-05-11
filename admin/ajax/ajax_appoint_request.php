<?php

include_once('../../includes/connect.php');

$user = $_POST['id'];

$sql = "SELECT * FROM appointments WHERE Stats='pending' AND Doctor = '$user' ORDER BY DateBooked ASC";

$result = mysqli_query($conn, $sql);


$output = "";

$output .= "<table class='table table-bordered shadow  text-center' style='margin-top:2%; color:#085e79;'>
              <tr> 
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Username</th>
              <th>Gender</th>
              <th>Email</th>
              <th >Date Of Appointment</th>
              <th >Date Of Booking</th>
              <th>Action</th>
              
              
              </tr>";

if (mysqli_num_rows($result) < 1) {
    $output .= "<tr><td colspan='9'>No Application Request.</td></tr>";
}elseif (mysqli_num_rows($result)) {
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['id'];
        $Firstname = $row['Firstname'];
        $Lastname = $row['Lastname'];
        $Username = $row['Username'];
        $Gender = $row['Gender'];
        $Email = $row['Email'];

        $Dateapp = $row['DateApp'];
        $Datebook = $row['DateBooked'];


        $output .= "<tr> 
                    <td style='font-size:14px; font-weight:600;'>$Firstname</td>
                    <td style='font-size:14px; font-weight:600;'>$Lastname</td>
                    <td style='font-size:14px; font-weight:600;'>$Username</td>
                    <td>$Gender</td>
                    
                    <td style='font-size:14px; font-weight:600;'>$Email</td>
                    <td style='font-size:14px; font-weight:600;'>$Dateapp</td>
                    <td style='font-size:14px; font-weight:600;'>$Datebook</td>
                    <td font-weight:600;'><button class='btn btn-success text-white' style='font-size:12px;
                     font-weight:bold;' onclick='approve(this)' id='$id'>Accept</button>
                    </td>
                    <td ><button class='btn btn-danger' onclick='reject(this)' id='$id' style='font-size:12px; font-weight:bold;'>Reject</button></td>
                    
                    </tr>";

    }
}

$output .= "</tr>
            </table>";
              

echo $output;
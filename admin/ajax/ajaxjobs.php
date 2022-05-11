<?php

include_once('../../includes/connect.php');

$sql = "SELECT * FROM doctor WHERE Stats='pending' ORDER BY DateReg ASC";

$result = mysqli_query($conn, $sql);


$output = "";

$output .= "<table class='table table-bordered shadow  text-center' style='margin-top:2%; color:#085e79;'>
              <tr> 
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Username</th>
              <th>Gender</th>
              <th>Passport</th>
              <th>Resume</th>
              <th>Email</th>
              <th >DOR</th>
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
        $Passport = $row['Passport'];
        $Resume = $row['Cv'];
        $Email = $row['Email'];
        $DateReg = $row['DateReg'];


        $output .= "<tr> 
                    <td style='font-size:14px; font-weight:600;'>$Firstname</td>
                    <td style='font-size:14px; font-weight:600;'>$Lastname</td>
                    <td style='font-size:14px; font-weight:600;'>$Username</td>
                    <td>$Gender</td>
                    <td style='font-size:14px; font-weight:600;'><a href ='../doctor/images/$Passport' style='color:#00c3ff'>View Passport</a></td>
                    <td style='font-size:14px; font-weight:600;'><a href ='../doctor/pdf/$Resume' style='color:#00c3ff'>View Resume</a></td>
                    <td style='font-size:14px; font-weight:600;'>$Email</td>
                    <td style='font-size:14px; font-weight:600;'>$DateReg</td>
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
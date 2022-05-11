<?php
  session_start();
  include('../includes/connect.php');

  if (!isset($_SESSION['admin'])) {
    
    header('location: patientlogin.php');
  }elseif (isset($_SESSION['patient'])) {
      $un = $_SESSION['patient'];
      $date =date("jS M Y H:i:s"); 
      $sql = "UPDATE patient SET Active ='ONLINE', loginTime = '$date', logoutTime = '' WHERE Username = '$un'";
      $result = mysqli_query($conn, $sql);
 
 }

  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styling/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../styling/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../styling/admin.css" />
    <link rel="stylesheet" href="../styling/header.css" />
    <title>Patient Dashboard</title>
</head>



<body>
    <?php

     include('header.php');
    
?>

    <section class="adminIndexWrap container-fluid">
        <div class="row">
            <div class="col-md-2 col-lg-2 col-xl-2" style="margin: 0%; padding: 0%">
                <?php include('sidenav.php')?>
            </div>
            <div class="col-md-10 col-lg-10 col-xl-10" style="background-color: rgba(255, 255, 255, 0.207);">
                </h6>
                <h6 style='margin-top:3%; color: #085e79;'>Total Amount Generated:
                    <?php
                
                  $query = "SELECT SUM(fee) AS 'total' FROM invoice";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_array($result);
                  
                  $total =$row['total'];
                  $number= number_format($total);
                  

                  echo "<i class='fa fa-euro'></i>&nbsp $number"
                ?>
                </h6>

                <h6 style='margin-top:3%; color: #085e79;'>Total Unpaid Invoice:
                    <?php
                 
                  $query = "SELECT SUM(fee) AS 'total' FROM invoice WHERE  Paid = 'Pending'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_array($result);
                  
                  $total =$row['total'];
                  $number= number_format($total);
                  

                  echo "<i class='fa fa-euro'></i>&nbsp $number"
                ?>
                </h6>
                <h6 style='margin-top:3%; color: #085e79;'>Total Invoice Paid:
                    <?php
                 
                  $query = "SELECT SUM(fee) AS 'total' FROM invoice WHERE  Paid = 'Paid'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_array($result);
                  
                  $total =$row['total'];
                  $number= number_format($total);
                  

                  echo "<i class='fa fa-euro'></i>&nbsp $number"
                ?>
                </h6>

                <?php 
                                       
                                        $query = "SELECT * FROM `invoice`";
                                        $result = mysqli_query($conn, $query);
                                                                            

                         $output = '<table class="table table-bordered "  style="margin-top:3%; color:#085e79;">

                                        <tr  font-size:10px> <th>Doctor</th>
                                        <th  font-size:10px>Title</th>
                                        <th  font-size:10px>Descriptiont</th>
                                        <th  font-size:10px>Fee</th>
                                        <th  font-size:10px>Date of Discharge</th>
                                        <th  font-size:10px>Status</th>
                                        <th  font-size:10px>Action</th>
                                        <tr>';

                                        while($row = mysqli_fetch_array($result)){ 
                                            $id = $row['id'];
                                        $doctor = $row['Doctor'];
                                        $title = $row['Title'];
                                        $descrip = $row['Descrip'];
                                        $fee = $row['Fee'];
                                        $number= number_format($fee);
                                        $date = $row['DateDischarged'];
                                        $status = $row['Stats'];
                                        $paid = $row['Paid'];


                                        if ($paid == 'Paid') {
                                            $bgs = 'success';
                                            $borders = '1px solid #8bc34a';
                                            $disabled = 'disabled';
                                            $cursor = 'not-allowed';
                                            $value = 'Paid';
                                        }else{
                                            $value = 'Not Paid';
                                            $bgs = 'primary';
                                            $borders = '';
                                            $disabled = 'disabled';
                                            $cursor = 'not-allowed';
                                        }
                                           
                                            $bg = ' #8bc34a;';
                                            $border = '1px solid #8bc34a';
                                            
                                       

                                        if (empty($doctor)) {
                                        $output .= '<tr><td class="text-center" colspan="3">No Report sent</td></tr>';
                                        }else{
                                                                
                                        $output .= "<tr> 
                                        <td style='font-weight:bold; font-size:10px'>Dr $doctor</td>
                                        <td style='font-weight:bold; font-size:10px'>$title</td>
                                        <td style='font-weight:bold; font-size:10px'>$descrip</td>
                                        <td style='font-weight:bold; font-size:10px'>$number</td>
                                        <td style='font-weight:bold; font-size:10px'>$date</td>
                                        <td style='font-weight:bold; font-size:10px'><button
                                         class='btn btn-primary'
                                          style='font-weight:bold; font-size:10px; background-color:$bg;
                                          border:$border;'>$status</button></td>
                                        <td>
                                        <button 
                                        style='font-weight:bold; cursor:$cursor; font-size:10px'class=' text-white btn btn-$bgs' 
                                        id='$id' onclick='pay(this)' $disabled>$value</button> </td>
                                       
                                        ";
                                    }
                                    }
                                        $output .= "</tr> </table>";

                                    

                                        echo $output;
                            
                                                            
                                                    //delete id.
                                                    if (isset($_GET['deleteid'])) {
                                                    
                                                        $id = $_GET['deleteid'];
                                                    
                                                        $sql = "delete from `report` where id = $id";
                                                    
                                                        $result = mysqli_query($conn, $sql);
                                                    }
                                                    ?>



            </div>
        </div>
    </section>



    <script>
    function pay(e) {
        var pay_id = e.id;



        var pay_invoice = new XMLHttpRequest();

        var method = 'POST';
        var url = "../admin/ajax/ajaxpay_invoice.php";
        var vars = "id=" + pay_id;



        pay_invoice.open(method, url, true);

        pay_invoice.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        pay_invoice.onreadystatechange = function() {
            if (pay_invoice.readyState == 4 && pay_invoice.status == 200) {
                var data = pay_invoice.responseText;

            }
        }

        pay_invoice.send(vars);



    }
    </script>
</body>

</html>
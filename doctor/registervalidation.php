<?php
                if (isset($_POST['register'])) {
                    $firstname = ucfirst($_POST['Firstname']);
                    $lastname = ucfirst($_POST['Lastname']);
                    $username = ucfirst($_POST['Username']);
                    $gender = $_POST['Gender'];


                    $passport = $_FILES['Passport']['name'];
                    $tempnameImg = $_FILES["Passport"]["tmp_name"];
                    $cv = $_FILES["Cv"]["name"];
                    $tempnameCv = $_FILES["Cv"]["tmp_name"];
                    $folderCv = "pdf/" . $cv;
                    $folderImg = "images/" . $passport;

                    $email = strtolower($_POST['Email']);
                    $password = $_POST['Password'];
                    $repassword = $_POST['Repassword'];


                    $sql = "SELECT * FROM doctor WHERE Username = '$username'";

                    $result = mysqli_query($conn,$sql);

                   $query = "SELECT * FROM doctor WHERE Email = '$email'";
                   $reponse = mysqli_query($conn,$query);



                    $error = array();

                    if (empty($firstname)) {
                        $error['register'] = "Provide your Firstname";
                    }else if (empty($lastname)) {
                        $error['register'] = "Provide your Lastname";
                    }else if (empty($username)) {
                        $error['register'] = "Provide your Username";
                    }else if (empty($passport)) {
                        $error['register'] = "Provide your Passport";
                    }else if (empty($cv)) {
                        $error['register'] = "Provide your Resume";
                    }else if (empty($email)) {
                        $error['register'] = "Provide your Email Address";
                    }else if (empty($password)) {
                        $error['register'] = "Provide your Password";
                    }else if (empty($repassword)) {
                        $error['register'] = "Re-enter your Password Confirmation";
                    }else if( mysqli_num_rows($result) == 1){
                        $error['register'] = "Username  Already exists.";
                    }else if( mysqli_num_rows($reponse) == 1){
                        $error['register'] = "Email  Already exists.";
                    }else if($password != $repassword){
                        $error['register'] = "Password Must Match";
                    }

                    if(count($error) == 0){
                       
                    $sql = "INSERT INTO `doctor` (Firstname, Lastname,Username, Email, Gender, Doctorid, Pwd, DateReg,Stats,Salary, Cv, Passport)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?);";
                   //preparing a prepared statement

                    $stmt = mysqli_stmt_init($conn);
                    $doctorid = 0;
                    $date =date("jS M Y H:i:s"); 
                   
                    $stats = 'pending';
                    $salary = 0;

                   mysqli_stmt_prepare($stmt, $sql);
                   
                  mysqli_stmt_bind_param($stmt, 'sssssissssss', $firstname, $lastname, $username, $email, $gender, $doctorid,$password,$date,$stats,$salary,$cv,$passport);
                  mysqli_stmt_execute($stmt);
                  

                  move_uploaded_file($tempnameImg, $folderImg); 
                  move_uploaded_file($tempnameCv, $folderCv);
                    
                  mysqli_stmt_close($stmt);

                   echo ' <script>
                   function hide(){
                      var error = document.getElementById("error").style.display="none";
                   }
                   setTimeout("hide()", 3000)
                   </script>
                   
                   <div style="top:-13%; left:0%; position:absolute; width:100%" id="error">
                   <h6 class="alert alert-success text-dark" >Registration succesfull</h6></div>';
                  
                    }

                    
                }

                    if (isset($error['register'])) {
                        $er = $error['register'];
                        $display = ' <script>
                        function hide(){
                           var error = document.getElementById("error").style.display="none";
                        }
                        setTimeout("hide()", 3000)
                        </script>
                        
                        <div style="top:-13%; left:0%; position:absolute; width:100%" id="error">
                        <h6 class="alert alert-danger" >'.$er.'</h6></div>';

                     }else{
                         $display = '';
                     }

                     echo $display
                
            ?>
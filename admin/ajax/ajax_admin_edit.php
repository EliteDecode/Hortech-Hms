            <?php 

            include_once('../../includes/connect.php');


           $edit_id = $_POST['adminid'];           
           
           $sql = "SELECT * FROM admin WHERE Adminid = $edit_id";

           $result = mysqli_query($conn, $sql);

           while($row = mysqli_fetch_assoc($result)){
               $username = $row['Username'];
               $adminid = $row['Adminid'];
               $password = $row['Pwd'];
           }



           

           echo "
           <div class='form-group'>
               <label for='AdminId' style='font-size:12px; font-weight:bold;'>Admin ID</label>
               <input type='number' name='adminid' class='form-control' value='$adminid'
                   style='border:2px solid  #00c3ff; padding:6% 4%; border-radius:10px; background-color:#fff; font-weight:bold' />
           </div>
           <div class='form-group' style=''>
               <label for='username' style='font-size:12px; font-weight:bold;'>Admin Username</label>
               <input type='text' name='username' class='form-control' value = '$username'
                   style='border:2px solid   #00c3ff; padding:6% 4%; border-radius:10px; background-color:#fff;font-weight:bold' />
           </div>
           <div class='form-group'>
               <label for='password' style='font-size:12px; font-weight:bold;'>Admin Password</label>
               <input type='password' name='password' class='form-control' value='$password'
                   style='border:2px solid   #00c3ff; padding:6% 4%; border-radius:10px; background-color:#fff;font-weight:bold' />
           </div>
           

           <button class='btn  btn-info text-white' style='
                    
                       font-size: 14px;
                       font-weight: bold;
                   ' name='edit'>
               Edit Admin
           </button>

       
";

          


            ?>
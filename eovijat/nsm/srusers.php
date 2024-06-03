<?php

include "layout.php";
//echo $_SERVER['REQUEST_URI'];
$msg = "";
if (isset($_REQUEST['remove'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['remove']);
    $id2=$id/5877;
      $sql = "DELETE FROM users  WHERE id='$id2'";
  
      if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-danger'>Removed</div>";
       
 
      } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error</div>";
       

      }
      
   
  
  }
if (isset($_REQUEST['del'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['del']);
    $id2=$id/5877;
      $sql = "UPDATE users SET status='1' WHERE id='$id2' AND role!='admin'";
  
      if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-info'>Deleted</div>";
       
 
      } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error</div>";
       

      }
      
   
  
  }
  
  
  if (isset($_REQUEST['undo'])) {
  
      $id = mysqli_real_escape_string($conn, $_REQUEST['undo']);
      $id2=$id/5877;
        $sql = "UPDATE users SET status='0' WHERE id='$id2'";
    
   
        if ($conn->query($sql) === TRUE) {
            $msg = "<div class='alert alert-info'>Undo Deleted</div>";
         
     
          } else {
            echo "Error: " . $conn->error;
            $msg = "<div class='alert alert-info'>Error</div>";
           
    
          }
        
     
    
    }
?>

<div class="row">


    <div class="col-sm-6 col-12">

        <?php
       

        if (isset($_POST['submit'])) {

            $email = mysqli_real_escape_string($conn, $_POST['email']);

            $role = mysqli_real_escape_string($conn, $_POST['role']);
            $parent = mysqli_real_escape_string($conn, $_POST['parent']);

          

            $password = mysqli_real_escape_string($conn, md5($_POST['password']));
            $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));


            if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
                $msg = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
            } else {
                if ($password === $confirm_password) {
                    $sql = "INSERT INTO users ( email,role,parent,status, password) 
                 VALUES ('{$email}','{$role}','{$parent}','0', '{$password}')";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        echo "<div style='display: none;'>";
                        //Create an instance; passing `true` enables exceptions
        


                        echo "</div>";
                        $msg = "<div class='alert alert-info'>Done</div>";
                    } else {
                        $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
                }
            }
        }
        echo $msg;
        ?>
<div class=" text-center">

<h1>Add SR User</h1>

</div>
        <div class="col-lg-12 pt-2 d-flex justify-content-center">

        
            <form role="form"  action="" method="post">


                <div class="controls">

                    <div class="row">

                        <div class="col-sm-6 col-12 ">
                            <div class="form-group">

                                <input type="text" class="email form-control" name="email" placeholder="Enter Username" value="<?php if (isset($_POST['submit'])) {
                                    echo $email;
                                } ?>" required>

                            </div>
                        </div>

                        <div class="col-sm-2 col-12 ">
                            <div class="form-group">

                                <input type="text" class="role form-control" name="role" value="sr" value="<?php if (isset($_POST['submit'])) {
                                    echo $role;
                                } ?>" required readonly>

                            </div>
                        </div>

                        <div class="col-sm-4 col-12 ">
                            <div class="form-group">

                            <select class=" form-control" name="parent">
<?php
    $sql = "SELECT email FROM users where role='tsm' ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

echo "<option>".$row['email']."</option>";

        }

    }   
?>
                         

                            </select>

                            </div>
                        </div>
                       
                        <div class="col-sm-6 col-12 ">
                            <div class="form-group">
                        <input type="password" class="password form-control" name="password" placeholder="Enter Password"
                            required>
                            </div>
                        </div>

                            <div class="col-sm-6 col-12 ">
                            <div class="form-group">
                        <input type="password" class="confirm-password form-control" name="confirm-password"
                            placeholder="Enter Confirm Password" required>
                            </div>
                        </div>
                            <div class="col-sm-12 col-12 ">
                            <div class="form-group">
                        <button name="submit" class="btn form-control btn-success btn-send col-sm-12 noprint col-auto" type="submit">Register</button>
                        </div>
                        </div>
            </form>
        </div>



    </div>
</div>
</div>



<div class="col-sm-6 col-12">
<div class=" text-center">

        <h1>User List</h1>

    </div>
<?php

// Create connection
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT id, email, status, role, parent FROM users where role='sr' ORDER BY parent DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    ?>

    


    <div style="overflow-x:auto;">
        <table>
            <tr>
            <th></th> 
            
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Parent</th>
                <th>Status</th>
               

             

            </tr>
            <?PHP
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                
                if ($row['status']==1){

                    echo " <tr style='color:red;'>
                    <td><a href='".$_SERVER["PHP_SELF"]."?undo=" . intval($row['id'])*5877 . "'>+</a></td>
             

            <td>" . $row['id'] . "</td>
            <td>" . $row['email'] . "</td>
            <td>" . $row['role'] . "</td>
            <td>" . $row['parent'] . "</td>
            <td>" . "Inactive" . "</td>
         
            </tr> ";
                }
                else{
                    echo " <tr style='color:green;'>
                    <td><a href='".$_SERVER["PHP_SELF"]."?del=" . intval($row['id'])*5877 . "'>-</a></td>
                 
            <td>" . $row['id'] . "</td>
            <td>" . $row['email'] . "</td>
            <td>" . $row['role'] . "</td>
            <td>" . $row['parent'] . "</td>
            <td>" . "Active" . "</td>
          
            </tr> ";

                }
          
            }
} else {
    echo "<h1 class='text-center'>No data available at this moment</h1>";
}

mysqli_close($conn);
?>
    </table>
</div>
</div>




</div>
<?php


include "layout2.php";

?>
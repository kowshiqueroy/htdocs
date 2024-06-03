<?php


include "layout.php";
?>
<?php
    $sql = "SELECT * FROM requisitionlist WHERE status= '4' AND purchaser='$user' ORDER BY id DESC LIMIT 10";

if (isset($_REQUEST['item'])) {

    $item = mysqli_real_escape_string($conn, $_REQUEST['item']);
    $sql = "SELECT * FROM requisitionlist WHERE status= '4' AND item='$item'  AND purchaser='$user' ORDER BY id DESC";



}
if (isset($_REQUEST['submitf'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['id']);
    $fqty = mysqli_real_escape_string($conn, $_REQUEST['fqty']);
    $pqty = mysqli_real_escape_string($conn, $_REQUEST['pqty']);
    $fcomments = mysqli_real_escape_string($conn, $_REQUEST['fcom']);
    $value = mysqli_real_escape_string($conn, $_REQUEST['fvalue']);
   
    $sql = "UPDATE requisitionlist SET status='5',fqty='$fqty' ,fcomments='$fcomments',fcomments='$fcomments',value='$value'  WHERE id='$id'";

   

    if($fqty<$pqty){
        $sql = "UPDATE requisitionlist SET status='4',fqty='$fqty' ,fcomments='$fcomments',fcomments='$fcomments',value='$value'  WHERE id='$id'";



    }
    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-info'>Deleted</div>";


    } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error</div>";


    }
    $sql = "SELECT * FROM requisitionlist WHERE status= '4' AND purchaser='$user' ORDER BY id DESC LIMIT 10";



}


if(isset($_REQUEST['search']) AND isset($_REQUEST['searchi']) AND isset($_REQUEST['searchp'])){


       
    $s=$_REQUEST['search'];
    $si=$_REQUEST['searchi'];
    $sp=$_REQUEST['searchp'];  

    if($s==83 && !strcmp($si,"All" ) && !strcmp($sp,"All" )){
        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2'  AND purchaser='$user' ORDER BY id DESC ";

    } else if ($s==83 && !strcmp($sp,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (item like '%$si%')  AND purchaser='$user' ORDER BY id DESC ";
    }

    else if ($s==83 && !strcmp($si,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (person like '%$sp%')  AND purchaser='$user' ORDER BY id DESC ";
    }
    else if (!strcmp($si,"All") && !strcmp($sp,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (status='$s')  AND purchaser='$user' ORDER BY id DESC ";
    }

    else if ( !strcmp($sp,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (item like '%$si%' AND status='$s')  AND purchaser='$user' ORDER BY id DESC ";
    }

    else if ( !strcmp($si,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (person like '%$sp%' AND status='$s')  AND purchaser='$user' ORDER BY id DESC ";
    }
    else if ($s==83 )   {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (item like '%$si%' AND person like '%$sp%')  AND purchaser='$user' ORDER BY id DESC ";
    }
 

  


   


}
?>

<div class="row">



    <div class="col-sm-12 col-12">

        <div class=" text-center">

            <h1>All Purchase List</h1>

        </div>

        <div class="noprint">

        <div class="col-lg-12 d-flex justify-content-center ">

            <form id="contact-form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>" method="post">


                <div class="controls">

                    <div class="row">

                        <input onclick="window.location.replace(window.location.href);"
                            style="height:40px; margin:20px;" class="btn btn-success btn-send col-sm-2 col-auto"
                            value="Refresh">


                     
                        <div class="col-sm-2 col-12 ">
                            <div class="form-group">
                                <label for="searchi">Item</label>
                                <input type="text" name="searchi" class=' form-control' id="searchi" value="<?php if (isset($_REQUEST['searchi'])) {
                                    echo $_REQUEST['searchi'];
                                } else {
                                    echo "All";
                                } ?>" required>
                            </div>
                        </div>

                        <div class="col-sm-2 col-12 ">
                            <div class="form-group">
                                <label for="searchp">Person</label>
                                <input type="text" name="searchp" class=' form-control' id="searchp" value="<?php if (isset($_REQUEST['searchp'])) {
                                    echo $_REQUEST['searchp'];
                                } else {
                                    echo "All";
                                } ?>" required>
                            </div>
                        </div> 
                        <div class="col-sm-2 col-12 ">
                            <div class="form-group">
                                <label for="search">Status</label>
                                <select type="text" name="search" class=' form-control' id="search" required>
                                <option value='83'>All</option>
                             
                              
                                <option value='4'>Purchasing</option>
                                <option value='5'>Purchased</option>
                                  <?php  if (isset($_REQUEST['search']))
                                  {

                                    if($_REQUEST['search']==83){

                                        echo "  <option selected value='83'>All</option>";
                                        
                                        
                                    }
                                   

                                    else if($_REQUEST['search']==4){

                                        echo "  <option selected value='4'>Purchasing</option>";
                                        
                                        
                                    }


                                    else if($_REQUEST['search']==5){

                                        echo "  <option selected value='5'>Purchased</option>";
                                        
                                        
                                    }


                                  }


                                    ?>
                                
                                
                                
                               

                            </select>
                            </div>
                        </div>

                        



                        <input style="height:40px; margin:20px;" type="submit" name="submit"
                            class="btn btn-success btn-send col-sm-2  col-auto" value="View">


                    </div>
                </div>
            </form>

        </div>
    </div>

        <?php

        // Create connection
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        

      


       
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            ?>




            <div style="overflow-x:auto;">
                <table>
                    <tr>
                   
                        <th>Status</th>
                        <th>Action</th>
                        <th>ID</th>
                        <th>Item Name</th>

                      
                 
                        <th>P QTY</th>
                        <th>F QTY</th>
                        <th>Comments</th>
                        <th>F Comments</th>

                        <th>Value</th>
                 
                        <th>Need Date</th>

                        <th>Reason</th>
                        <th>Remarks</th>
                        <th>Submission</th>
                     



                  

                    </tr>
                    <?PHP
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {

                          if ($row['status'] == 4) {
                            echo " <tr style='color:balck;'>
                            <td >Purchasing</td>
                            <td >
                            
                            <form action='' method='get'>
                            <input  type='hidden' required name='id' value='".$row['id']."'>
                            <input  type='hidden' required name='pqty' value='".$row['pqty']."'>
                            QTY:<input class='form-control col-sm-12' type='number' required name='fqty' value='".$row['pqty']."'>
                            Value:<input class='form-control col-sm-12' type='number' required name='fvalue'>
                            Comments:<input class='form-control col-sm-12' type='text' value='N/A' required name='fcom'>
                            <input type='submit' name='submitf'
                            class='btn btn-success btn-send  mt-2 btn-block' value='Save'>
                            </form>
                            
                            
                            </td>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['item'] . "</td>
                         
                        
                            <td>" . $row['pqty'] . "</td>
                            <td>" . $row['fqty'] . "</td>
                            <td>" . $row['comments'] . "</td>
                            <td>" . $row['fcomments'] . "</td>
                            <td>" . $row['value'] . "</td>
                       
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['reason'] . "</td>
                            <td>" . $row['remarks'] ." ".$row['bystore']. "</td>
                            <td>" . $row['subd'] . "</td>
                           
                  ";







                            echo "                           
                    

                    </tr> ";

                        } else if ($row['status'] == 5) {
                            echo " <tr style='color:green;'>
                            <td >Purchased</td>
                            <td >Done</td>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['item'] . "</td>
                         
                        
                            <td>" . $row['pqty'] . "</td>
                            <td>" . $row['fqty'] . "</td>
                            <td>" . $row['comments'] . "</td>
                            <td>" . $row['fcomments'] . "</td>
                            <td>" . $row['value'] . "</td>
                       
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['reason'] . "</td>
                            <td>" . $row['remarks'] . " ".$row['bystore']."</td>
                            <td>" . $row['subd'] . "</td>   
                  ";







                            echo "                           
                     <td class='noprint'>";



                            echo "";






                            echo "</td>

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
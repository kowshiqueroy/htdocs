<?php


include "layout.php";
?>
<?php


if (isset($_REQUEST['submitf'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['id']);
    $fqty = mysqli_real_escape_string($conn, $_REQUEST['fqty']);
    $fcomments = mysqli_real_escape_string($conn, $_REQUEST['fcom']);
    $value = mysqli_real_escape_string($conn, $_REQUEST['fvalue']);
   
    $sql = "UPDATE requisitionlist SET status='5',fqty='$fqty' ,fcomments='$fcomments',fcomments='$fcomments',value='$value'  WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-info'>Deleted</div>";


    } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error</div>";


    }



}


    $sql = "SELECT * FROM requisitionlist WHERE status= '5' OR fqty>0  ORDER BY id DESC LIMIT 10";
if(isset($_REQUEST['searchi'])){


       

    $si=$_REQUEST['searchi'];
     

    if (strcmp($si,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status= '5' OR fqty>0  AND (item like '%$si%') ORDER BY id DESC ";
    }


    else  {

        $sql = "SELECT * FROM requisitionlist WHERE status= '5' OR fqty>0   ORDER BY id DESC ";
    }

   
 

  


   


}
?>

<div class="row">



    <div class="col-sm-12 col-12">

        <div class=" text-center">

            <h1>All Purchase Receive</h1>

        </div>

        <div class="noprint">

        <div class="col-lg-12 d-flex justify-content-center ">

            <form id="contact-form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>" method="post">


                <div class="controls">

                    <div class="row">

                        <input onclick="window.location.replace(window.location.href);"
                            style="height:40px; margin:20px;" class="btn btn-success btn-send col-sm-2 col-auto"
                            value="Refresh">


                     
                        <div class="col-sm-6 col-12 ">
                            <div class="form-group">
                                <label for="searchi">Item</label>
                                <input type="text" name="searchi" class=' form-control' id="searchi" value="<?php if (isset($_REQUEST['searchi'])) {
                                    echo $_REQUEST['searchi'];
                                } else {
                                    echo "All";
                                } ?>" required>
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

                      
                        <th>Purchaser</th>
                 
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

                           if ($row['status'] == 5) {
                            echo " <tr style='color:green;'>
                            <td >Purchased</td>
                            <td ><a href='storeitems.php?id=".$row['id']."&action=in'>In</a>
                            <a href='storeitems.php?id=".$row['id']."&action=out'>Out</a></td>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['item'] . "</td>
                         
                            <td>" . $row['purchaser'] . "</td>
                        
                            <td>" . $row['pqty'] . "</td>
                            <td>" . $row['fqty'] . "</td>
                            <td>" . $row['comments'] . "</td>
                            <td>" . $row['fcomments'] . "</td>
                            <td>" . $row['value'] . "</td>
                       
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['reason'] . "</td>
                            <td>" . $row['remarks'] . "</td>
                            <td>" . $row['subd'] . "</td>
                                             
                     <td class='noprint'></td>

                    </tr> ";

                        }
                        if ($row['status'] == 4 && $row['pqty'] > $row['fqty']) {
                            echo " <tr style='color:blue;'>
                            <td >Partial</td>
                            <td ><a href='storeitems.php?id=".$row['id']."&action=in'>In</a>
                            <a href='storeitems.php?id=".$row['id']."&action=out'>Out</a></td>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['item'] . "</td>
                         
                            <td>" . $row['purchaser'] . "</td>
                        
                            <td>" . $row['pqty'] . "</td>
                            <td>" . $row['fqty'] . "</td>
                            <td>" . $row['comments'] . "</td>
                            <td>" . $row['fcomments'] . "</td>
                            <td>" . $row['value'] . "</td>
                       
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['reason'] . "</td>
                            <td>" . $row['remarks'] . "</td>
                            <td>" . $row['subd'] . "</td>
                                             
                     <td class='noprint'></td>

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
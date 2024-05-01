<?php


include "layout.php";
?>
<?php
if (isset($_REQUEST['del'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['del']);
    $id2 = $id / 5877;
    $sql = "UPDATE requisitionlist SET status='1' WHERE id='$id2'";

    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-info'>Deleted</div>";


    } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error</div>";


    }



}

?>
<div class="row">



    <div class="col-sm-12 col-12">

        <div class=" text-center">

            <h1>Action for this Requisition</h1>

        </div>

        <?php
        $id = "";
        if (isset($_REQUEST['id'])) {

            $id = $_REQUEST['id'];

        }
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM requisitionlist WHERE id= '$id' ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            ?>




            <div style="overflow-x:auto;">
                <table>
                    <tr>
                        <th class=''>Status</th>





                        <th>Item Name</th>
                        <th>QTY</th>
                        <th>Stock</th>
                        <th>Person</th>
                        <th>Need Date</th>
                        <th>Reason</th>
                        <th>Value</th>
                        <th>Remarks</th>
                        <th>Submission</th>
                        <th>By</th>

                        <th>ID</th>


                    </tr>


                    <?PHP

                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {

                        if ($row['status'] != 1) {

                            echo "<tr><td>";
                            if ($row['status'] == 0) { echo "Waiting"; }


                            echo "</td> <td>" . $row['item'] . "</td> <td>" . $row['qty'] . "</td>";


                            $rs = 0;

                            $item = $row['item'];

                            $sql2 = "SELECT * FROM store WHERE role='$role' AND status!='1' AND item='$item'";
                            $result2 = mysqli_query($conn, $sql2);

                            if (mysqli_num_rows($result2) > 0) {

                                while ($row2 = mysqli_fetch_assoc($result2)) {

                                    if ($row2['status'] == 0) {


                                        $rs += (floatval($row2['ins']) - floatval($row2['outs']));

                                    }
                                }

                            } 

                            echo " <td>" . $rs . "</td>
                    
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['reason'] . "</td>
            
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['remarks'] . "</td>
                    <td>" . $row['subd'] . "</td>
                    <td>" . $row['byuser'] . "</td>
                 
                    
                    <td>" . $row['id'] . "</td> </tr> ";






                            if ($rs > floatval($row['qty'])) {

                                echo "<tr>";
                                echo " <td colspan='4'>
                                       <a class='btn btn-success btn-send   btn-block' href='storeitems.php?id=" . $row['id'] .
                                        "&action=out'>Make this Out</a>
                                       </td>
                                       </tr> ";
                            }

                            echo " <tr>

                    <form action='po.php' method='post'>
                    <td colspan='4'>Create Purchase Order: <input name='' readonly class='form-control' type='text' value='" . $row['item'] . "'></td>
                    </tr>
                    <tr>
                    <td colspan='4'>Quantity= 
                    <input name='qty' required class='form-control' type='text' value='";
                    if((floatval($row['qty']) - $rs)>0){ echo floatval($row['qty']) - $rs;} else {echo'0';} 
                    echo "'>
                    <input name='id' class='form-control' type='hidden' value='" . $row['id'] . "'>
                    <input name='stock' class='form-control' type='hidden' value='" . $rs . "'>
                    
                    </td></tr>
                    <tr>
                    <td colspan='4'>Purchaser:                
                  
                    <select name='purchaser' class='form-control' type='text' required>
                
                    ";
                    
                    $sql3 = "SELECT * FROM users WHERE role='purchaser'";
                    $result3 = mysqli_query($conn, $sql3);

                    if (mysqli_num_rows($result3) > 0) {

                        while ($row3 = mysqli_fetch_assoc($result3)) {

                            echo "<option>".$row3['email']."</option>";


                        }
                    }
                    echo "</select>
                    </td>
                    </tr>
                   
                    
                    
                    
                    <tr>
                    <td colspan='4'>
                    <input class='btn btn-success btn-send   btn-block' type='submit' value='Create Purchase Order'>
                    </form>
                    </tr>";
                        
                
                
                
                
                
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
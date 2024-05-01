<?php


include "layout.php";
?>
<?php





    $sql = "SELECT DISTINCT item FROM requisitionlist WHERE (status= '5' OR status= '4') AND role='$role'
      ORDER BY id DESC LIMIT 10";
if(isset($_REQUEST['searchi'])){


       

    $si=$_REQUEST['searchi'];
     

    if (strcmp($si,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE (status= '5' OR status= '4')  AND (item like '%$si%') AND role='$role' ORDER BY id DESC ";
    }


    else  {

        $sql = "SELECT * FROM requisitionlist WHERE (status= '5' OR status= '4') AND role='$role' ORDER BY id DESC ";
    }

}
?>

<div class="row">



    <div class="col-sm-12 col-12">

        <div class=" text-center">

            <h1>Purchase Total</h1>

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
                   
                   
                        <th>Item Name</th>
                        <th>P QTY</th>
                        <th>F QTY</th>
                        <th>Action</th>
                     </tr>
                    <?PHP
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {

                         
                            echo " 
                            <tr> 
                            <td>" . $row['item'] . "</td>";
                            $tpqty=0;
                            $tfqty=0;
                            $item=$row['item'];

                            $sql2 = "SELECT item, pqty,fqty FROM requisitionlist WHERE (status= '5' OR status= '4') AND item='$item'";
                            $result2 = mysqli_query($conn, $sql2);

                            if (mysqli_num_rows($result2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    $tpqty+=$row2['pqty'];
                                    $tfqty+=$row2['fqty'];


                                    
                                }

                                echo "<td>".$tpqty."</td>";
                                echo "<td>".$tfqty."</td>";
                                echo "<td><a href='storepurchaseget.php?searchi=".$row['item']."'>Check</a></td>";
                            }


                         
                      
                            echo   "</tr> ";

                

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
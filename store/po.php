<?php


include "layout.php";
?>
<?php


?>
<div class="row">



    <div class="col-sm-12 col-12">

        <div class=" text-center">

            <h1>All Purchase Orders</h1>

        </div>

        <?php

        // Create connection
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' ORDER BY id DESC LIMIT 10";



        if (isset($_REQUEST['all'])) {

            $sql = "SELECT * FROM requisitionlist WHERE status!= '1' ORDER BY id DESC";

        }
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            ?>




            <div style="overflow-x:auto;">
                <table>
                    <tr>
                        <th>Status</th>
                        <th>ID</th>
                        <th>Item Name</th>

                        <th>QTY</th>

                        <th>Value</th>
                        <th>Person</th>
                        <th>Need Date</th>

                        <th>Reason</th>
                        <th>Remarks</th>
                        <th>Submission</th>
                        <th>By</th>



                        <th>Action</th>

                    </tr>
                    <?PHP
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {

                        if ($row['status'] == 0) {

                            echo " <tr>
                            <td >Waiting</td>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['qty'] . "</td>
               
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['reason'] . "</td>
                    <td>" . $row['remarks'] . "</td>
                    <td>" . $row['subd'] . "</td>
                    <td>" . $row['byuser'] . "</td>
                  ";







                            echo "                           
                     <td class='noprint'>";



                            echo "<a  href='requisitionstockaction.php?id=" . intval($row['id']) . "'>View </a>";






                            echo "</td>

                    </tr> ";
                        } else if ($row['status'] == 2) {
                            echo " <tr style='color:green;'>
                            <td >Given</td>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['qty'] . "</td>
               
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['reason'] . "</td>
                    <td>" . $row['remarks'] . "</td>
                    <td>" . $row['subd'] . "</td>
                    <td>" . $row['byuser'] . "</td>
                  ";







                            echo "                           
                     <td class='noprint'>";



                            echo "";






                            echo "</td>

                    </tr> ";

                        } else if ($row['status'] == 3) {
                            echo " <tr style='color:blue;'>
                            <td >Need Approval</td>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['qty'] . "</td>
               
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['reason'] . "</td>
                    <td>" . $row['remarks'] . "</td>
                    <td>" . $row['subd'] . "</td>
                    <td>" . $row['byuser'] . "</td>
                  ";







                            echo "                           
                     <td class='noprint'>";



                            echo "";






                            echo "</td>

                    </tr> ";

                        }


                        else if ($row['status'] == 4) {
                            echo " <tr style='color:red;'>
                            <td >Purchasing</td>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['qty'] . "</td>
               
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['reason'] . "</td>
                    <td>" . $row['remarks'] . "</td>
                    <td>" . $row['subd'] . "</td>
                    <td>" . $row['byuser'] . "</td>
                  ";







                            echo "                           
                     <td class='noprint'>";



                            echo "";






                            echo "</td>

                    </tr> ";

                        }


                        else if ($row['status'] == 5) {
                            echo " <tr style='color:orange;'>
                            <td >Purchased</td>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['qty'] . "</td>
               
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['reason'] . "</td>
                    <td>" . $row['remarks'] . "</td>
                    <td>" . $row['subd'] . "</td>
                    <td>" . $row['byuser'] . "</td>
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


    <input type="submit" onclick="window.location.replace('requisitionstock.php?all=1');"
        class="btn btn-success btn-send  mt-2 btn-block" value="View Full List">

</div>
<?php


include "layout2.php";

?>
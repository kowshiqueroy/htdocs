<?php


include "layout.php";
?>
<?php


?>
<div class="row">



    <div class="col-sm-12 col-12">

        <div class=" text-center">

            <h1>Your Requisitions</h1>

        </div>

        <?php

        // Create connection
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if (isset($_REQUEST['req'])) {

            $reqid = mysqli_real_escape_string($conn, $_REQUEST['req']);
        }

        if (isset($_REQUEST['del'])) {

            $id = mysqli_real_escape_string($conn, $_REQUEST['del']);
            $id2 = $id / 5877;
            $sql = "UPDATE requisitionlist SET status='1' WHERE id='$id2' AND byuser='$user'";

            if ($conn->query($sql) === TRUE) {
                $msg = "<div class='alert alert-info'>Deleted</div>";


            } else {
                echo "Error: " . $conn->error;
                $msg = "<div class='alert alert-info'>Error</div>";


            }



        }


        if (isset($_REQUEST['undo'])) {

            $id = mysqli_real_escape_string($conn, $_REQUEST['undo']);
            $id2 = $id / 5877;
            $sql = "UPDATE requisitionlist SET status='0' WHERE id='$id2' AND byuser='$user'";

            if ($conn->query($sql) === TRUE) {
                $msg = "<div class='alert alert-info'>Undo Deleted</div>";


            } else {
                echo "Error: " . $conn->error;
                $msg = "<div class='alert alert-info'>Error</div>";


            }


        }
        $sql = "SELECT * FROM requisitionlist WHERE byuser= '$user' ORDER BY id DESC LIMIT 10";

        if(isset($_REQUEST['all'])){

            $sql = "SELECT * FROM requisitionlist WHERE byuser= '$user' ORDER BY id DESC";
        }
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            ?>




            <div style="overflow-x:auto;">
                <table>
                    <tr>
                        <th class='noprint'></th>
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

                    </tr>
                    <?PHP
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {

                        if ($row['status'] == 1) {

                            echo " <tr style='color:red;'>
                    <td class='noprint'><a href='" . $_SERVER["PHP_SELF"] . "?undo=" . intval($row['id']) * 5877 . "'>+</a></td>
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
                    </tr> ";
                        } else if ($row['status'] == 0) {
                            echo " <tr>
                    <td class='noprint'><a  href='" . $_SERVER["PHP_SELF"] . "?del=" . intval($row['id']) * 5877 . "'>X</a></td>
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
                    </tr> ";

                        } else if ($row['status'] == 2) {
                            echo " <tr>
                    <td class='noprint'>Given</td>
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
                    </tr> ";

                        } else if ($row['status'] == 3) {
                            echo " <tr>
                    <td class='noprint'>Need Approval</td>
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
                    </tr> ";

                        } else if ($row['status'] == 4) {
                            echo " <tr>
                            <td class='noprint'>Purchasing</td>
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
                            </tr> ";

                        } else if ($row['status'] == 5) {
                            echo " <tr>
                                    <td class='noprint'>Purchased</td>
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
                                    </tr> ";

                        }


                    }



        } else {
            echo "<h1 class='text-center'>No data available at this moment</h1>";
        }

        mysqli_close($conn);
        ?>


            </table>

    <input type="submit" onclick="window.location.replace('requisitionlistuser.php?all=1');"
        class="btn btn-success btn-send  mt-2 btn-block" value="View Full List">

        </div>
    </div>



</div>
<?php


include "layout2.php";

?>
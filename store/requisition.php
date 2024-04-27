<?php


include "layout.php";
?>
<?php

if (isset($_REQUEST['req'])) {

    $reqid = mysqli_real_escape_string($conn, $_REQUEST['req']);}

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


if (isset($_REQUEST['submit'])) {

    $byuser = mysqli_real_escape_string($conn, $_SESSION['SESSION_EMAIL']);
    $item = mysqli_real_escape_string($conn, $_REQUEST['item']);
    $qty = mysqli_real_escape_string($conn, $_REQUEST['qty']);
    $value = mysqli_real_escape_string($conn, $_REQUEST['value']);
    $person = mysqli_real_escape_string($conn, $_REQUEST['person']);
    $slip = mysqli_real_escape_string($conn, $_REQUEST['slip']);
    $date = mysqli_real_escape_string($conn, $_REQUEST['date']);
    $reason = mysqli_real_escape_string($conn, $_REQUEST['reason']);

    if (!strcmp($reason, "N/A")) {


        $reason = "";

    }


    $remarks = mysqli_real_escape_string($conn, $_REQUEST['remarks']);

    if (!strcmp($remarks, "N/A")) {


        $remarks = "";

    }


    $role = $_SESSION['SESSION_ROLE'];

    if (
        $qty <= 0 
    ) {

        echo '<script> const currentUrl = window.location.href; window.location.replace(currentUrl+"?s=de");</script>';
        die();

    }

    $sql = "INSERT INTO requisitionlist (byuser,item,qty,value,reason,person,slip,date,remarks,role) 
            VALUES ('$byuser','$item','$qty','$value','$reason','$person','$slip','$date','$remarks','$role')";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        echo '<script> const currentUrl = window.location.href; window.location.replace(currentUrl+"?s=t");</script>';
    } else {

        echo '<script> const currentUrl = window.location.href; window.location.replace(currentUrl+"?s=f");</script>';
    }

}


?>
<div class="row">

    <div class="col-sm-6">

        <!-- /.form-->
        <div class="container">

            <?php
            if (isset($_GET['s'])) {

                if ($_GET['s'] == "t") {
                    echo "<div class='alert alert-info'>Successfully Saved to the Database</div>";

                } else if ($_GET['s'] == "f") {

                    echo "<div class='alert alert-danger'>Something wrong went</div>";
                } else if ($_GET['s'] == "de") {

                    echo "<div class='alert alert-danger'>Must be > 0 Qty</div>";
                }

            }
            ?>


            <div class="row ">
                <div class="col-sm-12 col-12 ">
                    <div class="card  bg-light">
                        <div class="card-body bg-light">
                            <div class=" text-center">

                                <h1>Requisition App</h1>

                            </div>
                            <div class="container">
                                <form id="contact-form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>"
                                    method="post">

                                    <div class="controls">

                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="item">Item (Category ProductName SKU PacketSize)</label>
                                                    <select id="select_boxi item" name="item"
                                                        class="form-control select2i" required="required"
                                                        data-error="Please specify.">
                                                        <option value="" selected ><?php if (isset($_REQUEST['req'])) { echo $reqid;}?>
                                                        </option>

                                                        <?php
                                                       if (!isset($_REQUEST['req'])) {  include 'itemselectbox.php';}
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="qty">QTY</label>
                                                    <input id="qty" type="float" name="qty" class="form-control"
                                                        placeholder="Number/Float" required="required" value="0"
                                                        data-error="Number/Float is required.">

                                                </div>
                                            </div>
                                        
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="value">Value TAKA</label>
                                                    <input id="value" type="float" name="value" class="form-control"
                                                        placeholder="Total Value" required="required" value="0"
                                                        data-error="value is required.">
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="date">Need Date</label>
                                                    <input id="date" type="text" name="date" class='date form-control'
                                                        value="<?php echo date("Y-m-d"); ?>" required="required"
                                                        data-error="date.">
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="person">For Person/Dept/Company/Shop</label>
                                                    <select id="select_boxp person" name="person"
                                                        class="form-control select2p" required="required"
                                                        data-error="Person/Dept/Company/Shop">
                                                        <option value="" selected disabled>Person/Dept/Company/Shop
                                                        </option>

                                                        <?php
                                                        include 'personselectbox.php';
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>


                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="slip">Slip Number</label>
                                                    <input id="slip" type="text" name="slip" class="form-control"
                                                        placeholder="Slip Number" required="required" value="0"
                                                        data-error="Slip is required.">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="reason">Reason</label>
                                                    <input id="reason" type="text" name="reason" class="form-control"
                                                        value="N/A" required="required"
                                                        data-error="Reason is required.">
                                                </div>
                                            </div>

                                           
                                            

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="remarks">Remarks</label>
                                                    <input id="remarks" type="text" name="remarks" class="form-control"
                                                        value="N/A" required="required" data-error="Remarks">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-sm-12">

                                                <input type="submit" name="submit"
                                                    class="btn btn-success btn-send   btn-block" value="Save">

                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /.8 -->

                </div>
                <!-- /.row-->

            </div>
        </div>

        <!-- /.form-->



    </div>

    <div class="col-sm-6 col-12">

        <div class=" text-center">

            <h1>Your Last Few Requisitions</h1>

        </div>

        <?php

        // Create connection
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT id,item,qty,value,subd,byuser,date,status, person FROM requisitionlist WHERE byuser= '$user' ORDER BY id DESC LIMIT 8";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            ?>




            <div style="overflow-x:auto;">
                <table>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>QTY</th>
                        
                    
                        <th>Value</th>
                        <th>Person</th>
                        <th>Need Date</th>
                        <th>Submission</th>
                        <th>By</th>

                    </tr>
                    <?PHP
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {

                        if ($row['status'] == 1) {

                            echo " <tr style='color:red;'>
                            <td><a href='" . $_SERVER["PHP_SELF"] . "?undo=" . intval($row['id']) * 5877 . "'>+</a></td>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['qty'] . "</td>
                   
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['subd'] . "</td>
                    <td>" . $row['byuser'] . "</td>
                    </tr> ";
                        } else {
                            echo " <tr>
                            <td><a href='" . $_SERVER["PHP_SELF"] . "?del=" . intval($row['id']) * 5877 . "'>X</a></td>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['qty'] . "</td>
               
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['date'] . "</td>
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

            
            <input type="submit" onclick="window.location.replace('requisitionlistuser.php');"   class="btn btn-success btn-send  mt-2 btn-block" value="View Full List">
        </div>
    </div>



</div>
<?php


include "layout2.php";

?>
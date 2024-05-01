<?php


include "layout.php";
?>
<?php

$ri="";
$rq="";
$rp="";
$rr="";
if (isset($_REQUEST['id'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['id']);
 

  


    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM requisitionlist WHERE id= '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

           

                $ri=$row['item'];
                $rq=$row['qty'];
                $rp=$row['person'];
                $rr=$row['reason'];
             
            
        
        
        }
    
    }



}
if (isset($_REQUEST['del'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['del']);
    $id2 = $id / 5877;
    $sql = "UPDATE store SET status='1' WHERE id='$id2' AND byuser='$user'";

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
    $sql = "UPDATE store SET status='0' WHERE id='$id2' AND byuser='$user'";

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
    $ins = mysqli_real_escape_string($conn, $_REQUEST['ins']);
    $outs = mysqli_real_escape_string($conn, $_REQUEST['outs']);
    $value = mysqli_real_escape_string($conn, $_REQUEST['value']);
    $person = mysqli_real_escape_string($conn, $_REQUEST['person']);
    $slip = mysqli_real_escape_string($conn, $_REQUEST['slip']);
    $date = mysqli_real_escape_string($conn, $_REQUEST['date']);
    $mfg = mysqli_real_escape_string($conn, $_REQUEST['mfg']);
    $exp = mysqli_real_escape_string($conn, $_REQUEST['exp']);
    if (isset($_REQUEST['submit'])) {
    $rid = mysqli_real_escape_string($conn, $_REQUEST['rid']);

    $sql = "UPDATE requisitionlist SET status='2' WHERE id='$rid'";

    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-info'>Updated</div>";

echo $msg;
    } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error Updating Requision List</div>";

        echo $msg;
    }

    }



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
        ($ins > 0 and $outs > 0) or ($ins == 0 and
            $outs == 0) or $ins < 0 or $outs < 0 or ($ins <= 0 and $value <= 0) or ($outs <= 0 and $value <= 0)
    ) {

        echo '<script> const currentUrl = window.location.href; window.location.replace(currentUrl+"?s=de");</script>';
        die();

    }

    $sql = "INSERT INTO store (byuser,item,ins,outs,value,reason,person,slip,date,mfg,exp,remarks,role) 
            VALUES ('$byuser','$item','$ins','$outs','$value','$reason','$person','$slip','$date','$mfg','$exp','$remarks','$role')";
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

                    echo "<div class='alert alert-danger'>Must be > 0 IN/OUT & Value</div>";
                }

            }
            ?>


            <div class="row ">
                <div class="col-sm-12 col-12 ">
                    <div class="card  bg-light">
                        <div class="card-body bg-light">
                            <div class=" text-center">

                                <h1>Store App</h1>

                            </div>
                            <div class="container">
                                <form id="contact-form form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>"
                                    method="post">

                                    <div class="controls">

                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="item">Item (Category ProductName SKU PacketSize)</label>
                                                    <select onchange="stock()" id="select_boxi item" name="item"
                                                        class="form-control select2i" required="required"
                                                        data-error="Please specify.">
                                                        <?php if (isset($_REQUEST['id'])) {echo "<option selected >".$ri." </option>";}
                                                        
                                                        else {  include 'itemselectbox.php'; }
                                                        ?>
                                                       

                                                      

                                                    </select>

                                                </div>
                                            </div>
                                       

  
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="ins">In +</label>
                                                    <input id="ins" type="float" name="ins" class="form-control"
                                                        placeholder="Number/Float" required="required" 
                                                        <?php if (isset($_REQUEST['action']) && !strcmp($_REQUEST['action'],"in")) {echo " value='".$rq."'";}
                                                         else {  echo " value='0'"; }?>
                                                        data-error="Number/Float is required.">

                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="outs">Out -</label>
                                                    <input id="outs" type="float" name="outs" class="form-control"
                                                        placeholder="Number/Float" required="required" 
                                                        <?php if (isset($_REQUEST['action']) && !strcmp($_REQUEST['action'],"out")) {echo " value='".$rq."'";}
                                                         else {  echo " value='0'"; }?>
                                                      
                                                        data-error="Number/Float is required.">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="value">Value TAKA</label>
                                                    <input id="value" type="float" name="value" class="form-control"
                                                        placeholder="Total Value" required="required" value=""
                                                        data-error="value is required.">
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="person">Person/Dept/Company/Shop</label>
                                                    <select id="select_boxp person" name="person"
                                                        class="form-control select2p" required="required"
                                                        data-error="Person/Dept/Company/Shop">
                                                        <?php if (isset($_REQUEST['id'])) {echo "<option selected >".$rp." </option>";}
                                                        
                                                        else {  include 'personselectbox.php'; }
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
                                                    <?php if (isset($_REQUEST['id'])) {echo "value='".$rq."'";}
                                                        
                                                        else {  echo "value='N/A'"; }
                                                        ?> required="required"
                                                        data-error="Reason is required.">
                                                </div>
                                            </div>
                                            <?php if (isset($_REQUEST['id'])) {
                                                 echo "<input type='hidden' value='".$id."' name='rid'>";
                                            }?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="date">Entry Date</label>
                                                    <input id="date" type="text" name="date" class='date form-control'
                                                        value="<?php echo date("Y-m-d"); ?>" required="required"
                                                        data-error="date.">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="mfg">MFG</label>
                                                    <input id="mfg" type="text" name="mfg" class='date form-control'
                                                        value="<?php echo date("Y-m-d"); ?>" required="required"
                                                        data-error="MFG.">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="exp">EXP</label>
                                                    <input id="exp" type="text" name="exp" class='date form-control'
                                                        value="<?php
                                                        $d = date('Y-m-d');

                                                        $dd = strtotime($d);

                                                        $ds = date("Y-m-d", strtotime("+1 year", $dd));


                                                        echo $ds; ?>" required="required" data-error="EXP">
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="remarks">Remarks *</label>
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

            <h1>Submission Table</h1>

        </div>

        <?php

        // Create connection
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT id,item,ins,outs,value,subd,byuser,date,status FROM store WHERE role= '$role' ORDER BY id DESC LIMIT 8";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            ?>




            <div style="overflow-x:auto;">
                <table>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>IN</th>
                        <th>OUT</th>
                        <th>Value</th>
                        <th>Date</th>
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
                    <td>" . $row['ins'] . "</td>
                    <td>" . $row['outs'] . "</td>
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['subd'] . "</td>
                    <td>" . $row['byuser'] . "</td>
                    </tr> ";
                        } else {
                            echo " <tr>
                            <td><a href='" . $_SERVER["PHP_SELF"] . "?del=" . intval($row['id']) * 5877 . "'>X</a></td>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['ins'] . "</td>
                    <td>" . $row['outs'] . "</td>
                    <td>" . $row['value'] . "</td>
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
        </div>
    </div>



</div>
<div																									
id="message"																									
style="																									
display: none;																									
margin: 20px;																									
font-weight: bold;																									
color: green;																									
padding: 8px;																									
background-color: beige;																									
border-radius: 4px;																									
border-color: aquamarine;																									
"																									
></div>




<?php


include "layout2.php";

?>
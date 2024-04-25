<?php


include "layout.php";
?>
<?php

if (isset($_REQUEST['del'])) {

  $id = mysqli_real_escape_string($conn, $_REQUEST['del']);
  $id2=$id/5877;
    $sql = "UPDATE store SET status='1' WHERE id='$id2' AND byuser='$user'";

    if ($conn->query($sql) === TRUE) {
    //  echo "ID: ".$id2." Deleted successfully";
    } else {
      echo "Error Deleting record: " . $conn->error;
    }
    
 

}


if (isset($_REQUEST['undo'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['undo']);
    $id2=$id/5877;
      $sql = "UPDATE store SET status='0' WHERE id='$id2' AND byuser='$user'";
  
      if ($conn->query($sql) === TRUE) {
      //  echo "ID: ".$id2." Deleted successfully";
      } else {
        echo "Error Deleting record: " . $conn->error;
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

    

    $reason = mysqli_real_escape_string($conn, $_REQUEST['reason']);

    if (!strcmp($reason, "N/A")) {


        $reason = "";

    }


    $remarks = mysqli_real_escape_string($conn, $_REQUEST['remarks']);

    if (!strcmp($remarks, "N/A")) {


        $remarks = "";

    }


    $role = $_SESSION['SESSION_ROLE'];

    if (($ins>0  AND $outs>0) OR ($ins==0  AND
     $outs==0) OR $ins<0 OR $out<0 OR ($ins<=0  AND $value<=0) OR ($outs<=0  AND $value<=0)) {

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

    <div class="leftbox">

        <!-- /.form-->
        <div class="container">

            <?php
            if (isset($_GET['s'])) {

                if ($_GET['s'] == "t") {
                    echo "<div class='alert alert-info'>Successfully Saved to the Database</div>";

                } else if ($_GET['s'] == "f") {

                    echo "<div class='alert alert-danger'>Something wrong went</div>";
                }

                else if ($_GET['s'] == "de") {

                    echo "<div class='alert alert-danger'>Must be > 0 IN/OUT & Value</div>";
                }

            }
            ?>
            <div class=" text-center">

                <h1>Store App</h1>

            </div>
            <style>
                .btn-send {
                    font-weight: 300;
                    text-transform: uppercase;
                    letter-spacing: 0.2em;
                    width: 80%;
                    margin-left: 3px;
                }

                .help-block.with-errors {
                    color: #ff5050;
                    margin-top: 5px;

                }

                .row {}
            </style>
            <div class="row ">
                <div class="col-lg-12 mx-auto">
                    <div class="card mt-2 mx-auto p-4 bg-light">
                        <div class="card-body bg-light">

                            <div class="container">
                                <form id="contact-form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>"
                                    method="post">

                                    <div class="controls">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="item">Item (Category ProductName SKU PacketSize)</label>
                                                    <select id="select_boxi item" name="item"
                                                        class="form-control select2i" required="required"
                                                        data-error="Please specify.">
                                                        <option value="" selected disabled>Item Name Details
                                                        </option>

                                                        <?php
                                                        include 'itemselectbox.php';
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="ins">In +</label>
                                                    <input id="ins" type="float" name="ins" class="form-control"
                                                        placeholder="Number/Float" required="required" value="0"
                                                        data-error="Number/Float is required.">

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="outs">Out -</label>
                                                    <input id="outs" type="float" name="outs" class="form-control"
                                                        placeholder="Number/Float" required="required" value="0"
                                                        data-error="Number/Float is required.">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="value">Value TAKA</label>
                                                    <input id="value" type="float" name="value" class="form-control"
                                                        placeholder="Total Value" required="required" value="0"
                                                        data-error="value is required.">
                                                </div>
                                            </div>
                                         
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="person">Person/Dept/Company/Shop</label>
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

                                         
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="slip">Slip Number</label>
                                                    <input id="slip" type="text" name="slip" class="form-control"
                                                        placeholder="Slip Number" required="required" value="0"
                                                        data-error="Slip is required.">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="reason">Reason</label>
                                                    <input id="reason" type="text" name="reason" class="form-control"
                                                        value="N/A" required="required"
                                                        data-error="Reason is required.">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="date">Entry Date</label>
                                                    <input id="date" type="text" name="date" class="form-control"
                                                        value="<?php echo date("Y-m-d"); ?>" required="required"
                                                        data-error="date.">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="mfg">MFG</label>
                                                    <input id="mfg" type="text" name="mfg" class="form-control"
                                                        value="<?php echo date("Y-m-d"); ?>" required="required"
                                                        data-error="MFG.">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exp">EXP</label>
                                                    <input id="exp" type="text" name="exp" class="form-control"
                                                        value="<?php
                                                        $d=date('Y-m-d');

                                                        $dd=strtotime($d);
                                                      
                                                        $ds= date("Y-m-d", strtotime("+1 year", $dd));
                                                        
                                                        
                                                        echo $ds; ?>" required="required"
                                                        data-error="EXP">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="remarks">Remarks *</label>
                                                    <input id="remarks" type="text" name="remarks" class="form-control"
                                                        value="N/A" required="required" data-error="Remarks">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-12">

                                                <input type="submit" name="submit"
                                                    class="btn btn-success btn-send  pt-2 btn-block" value="Save">

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

    <div class="rightbox">

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





            <style>
                table {
                    width: 100%;
                    border: 1px solid #ddd;
                }

                th,
                td {
                    text-align: left;
                    padding: 8px;
                }

                tr:nth-child(even) {
                    background-color: #f2f2f2
                }
            </style>

            <div class=" text-center">

                <h1>Submission Table</h1>

            </div>


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
                        
                        if ($row['status']==1){

                            echo " <tr style='color:red;'>
                            <td><a href='".$_SERVER["PHP_SELF"]."?undo=" . intval($row['id'])*5877 . "'>+</a></td>
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
                        else{
                            echo " <tr>
                            <td><a href='".$_SERVER["PHP_SELF"]."?del=" . intval($row['id'])*5877 . "'>X</a></td>
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
<?php


include "layout2.php";

?>
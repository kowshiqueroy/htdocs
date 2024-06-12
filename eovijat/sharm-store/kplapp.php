<?php


include "layout.php";
?>
<?php



if (isset($_REQUEST['del'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['del']);
    $id2 = $id / 5877;
    $sql = "UPDATE kpl SET status='1' WHERE id='$id2' AND byuser='$user'";

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
    $sql = "UPDATE kpl SET status='0' WHERE id='$id2' ";

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
    $km = mysqli_real_escape_string($conn, $_REQUEST['km']);
    $oil = mysqli_real_escape_string($conn, $_REQUEST['oil']);
    $value = mysqli_real_escape_string($conn, $_REQUEST['value']);
    $person = mysqli_real_escape_string($conn, $_REQUEST['person']);
    $slip = mysqli_real_escape_string($conn, $_REQUEST['slip']);
    $date = mysqli_real_escape_string($conn, $_REQUEST['date']);
    $pump = mysqli_real_escape_string($conn, $_REQUEST['pump']);
    





 


    $remarks = mysqli_real_escape_string($conn, $_REQUEST['remarks']);

    if (!strcmp($remarks, "N/A")) {


        $remarks = "";

    }


    $role = $_SESSION['SESSION_ROLE'];

    if ( ($km <= 0 or $oil <= 0 or $value <= 0)) {

     echo '<script> const currentUrl = window.location.href; window.location.replace(currentUrl+"?s=de");</script>';
        die();

     // echo $km.$oil.$value;

    }

    

$dis=0;

    $sql4 = "SELECT km FROM kpl WHERE role= '$role' AND item='$item' AND status=0 ORDER BY id DESC LIMIT 2";
    $result4 = mysqli_query($conn, $sql4);

    $p2km=0;

    if (mysqli_num_rows($result4) > 0) {
        while ($row4 = mysqli_fetch_assoc($result4)) {

$p2km= $row4['km'];



        }

    }
   // echo $p2km."/";

    $sql2 = "SELECT id FROM kpl WHERE role= '$role' AND item='$item' AND status=0 ORDER BY id DESC LIMIT 1";
    $result2 = mysqli_query($conn, $sql2);

    $pid=0;
    $pkm=0;

    if (mysqli_num_rows($result2) > 0) {
        while ($row2 = mysqli_fetch_assoc($result2)) {

$pid= $row2['id'];
$pkm= $km;
$dis=$km-$p2km;
//echo $dis." ".$pkm." ".$pid;

$sql3 = "UPDATE kpl SET km='$km', distance='$dis' WHERE id='$pid' AND  role= '$role' ";

if ($conn->query($sql3) === TRUE) {
    $msg = "<div class='alert alert-info'>Deleted</div>";


} else {
    echo "Error: " . $conn->error;
    $msg = "<div class='alert alert-info'>Error</div>";


}

        }

    }


    $sql = "INSERT INTO kpl (byuser,item,km,oil,value,pump,person,slip,date,remarks,role) 
            VALUES ('$byuser','$item','$km','$oil','$value','$pump','$person','$slip','$date','$remarks','$role')";
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

                    echo "<div class='alert alert-danger'>Must be > 0 KM, L & Value</div>";
                }

            }
            ?>


            <div class="row ">
                <div class="col-sm-12 col-12 ">
                    <div class="card  bg-light">
                        <div class="card-body bg-light">
                            <div class=" text-center">

                                <h1>KpL App</h1>

                            </div>
                            <div class="container">
                                <form id="contact-form form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>"
                                    method="post">

                                    <div class="controls">

                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="item">Vehicle Details/Number</label>
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
                                                    <label for="km">Previous KM</label>
                                                    <input id="km" type="float" name="km" class="form-control"
                                                        placeholder="KM" required="required" value=""
                                                        data-error="value is required.">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="oil">New Oil Re-fill</label>
                                                    <input id="oil" type="float" name="oil" class="form-control"
                                                        placeholder="L" required="required" value=""
                                                        data-error="value is required.">
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
                                                    <label for="pump">Pump</label>
                                                    <select id="select_boxp pump" name="pump"
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
                                                    <label for="person">Driver/Person</label>
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


                                          
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="date">Entry Date</label>
                                                    <input id="date" type="text" name="date" class='date form-control'
                                                        value="<?php echo date("Y-m-d"); ?>" required="required"
                                                        data-error="date.">
                                                </div>
                                            </div>
                                           

                                            <div class="col-sm-8">
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

            <h1>Submission Table</h1>

        </div>

        <?php

        // Create connection
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT id,item,km,oil,value,subd,byuser,date,status, distance FROM kpl WHERE role= '$role' ORDER BY id DESC LIMIT 8";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            ?>




            <div style="overflow-x:auto;">
                <table>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Vehicle</th>
                        <th>KM</th>
                        <th>Oil</th>
                      
                        <th>Value</th>
                        <th>Distance</th>
                        <th>KM/L</th>
                        <th>V/KM</th>

                        <th>Date</th>
                        <th>Submission</th>
                        <th>By</th>

                    </tr>
                    <?PHP
                    // output data of each row
                    $n=0;
                    while ($row = mysqli_fetch_assoc($result)) {


                       

                        if ($row['status'] == 1) {

                            echo "<tr style='color:red;'>";


                            if ($n==0){
                                echo " 
                                <td><a href='" . $_SERVER["PHP_SELF"] . "?undo=" . intval($row['id']) * 5877 . "'>+</a></td>";

                            }
                            else{
                                echo "<td></td>";
                                
                            }
                           
                        


                            echo "
                        
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['km'] . "</td>
                    <td>" . $row['oil'] . "</td>
                   
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['distance'] . "</td>
                    <td>" . round($row['distance']/$row['oil'],2)  . "</td>
                    <td>" . round($row['distance']/$row['value'],2) . "</td>
                  
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['subd'] . "</td>
                    <td>" . $row['byuser'] . "</td>
                    </tr> ";
                        } else {
                            echo "<tr style='color:green;'>";
                            if ($n==0){
                            echo " 
                            <td><a href='" . $_SERVER["PHP_SELF"] . "?del=" . intval($row['id']) * 5877 . "'>X</a></td>";}
                            else{
                                echo "<td></td>";
                                
                            }

                            echo "
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['km'] . "</td>
                    <td>" . $row['oil'] . "</td>
                 
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['distance'] . "</td>
                    <td>" . round($row['distance']/$row['oil'],2)  . "</td>
                    <td>" . round($row['value']/$row['distance'],2) . "</td>
                  
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['subd'] . "</td>
                    <td>" . $row['byuser'] . "</td>
                    </tr> ";
                  
                        }

  $n=1;
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
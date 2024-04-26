<?php


include "layout.php";
?>







<div class="fullbox">



    <?php

    $fod = "";
    $tod = "";
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT DISTINCT item FROM store WHERE role= '$role' ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        ?>

        <div class=" text-center">
            <h5><?PHP echo $role; ?> &nbsp;&nbsp;&nbsp;&nbsp;<b> Store Stock </b>
                &nbsp;&nbsp;&nbsp;&nbsp; Date:<?php echo date('Y.m.d'); ?> </h5>


        </div>


    <div class="noprint">

        <div class="col-lg-12 d-flex justify-content-center ">

            <form id="contact-form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>" method="post">


                <div class="controls">

                    <div class="row">

                        <input onclick="window.location.replace(window.location.href);" style="height:40px; margin:20px;"
                            class="btn btn-success btn-send col-sm-2 col-auto" value="Refresh">


                        <div class="col-sm-3 col-12 ">
                            <div class="form-group">
                                <label for="fromdate">From:</label>
                                <input type="text" name="fromdate" class="form-control " id="fromdate" value="<?php if (isset($_REQUEST['fromdate'])) {
                                    echo $_REQUEST['fromdate'];
                                } else {
                                    echo date('Y-m-d');
                                } ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12 ">
                            <div class="form-group">
                                <label for="todate">To:</label>
                                <input type="text" name="todate" class="form-control " id="todate" value="<?php if (isset($_REQUEST['todate'])) {
                                    echo $_REQUEST['todate'];
                                } else {
                                    echo date('Y-m-d');
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
            if (isset($_REQUEST['fromdate'])) {

                $fod = $_REQUEST['fromdate'];



            }

            if (isset($_REQUEST['todate'])) {

                $tod = $_REQUEST['todate'];



            }

            ?>



       


        <div style="overflow-x:auto;">







            <table>

                <tr>
                    <th colspan="2"></th>
                    <th colspan="4"><?php echo "Before " . $fod; ?></th>
                    <th colspan="4"><?php echo $fod . " to " . $tod; ?></th>
                    <th colspan="4"><?php echo date('Y-m-d'); ?> Today</th>
                </tr>
                <tr>

                    <th>SL</th>
                    <th>Item</th>

                    <th>In</th>
                    <th>Out</th>
                    <th>Value</th>
                    <th>Stock</th>

                    <th>In</th>
                    <th>Out</th>
                    <th>Value</th>
                    <th>Stock</th>

                    <th>In</th>
                    <th>Out</th>
                    <th>Value</th>
                    <th>Stock</th>




                </tr>

                <?PHP
                // output data of each row
                $sl = 1;

                $tod2 = $tod;
                $fod2 = $fod;
                $tod = strtotime($tod);
                $fod = strtotime($fod);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo " <tr>

               
                <td>" . $sl . "</td>
           
                <td>" . $row['item'] . "</td>";
                    $sl++;
                    $i = $row['item'];



                    $sql2 = "SELECT  ins,outs,value,date FROM store WHERE role= '$role'AND status=0 AND item='$i'";

                    $ti = 0;
                    $to = 0;
                    $tv = 0;

                    $bti = 0;
                    $bto = 0;
                    $btv = 0;


                    $pti = 0;
                    $pto = 0;
                    $ptv = 0;

                    $result2 = mysqli_query($conn, $sql2);

                    if (mysqli_num_rows($result2) > 0) {


                        while ($row2 = mysqli_fetch_assoc($result2)) {







                            $d = $row2['date'];
                            $dt = strtotime($d);





                            if ($dt <= $tod && $dt >= $fod) {



                                $bti += intval($row2['ins']);
                                $bto += intval($row2['outs']);


                                if (intval($row2['ins']) > 0) {


                                    $btv += intval($row2['value']);
                                } else {
                                    $btv -= intval($row2['value']);
                                }


                            }

                            if ($dt < $fod) {

                                $pti += intval($row2['ins']);
                                $pto += intval($row2['outs']);


                                if (intval($row2['ins']) > 0) {


                                    $ptv += intval($row2['value']);
                                } else {
                                    $ptv -= intval($row2['value']);
                                }


                            }

                            $ti += intval($row2['ins']);
                            $to += intval($row2['outs']);


                            if (intval($row2['ins']) > 0) {


                                $tv += intval($row2['value']);
                            } else {
                                $tv -= intval($row2['value']);
                            }



                        }

                        $s = $ti - $to;
                        $bs = $bti - $bto;
                        $ps = $pti - $pto;
                        echo " 
                        <td>" . $pti . "</td>
                        <td>" . $pto . "</td>
                        <td>" . $ptv . "</td>
                        <td>" . $ps . "</td>
    
                        <td>" . $bti . "</td>
                        <td>" . $bto . "</td>
                        <td>" . $btv . "</td>
                        <td>" . $bs . "</td>

                        <td>" . $ti . "</td>
                        <td>" . $to . "</td>
                        <td>" . $tv . "</td>
                        <td>" . $s . "</td> ";
                    }

                    echo "</tr>";

                }
    } else {
        echo "<h1 class='text-center'>No data available at this moment</h1>";
    }

    mysqli_close($conn);
    ?>
        </table>

    </div>

</div>
<?php


include "layout2.php";

?>
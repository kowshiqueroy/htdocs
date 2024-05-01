<?php


include "layout.php";
$fromdate = date('Y-m-d');

?>







<div class="fullbox">

    <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th,
        td {
            text-align: left;
            padding: 8px;

        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
            border: solid thin;
        }

        tr:nth-child(odd) {
            border: solid thin;

        }
    </style>


    <div class=" text-center">

        <h5><?PHP echo $role; ?> &nbsp;&nbsp;&nbsp;&nbsp;<b> Store Out </b>
            &nbsp;&nbsp;&nbsp;&nbsp; Date:<?php echo date('Y.m.d'); ?> </h5>


        <div class="col-lg-12 d-flex justify-content-center">

            <form id="contact-form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>" method="post">


                <div class="controls">

                    <div class="row">

                        <input onclick="window.location.replace(window.location.href);"
                            style="height:40px; margin:20px;" class="btn btn-success btn-send col-sm-1 noprint col-auto"
                            value="Refresh">

                        <div class="col-sm-auto col-12 ">
                            <div class="form-group">
                                <label for="item">Item:</label>
                                <input type="text" name="item" id="item" class="form-control " value="<?php if (isset($_REQUEST['item'])) {
                                    echo $_REQUEST['item'];
                                } else {
                                    echo "All";
                                } ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-2 col-12 ">
                            <div class="form-group">
                                <label for="fromdate">From:</label>
                                <input type="text" name="fromdate" class='date form-control' id="fromdate" value="<?php if (isset($_REQUEST['fromdate'])) {
                                    echo $_REQUEST['fromdate'];
                                } else {
                                    echo date('Y-m-d');
                                } ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-2 col-12 ">
                            <div class="form-group">
                                <label for="todate">To:</label>
                                <input type="text" name="todate" class='date form-control' id="todate" value="<?php if (isset($_REQUEST['todate'])) {
                                    echo $_REQUEST['todate'];
                                } else {
                                    echo date('Y-m-d');
                                } ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-auto col-12 ">
                            <div class="form-group">
                                <label for="person">Person:</label>
                                <input type="text" name="person" class="form-control " id="person" value="<?php if (isset($_REQUEST['person'])) {
                                    echo $_REQUEST['person'];
                                } else {
                                    echo "All";
                                } ?>" required>
                            </div>
                        </div>

                        <input style="height:40px; margin:20px;" type="submit" name="submit"
                            class="btn btn-success btn-send col-sm-1 noprint col-auto" value="View">


                    </div>
                </div>
            </form>

        </div>
    </div>
    <?php

    if (isset($_REQUEST['submit'])) {

        $item = $_REQUEST['item'];
        $fromdate = $_REQUEST['fromdate'];
        $todate = $_REQUEST['todate'];
        $person = $_REQUEST['person'];

        if (!strcmp($item, "All")) {


            $item = "";

        }
        if (!strcmp($person, "All")) {


            $person = "";

        }

        $sql = "SELECT * FROM store WHERE role= '$role' AND outs>0 AND status='0' AND DATE(date) >= DATE('$fromdate') AND DATE(date) <= DATE('$todate')
AND item Like '%$item%' AND person like '%$person%' ORDER BY id DESC";

    } else {
        $sql = "SELECT * FROM store WHERE role= '$role' AND outs>0 AND status='0' ORDER BY id DESC LIMIT 10";

    }
    $tn = 0;
    $tv = 0;

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        ?>

        <div class="mt-1" style="overflow-x:auto;">
            <table>
                <tr>

                    <th>SL</th>
                    <th class=''>Entry</th>
                    <th>Item Name</th>
                    <th>Out</th>

                    <th>Value</th>
                    <th>Person/Dept</th>
                    <th>Reason</th>
                    <th>Slip</th>
                    <th>MFG</th>
                    <th>EXP</th>
                    <th>Remarks</th>
                    <th class='noprint'>ID</th>
                    <th class='noprint'>By</th>



                </tr>

                <?PHP
                // output data of each row
            
                $d = date('Y-m-d');

                $dd = strtotime($d);

                $ds = date("Y-m-d", strtotime("+6 month", $dd));

                $ds = strtotime($ds);



                $sl = 1;
                while ($row = mysqli_fetch_assoc($result)) {


                    $expd = strtotime($row['exp']);


                    if ($expd >= $ds) {


                        echo " <tr style='color:black;'>
               

                  
                  <td>" . $sl . "</td>
                  <td >" . $row['date'] . "</td>
                  <td>" . $row['item'] . "</td>
                  <td>" . $row['outs'] . "</td>
                
                  <td>" . $row['value'] . "</td>
                  <td>" . $row['person'] . "</td>
                  <td>" . $row['reason'] . "</td>
                  <td>" . $row['slip'] . "</td>
                  <td >" . $row['mfg'] . "</td>
                  <td >" . $row['exp'] . "</td>
                  <td>" . $row['remarks'] . "</td>
                  <td class='noprint'>" . $row['id'] . "</td>  
                  <td class='noprint'>" . $row['byuser'] . "</td>  
                
               
              
                  </tr> ";


                    } else if ($expd < $ds && $expd >= $dd) {


                        echo " <tr style='color:blue;'>
                 

                    
                    <td>" . $sl . "</td>
                    <td >" . $row['date'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['outs'] . "</td>
                  
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['reason'] . "</td>
                    <td>" . $row['slip'] . "</td>
                    <td >" . $row['mfg'] . "</td>
                    <td >" . $row['exp'] . "</td>
                    <td>" . $row['remarks'] . "</td>
                    <td class='noprint'>" . $row['id'] . "</td>  
                    <td class='noprint'>" . $row['byuser'] . "</td>  
                  
                 
                
                    </tr> ";


                    } else {

                        echo " <tr style='color:green;'>

                     
                    <td>" . $sl . "</td>
                    <td >" . $row['date'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['outs'] . "</td>
                  
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['reason'] . "</td>
                    <td>" . $row['slip'] . "</td>
                    <td >" . $row['mfg'] . "</td>
                    <td >" . $row['exp'] . "</td>
                    <td>" . $row['remarks'] . "</td>
                    <td class='noprint'>" . $row['id'] . "</td>  
                    <td class='noprint'>" . $row['byuser'] . "</td> 
                 
                
                    </tr> ";



                    }
                    $sl++;
                    $tn += floatval($row['outs']);
                    $tv += floatval($row['value']);
                }


                echo "   <tr>
               
                <th colspan='3'></th>
                <th >" . $tn . "</th>
                <th >" . $tv . "</th>
                <th colspan='6'></th>
                
               
            </tr> ";


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
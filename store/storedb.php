<?php


include "layout.php";
?>







<div class="fullbox ">

<div class=" text-center">

<h5><?PHP echo $role; ?> &nbsp;&nbsp;&nbsp;&nbsp;<b> Store Database </b>
    &nbsp;&nbsp;&nbsp;&nbsp; Date:<?php echo date('Y.m.d'); ?> </h5>


<div class="col-lg-12 d-flex justify-content-center">

    <form id="contact-form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>" method="post">


        <div class="controls">

            <div class="row">

             
         
                <div class="col-sm-3 col-12 ">
                    <div class="form-group">
                        <label for="item">Item:</label>
                        <input type="text" name="item" id="item" class="form-control " value="<?php if (isset($_REQUEST['item'])) {
                            echo $_REQUEST['item'];
                        } else {
                            echo "All";
                        } ?>" required>
                    </div>
                </div>
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
                <div class="col-sm-3 col-12 " >
                    <div class="form-group">
                        <label for="todate">To:</label>
                        <input type="text" name="todate" class="form-control " id="todate" value="<?php if (isset($_REQUEST['todate'])) {
                            echo $_REQUEST['todate'];
                        } else {
                            echo date('Y-m-d');
                        } ?>" required>
                    </div>
                </div>
                <div class="col-sm-3 col-12 ">
                    <div class="form-group">
                        <label for="person">Person:</label>
                        <input type="text" name="person" class="form-control " id="person" value="<?php if (isset($_REQUEST['person'])) {
                            echo $_REQUEST['person'];
                        } else {
                            echo "All";
                        } ?>" required>
                    </div>
                </div>

                <div class="col-sm-3 col-12 ">
                    <div class="form-group">
                        <label for="insg">In ></label>
                        <input type="number" name="insg" class="form-control " id="insg" value="<?php if (isset($_REQUEST['insg'])) {
                            echo $_REQUEST['insg'];
                        } else {
                            echo "0";
                        } ?>" required>
                    </div>
                </div>
                <div class="col-sm-3 col-12 ">
                    <div class="form-group">
                        <label for="outsg">Out > </label>
                        <input type="number" name="outsg" class="form-control " id="outsg" value="<?php if (isset($_REQUEST['outsg'])) {
                            echo $_REQUEST['outsg'];
                        } else {
                            echo "0";
                        } ?>" required>
                    </div>
                </div>
                <div class="col-sm-3 col-12 ">
                    <div class="form-group">
                        <label for="valuel">Value < </label>
                        <input type="number" name="valuel" class="form-control " id="valuel" value="<?php if (isset($_REQUEST['valuel'])) {
                            echo $_REQUEST['valuel'];
                        } else {
                            echo "100000";
                        } ?>" required>
                    </div>
                </div>
                <div class="col-sm-3 col-12 ">
                    <div class="form-group">
                        <label for="word">Word:</label>
                        <input type="text" name="word" class="form-control " id="word" value="<?php if (isset($_REQUEST['word'])) {
                            echo $_REQUEST['word'];
                        } else {
                            echo "All";
                        } ?>" required>
                    </div>
                </div>

            

                    <input onclick="window.location.replace(window.location.href);"
                    style="height:40px; margin:20px;" class="btn btn-success btn-send col-sm-6 noprint col-auto"
                    value="Refresh">
                    <input style="height:40px; margin:20px;" type="submit" name="submit"
                    class="btn btn-success btn-send col-sm-5 noprint col-auto" value="View">
                 


            </div>
        </div>
    </form>

</div>
</div>

    

    <?php


    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $item = "";
    $person = "";
    $insg = 0;
    $outsg = 0;
    $valuel = 10000000;
    $fromdate = "1997-11-01";
    $todate = date('Y-m-d');
    $word = "";


    if (isset($_REQUEST['submit'])) {


        $item = $_REQUEST['item'];

        if (!strcmp($item, "All")) {

            $item = "";
        }

        $person = $_REQUEST['person'];


        if (!strcmp($person, "All")) {

            $person = "";

        }


        $insg = $_REQUEST['insg'];



        $outsg = $_REQUEST['outsg'];



        $valuel = $_REQUEST['valuel'];

        $fromdate = $_REQUEST['fromdate'];
        $todate = $_REQUEST['todate'];
        $word = $_REQUEST['word'];

        if (!strcmp($word, "All")) {

            $word = "";
        }


        $sql = "SELECT * FROM store WHERE role= '$role' AND item like '%$item%' AND person like '%$person%'
        AND ((ins>'$insg' OR outs>'$outsg') AND value< '$valuel')AND DATE(date) >= DATE('$fromdate') AND DATE(date) <= DATE('$todate')
    
        AND ( reason like '%$word%'
        OR slip like '%$word%'
        OR reason like '%$word%'
        OR mfg like '%$word%'
        OR exp like '%$word%'
        OR remarks like '%$word%'
        OR id like '%$word%'
        OR status like '%$word%'
        OR person like '%$word%'
        OR byuser like '%$word%'
        ) AND status ='0'
          ORDER BY id DESC";


    }

    else {
        $sql = "SELECT * FROM store WHERE role= '$role' AND status!='0'  ORDER BY id DESC";


    }








    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        ?>
       





        <div style="overflow-x:auto;">



            <table>
                <tr>
                   
                    <th>SL</th>
                    <th class=''>Date</th>
                    <th>Item Name</th>
                    <th>IN</th>
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
                $sl = 1;

                $tin=0;
                $tout=0;
                $tval=0;
                while ($row = mysqli_fetch_assoc($result)) {


                    if ($row['status'] == 0) {


                        echo " <tr>

                     
                        <td>" . $sl . "</td>
                        <td class=''>" . $row['date'] . "</td>
                        <td class='itemnametb'>" . $row['item'] . "</td>
                        <td>" . $row['ins'] . "</td>
                        <td>" . $row['outs'] . "</td>
                        <td>" . $row['value'] . "</td>
                        <td>" . $row['person'] . "</td>
                        <td>" . $row['reason'] . "</td>
                        <td>" . $row['slip'] . "</td>
                        <td>" . $row['mfg'] . "</td>
                        <td>" . $row['exp'] . "</td>
                        <td>" . $row['remarks'] . "</td>
                        <td class='noprint'>" . $row['id'] . "</td>  
                        <td class='noprint'>" . $row['byuser'] . "</td>  
                     
                    
                        </tr> ";

                    } else {

                        echo " <tr style='color:red;' class=''>

                       
                        <td>Deleted ".$row['subd']."</td>
                        <td class=''>" . $row['date'] . "</td>
                        <td class='itemnametb'>" . $row['item'] . "</td>
                        <td>" . $row['ins'] . "</td>
                        <td>" . $row['outs'] . "</td>
                        <td>" . $row['value'] . "</td>
                        <td>" . $row['person'] . "</td>
                        <td>" . $row['reason'] . "</td>
                        <td>" . $row['slip'] . "</td>
                        <td>" . $row['mfg'] . "</td>
                        <td>" . $row['exp'] . "</td>
                        <td>" . $row['remarks'] ." ".$row['byuser']."</td>
                        <td class='noprint'>" . $row['id'] . "</td>  
                        <td class='noprint'>" . $row['byuser'] . "</td>  
                     
                    
                        </tr> ";
                        $sl--;
                    }
                    $sl++;

                    $tin+=floatval($row['ins']);
                    $tout+=floatval($row['outs']);
                    $tval+=floatval($row['value']);
                }
                echo " <tr>

                     <td colspan='3'></td>  
                <td >".$tin."</td>
                <td >".$tout."</td>
                <td >".$tval."</td>
               
             
            
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
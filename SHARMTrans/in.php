<?php


include "layout.php";

if (isset($_REQUEST['submit'])){

$item=$_REQUEST['item'];
$fromdate=$_REQUEST['fromdate'];
$todate=$_REQUEST['todate'];
$person=$_REQUEST['person'];

if (!strcmp($item, "All")) {


    $item = "";

}
if (!strcmp($person, "All")) {


    $person = "";

}

$sql = "SELECT * FROM store WHERE role= '$role' AND ins>0 AND status='0' AND DATE(date) >= DATE('$fromdate') AND DATE(date) <= DATE('$todate')
AND item Like '%$item%' AND person like '%$person%' ORDER BY id DESC";

}
else{
    $sql = "SELECT * FROM store WHERE role= '$role' AND ins>0 AND status='0' ORDER BY id DESC";

}
$tn=0;
$tv=0;

?>







<div class="fullbox">


<div class=" text-center noprint">

<form id="contact-form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>"
                                    method="get">
Item: 
<input type="text" name="item" value="<?php if (isset($_REQUEST['item'])){ echo $_REQUEST['item'];} else{echo "All";}?>" required>
From: 
<input type="text" name="fromdate" value="<?php if (isset($_REQUEST['fromdate'])){ echo $_REQUEST['fromdate'];} else{echo date('Y-m-d');}?>"  required>
To:
<input type="text" name="todate" value="<?php if (isset($_REQUEST['todate'])){ echo $_REQUEST['todate'];} else{echo date('Y-m-d');}?>"  required>
By: 
<input type="text" name="person" value="<?php if (isset($_REQUEST['person'])){ echo $_REQUEST['person'];} else{echo "All";}?>"  required>
<input type="submit" name="submit" class="btn btn-success btn-send   " value="View">
</form>

</div>

    <?php


    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

   
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        ?>
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

            <h3><?PHP echo $role; ?> &nbsp;&nbsp;&nbsp;&nbsp;<b> Store In </b> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y.m.d');?> </h3>

        </div>


        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th class='noprint'>ID</th>
                    <th class='noprint'>By</th>
                    <th>SL</th>
                    <th class='noprint'>Date</th>
                    <th>Item Name</th>
                    <th>IN</th>
                   
                    <th>Value</th>
                    <th>Person/Dept</th>
                    <th>Reason</th>
                    <th>Slip</th>
                    <th>MFG</th>
                    <th>EXP</th>
                    <th>Remarks</th>



                </tr>

                <?PHP
                // output data of each row

                $d=date('Y-m-d');

                $dd=strtotime($d);
              
                $ds= date("Y-m-d", strtotime("+6 month", $dd));

                $ds=strtotime($ds);
                echo $dd." ".$ds."<br>";


                $sl = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                  

                $expd= strtotime($row['exp']);
                echo $dd;

                if($expd>=$ds)
                {


                  echo " <tr style='color:black;'>
               

                  <td class='noprint'>" . $row['id'] . "</td>  
                  <td class='noprint'>" . $row['byuser'] . "</td>  
                  <td>" . $sl . "</td>
                  <td class='noprint'>" . $row['date'] . "</td>
                  <td>" . $row['item'] . "</td>
                  <td>" . $row['ins'] . "</td>
                
                  <td>" . $row['value'] . "</td>
                  <td>" . $row['person'] . "</td>
                  <td>" . $row['reason'] . "</td>
                  <td>" . $row['slip'] . "</td>
                  <td>" . $row['mfg'] . "</td>
                  <td>" . $row['exp'] . "</td>
                  <td>" . $row['remarks'] . "</td>
                
               
              
                  </tr> ";


                }
                  else if($expd<$ds && $expd>=$dd )
                  {


                    echo " <tr style='color:blue;'>
                 

                    <td class='noprint'>" . $row['id'] . "</td>  
                    <td class='noprint'>" . $row['byuser'] . "</td>  
                    <td>" . $sl . "</td>
                    <td class='noprint'>" . $row['date'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['ins'] . "</td>
                  
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['reason'] . "</td>
                    <td>" . $row['slip'] . "</td>
                    <td>" . $row['mfg'] . "</td>
                    <td>" . $row['exp'] . "</td>
                    <td>" . $row['remarks'] . " Expiring Less than 6 months</td>
                  
                 
                
                    </tr> ";


                  }
                  
                  
                  
                  else{

                    echo " <tr style='color:green;'>

                    <td class='noprint'>" . $row['id'] . "</td>  
                    <td class='noprint'>" . $row['byuser'] . "</td>  
                    <td>" . $sl . "</td>
                    <td class='noprint'>" . $row['date'] . "</td>
                    <td>" . $row['item'] . "</td>
                    <td>" . $row['ins'] . "</td>
                  
                    <td>" . $row['value'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['reason'] . "</td>
                    <td>" . $row['slip'] . "</td>
                    <td>" . $row['mfg'] . "</td>
                    <td>" . $row['exp'] . "</td>
                    <td>" . $row['remarks'] . " Expired</td>
                 
                
                    </tr> ";



                  }
                    $sl++;
                    $tn+=intval($row['ins']);
                    $tv+=intval($row['value']);
                }
    } else {
        echo "<h1 class='text-center'>No data available at this moment</h1>";
    }

    mysqli_close($conn);
    ?>
        </table>

        <?php
        echo "<h4 class='text-center'>"; if (isset($_REQUEST['fromdate'])){ echo "From: ".$_REQUEST['fromdate'];} 
        
        
        if (isset($_REQUEST['todate'])){ echo " To: ".$_REQUEST['todate'];} 

        echo" Total Number: ".$tn." Total Value: ".$tv."</h4>";
        ?>
    </div>

</div>
<?php


include "layout2.php";

?>
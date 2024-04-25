<?php


include "layout.php";
?>







<div class="fullbox ">

<div class=" text-center noprint" style="font-size:10px;">

<form  id="contact-form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>"
                                    method="post">
Item: 
<input class="col-md-1" type="text" name="item" value="<?php if (isset($_REQUEST['item'])){ echo $_REQUEST['item'];} else{echo "All";}?>" required>
From: 
<input class="col-md-1" type="text" name="fromdate" value="<?php if (isset($_REQUEST['fromdate'])){ echo $_REQUEST['fromdate'];} else{echo "1997-11-01";}?>"  required>
To:
<input class="col-md-1" type="text" name="todate" value="<?php if (isset($_REQUEST['todate'])){ echo $_REQUEST['todate'];} else{echo date('Y-m-d');}?>"  required>
Person: 
<input class="col-md-1" type="text" name="person" value="<?php if (isset($_REQUEST['person'])){ echo $_REQUEST['person'];} else{echo "All";}?>"  required>
In> 
<input class="col-md-1" type="number" name="insg" value="<?php if (isset($_REQUEST['insg'])){ echo $_REQUEST['insg'];} else{echo "0";}?>"  required>
Out> 
<input class="col-md-1" type="number" name="outsg" value="<?php if (isset($_REQUEST['outsg'])){ echo $_REQUEST['outsg'];} else{echo "0";}?>"  required>
Value< 
<input class="col-md-1" type="number" name="valuel" value="<?php if (isset($_REQUEST['valuel'])){ echo $_REQUEST['valuel'];} else{echo "100000000";}?>"  required>
Word: 
<input class="col-md-1" type="text" name="word" value="<?php if (isset($_REQUEST['word'])){ echo $_REQUEST['word'];} else{echo "All";}?>"  required>





<input  type="submit" name="submit" class="btn btn-success btn-send   " value="View">
</form>

</div>

    <?php


    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $item="";
    $person="";
    $insg=0;
    $outsg=0;
    $valuel=10000000;
    $fromdate="1997-11-01";
    $todate=date('Y-m-d');
    $word="";


    if (isset($_REQUEST['submit'])){ 
        
        
       $item= $_REQUEST['item'];
      
       if(!strcmp($item,"All")){

        $item="";
       }

       $person= $_REQUEST['person'];
     
      
       if(!strcmp($person,"All")){

        $person="";
 
       }
    

       $insg= $_REQUEST['insg'];
      
     

       $outsg= $_REQUEST['outsg'];
      
      

       $valuel= $_REQUEST['valuel'];
      
       $fromdate=$_REQUEST['fromdate'];
       $todate=$_REQUEST['todate'];
       $word=$_REQUEST['word'];

       if(!strcmp($word,"All")){

        $word="";
       }


  
    
    
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
    
    
    )




      ORDER BY id DESC";
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

            <h3><?PHP echo $role; ?> &nbsp;&nbsp;&nbsp;&nbsp;<b> Store Database </b> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y.m.d');?> </h3>

        </div>


        <div style="overflow-x:auto;">

     

            <table>
                <tr>
                    <th class='noprint'>ID</th>
                    <th class='noprint'>By</th>
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



                </tr>

                <?PHP
                // output data of each row
                $sl = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                

                    if($row['status']==0){


                        echo " <tr>

                        <td class='noprint'>" . $row['id'] . "</td>  
                        <td class='noprint'>" . $row['byuser'] . "</td>  
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
                     
                    
                        </tr> ";

                    }
                    else{

                        echo " <tr style='color:red;' class='noprint'>

                        <td class='noprint'>" . $row['id'] . "</td>  
                        <td class='noprint'>" . $row['byuser'] . "</td>  
                        <td>X</td>
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
                     
                    
                        </tr> ";
                        $sl--;
                    }
                    $sl++;
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
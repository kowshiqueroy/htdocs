<?php


include "layout.php";
?>







<div class="fullbox">



    <?php


    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM store WHERE role= '$role'  ORDER BY id DESC";
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
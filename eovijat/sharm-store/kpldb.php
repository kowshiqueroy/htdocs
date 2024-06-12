<?php


include "layout.php";
?>







<div class="fullbox ">

<div class=" text-center">

<h5><?PHP echo $role; ?> &nbsp;&nbsp;&nbsp;&nbsp;<b> KpL Database </b>
    &nbsp;&nbsp;&nbsp;&nbsp; Date:<?php echo date('Y.m.d'); ?> </h5>




</div>



<div class="col-sm-12 col-12">

        <div class=" text-center">

            <h1>Database Table</h1>

        </div>

        <?php

        // Create connection
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM kpl WHERE role= '$role' ORDER BY id DESC";
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

                        <th>Pump</th>
                        <th>Person</th>
                        <th>Slip</th>
                        <th>Remarks</th>

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
                    <td>" . round($row['value']/$row['distance'],2) . "</td>
                  
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
                    <td>" . round($row['distance']/$row['value'],2) . "</td>
                  
                    <td>" . $row['pump'] . "</td>
                    <td>" . $row['person'] . "</td>
                    <td>" . $row['slip'] . "</td>
                    <td>" . $row['remarks'] . "</td>
                    
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
<?php


include "layout2.php";

?>
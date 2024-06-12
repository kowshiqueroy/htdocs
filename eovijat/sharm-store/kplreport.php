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

        $sql = "SELECT DISTINCT item FROM kpl WHERE role= '$role' AND status!=1";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
            ?>




            <div style="overflow-x:auto;">
                <table>
                    <tr>
                        
                        <th>Vehicle</th>
                        <th>KM/L</th>
                        <th>V/KM</th>
                       

                    </tr>
                    <?PHP
                    // output data of each row
                    $n=0;
                    while ($row = mysqli_fetch_assoc($result)) {

                        echo "<tr><td>" . $row['item'] . "</td>";

                        $it=$row['item'];
                        $km=0;
                        $v=0;
                        $c=0;


                        $sql2 = "SELECT id, value,oil,distance FROM kpl WHERE role= '$role' AND status=0 AND item='$it' ORDER BY ID DESC";
                        $result2 = mysqli_query($conn, $sql2);
                    
                        if (mysqli_num_rows($result2) > 0) { 

                            while ($row2 = mysqli_fetch_assoc($result2)) {

                              
                                if ($c!=0){
                                $km+=$row2['distance']/$row2['oil'];
                                $v+=$row2['value']/$row2['distance'];
                                 } 
                             

                                $c++;





                            }  
                            
                            echo "<br>";
                        }
                        $c=$c-1;
                        $km=round($km/$c,2);
                        $v=round($v/$c,2);

                        echo "<td>" . $km . "</td>";
                        echo "<td>" . $v . "</td>";





                        
                        
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



</div>
<?php


include "layout2.php";

?>
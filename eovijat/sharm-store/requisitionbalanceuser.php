<?php


include "layout.php";
?>
<?php


?>
<div class="row">



    <div class="col-sm-12 col-12">

        <div class=" text-center">

            <h1>Requisitions Balance</h1>

        </div>

        <?php

        // Create connection
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if (isset($_REQUEST['req'])) {

            $reqid = mysqli_real_escape_string($conn, $_REQUEST['req']);
        }

    


    
        $sql = "SELECT item FROM requisitionlist WHERE role= '$role' AND status !=1 
                UNION
                SELECT item FROM store WHERE outs > 0 AND person = '$role' AND status !=1 ";

     
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            ?>




            <div style="overflow-x:auto;">
                <table>
                    <tr>
                       
                        <th>Item Name</th>
                            <th>Requisitions</th>
                                <th>Received</th>
                                    <th>Balance</th>
                      

                    </tr>
                    <?PHP
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {

                      

                            echo " <tr >
              
                    <td>" . $row['item'] . "</td>";

                    $reqqty=0;
                    $itemname=$row['item'];

                        $sql2 = "SELECT qty FROM requisitionlist WHERE role= '$role' AND status !=1 AND item= '$itemname'
               ";


                        $result2 = mysqli_query($conn, $sql2);

                        if (mysqli_num_rows($result2) > 0) {
                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                $reqqty+= $row2['qty'];

                            }


                        }

                        echo "<td>" . $reqqty. "</td>";
                        $recqty=0;
                        $sql3 = "SELECT outs FROM store WHERE person= '$role' AND outs > 0 AND status !=1 AND item= '$itemname'
               ";


                        $result3 = mysqli_query($conn, $sql3);

                        if (mysqli_num_rows($result3) > 0) {
                            while ($row3 = mysqli_fetch_assoc($result3)) {
                                $recqty+= $row3['outs'];

                            }


                        }

                        echo "<td>" . $recqty. "</td>";

                        echo "<td>" . $recqty - $reqqty. "</td>";


                    echo "
                 
                    </tr> ";
                        


                    }



        } else {
            echo "<h1 class='text-center'>No data available at this moment</h1>";
        }

        mysqli_close($conn);
        ?>


            </table>

    <input type="submit" onclick="window.location.replace('requisitionlistuser.php?all=1');"
        class="btn btn-success btn-send  mt-2 btn-block" value="View Full List">

        </div>
    </div>



</div>
<?php


include "layout2.php";

?>
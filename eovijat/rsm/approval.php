<?php


include "layout.php";
?>
<?php


if (isset($_REQUEST['del'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['del']);
    $id2 = $id / 5877;
    $sql = "UPDATE requisitionlist SET status='1', remarks='Canceled by Management' WHERE id='$id2'";

    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-info'>Deleted</div>";


    } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error</div>";


    }



}

if (isset($_REQUEST['ok']) && isset($_REQUEST['pty'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['ok']);
    $pty = mysqli_real_escape_string($conn, $_REQUEST['pty']);
    $id2 = $id / 5877;
    $sql = "UPDATE requisitionlist SET status='4', pqty='$pty' WHERE id='$id2'";

    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-info'>Deleted</div>";


    } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error</div>";


    }



}



if (isset($_REQUEST['id']) && isset($_REQUEST['purchaser']) && isset($_REQUEST['pqty']) && isset($_REQUEST['comments'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['id']);
    $purchaser = mysqli_real_escape_string($conn, $_REQUEST['purchaser']);
    $pqty = mysqli_real_escape_string($conn, $_REQUEST['pqty']);
    $comments = mysqli_real_escape_string($conn, $_REQUEST['comments']);
 
  
    $sql = "UPDATE requisitionlist SET pqty='$pqty',purchaser='$purchaser',comments='$comments',status='4' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-info'>Deleted</div>";


    } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error</div>";


    }



}











    $sql = "SELECT * FROM requisitionlist WHERE status= '3'  ORDER BY id DESC LIMIT 10";
if(isset($_REQUEST['search']) AND isset($_REQUEST['searchi']) AND isset($_REQUEST['searchp'])){


       
    $s=$_REQUEST['search'];
    $si=$_REQUEST['searchi'];
    $sp=$_REQUEST['searchp'];  

    if($s==83 && !strcmp($si,"All" ) && !strcmp($sp,"All" )){
        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2'  ORDER BY id DESC ";

    } else if ($s==83 && !strcmp($sp,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (item like '%$si%') ORDER BY id DESC ";
    }

    else if ($s==83 && !strcmp($si,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (person like '%$sp%') ORDER BY id DESC ";
    }
    else if (!strcmp($si,"All") && !strcmp($sp,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (status='$s') ORDER BY id DESC ";
    }

    else if ( !strcmp($sp,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (item like '%$si%' AND status='$s') ORDER BY id DESC ";
    }

    else if ( !strcmp($si,"All" )  ) {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (person like '%$sp%' AND status='$s') ORDER BY id DESC ";
    }
    else if ($s==83 )   {

        $sql = "SELECT * FROM requisitionlist WHERE status!= '1' AND status!= '0' AND status!= '2' AND (item like '%$si%' AND person like '%$sp%') ORDER BY id DESC ";
    }
 

  


   


}
?>

<div class="row">



    <div class="col-sm-12 col-12">

        <div class=" text-center">

            <h1>All Purchase Orders' Approval</h1>

        </div>

        <div class="noprint">

        <div class="col-lg-12 d-flex justify-content-center ">

            <form id="contact-form" role="form" action="<?PHP echo $_SERVER["PHP_SELF"]; ?>" method="post">


                <div class="controls">

                    <div class="row">

                        <input onclick="window.location.replace(window.location.href);"
                            style="height:40px; margin:20px;" class="btn btn-success btn-send col-sm-2 col-auto"
                            value="Refresh">


                     
                        <div class="col-sm-2 col-12 ">
                            <div class="form-group">
                                <label for="searchi">Item</label>
                                <input type="text" name="searchi" class=' form-control' id="searchi" value="<?php if (isset($_REQUEST['searchi'])) {
                                    echo $_REQUEST['searchi'];
                                } else {
                                    echo "All";
                                } ?>" required>
                            </div>
                        </div>

                        <div class="col-sm-2 col-12 ">
                            <div class="form-group">
                                <label for="searchp">Person</label>
                                <input type="text" name="searchp" class=' form-control' id="searchp" value="<?php if (isset($_REQUEST['searchp'])) {
                                    echo $_REQUEST['searchp'];
                                } else {
                                    echo "All";
                                } ?>" required>
                            </div>
                        </div> 
                        <div class="col-sm-2 col-12 ">
                            <div class="form-group">
                                <label for="search">Status</label>
                                <select type="text" name="search" class=' form-control' id="search" required>
                                <option value='83'>All</option>
                             
                                <option value='3'>Need Approval</option>
                                <option value='4'>Purchasing</option>
                                <option value='5'>Purchased</option>
                                  <?php  if (isset($_REQUEST['search']))
                                  {

                                    if($_REQUEST['search']==83){

                                        echo "  <option selected value='83'>All</option>";
                                        
                                        
                                    }
                               

                                    else if($_REQUEST['search']==3){

                                        echo "  <option selected value='3'>Need Approval</option>";
                                        
                                        
                                    }

                                    else if($_REQUEST['search']==4){

                                        echo "  <option selected value='4'>Purchasing</option>";
                                        
                                        
                                    }


                                    else if($_REQUEST['search']==5){

                                        echo "  <option selected value='5'>Purchased</option>";
                                        
                                        
                                    }


                                  }


                                    ?>
                                
                                
                                
                               

                            </select>
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

        // Create connection
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        

      


       
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            ?>




            <div style="overflow-x:auto;">
                <table>
                    <tr>
                   
                        <th>Status</th>
                        <th>Action</th>
                        <th>ID</th>
                        <th>Item Name</th>

                        <th>QTY</th>
                        <th>Stock</th>
                        <th>Purchaser</th>
                        <th>PO QTY</th>
                        <th>P QTY</th>
                        <th>Comments</th>

                        <th>Value</th>
                        <th>Person</th>
                        <th>Need Date</th>

                        <th>Reason</th>
                        <th>Remarks</th>
                        <th>Submission</th>
                        <th>By</th>



                  

                    </tr>
                    <?PHP
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {

                          if ($row['status'] == 3) {
                            echo " <tr style='color:blue;'>
                            <td >Need Approval</td>                     
                             <td class='noprint'>";echo "<p style='width:140px;'><a style='margin-right:10px;' href='approvalaction.php?id=" . intval($row['id']) . "'>View </a>
                            <a  style='margin-right:10px;' href='approval.php?ok=" . intval($row['id'])*5877 ."&pty=". $row['poqty']. "'>OK </a>
                            <a  href='approval.php?del=" . (intval($row['id'])*5877). "'>Cancel </a></td></p>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['item'] . "</td>
                            <td>" . $row['qty'] . "</td>
                            <td>" . $row['stock'] . "</td>
                            <td>" . $row['purchaser'] . "</td>
                            <td>" . $row['poqty'] . "</td>
                            <td>" . $row['pqty'] . "</td>
                            <td>" . $row['comments'] . "</td>
                            <td>" . $row['value'] . "</td>
                            <td>" . $row['person'] . "</td>
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['reason'] . "</td>
                            <td>" . $row['remarks'] . "</td>
                            <td>" . $row['subd'] . "</td>
                            <td>" . $row['byuser'] . "</td>
                  ";







                            






                            echo "

                    </tr> ";

                        } else if ($row['status'] == 4) {
                            echo " <tr style='color:red;'>
                            <td >Purchasing</td>
                            <td ></td>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['item'] . "</td>
                            <td>" . $row['qty'] . "</td>
                            <td>" . $row['stock'] . "</td>
                            <td>" . $row['purchaser'] . "</td>
                            <td>" . $row['poqty'] . "</td>
                            <td>" . $row['pqty'] . "</td>
                            <td>" . $row['comments'] . "</td>
                            <td>" . $row['value'] . "</td>
                            <td>" . $row['person'] . "</td>
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['reason'] . "</td>
                            <td>" . $row['remarks'] . "</td>
                            <td>" . $row['subd'] . "</td>
                            <td>" . $row['byuser'] . "</td>
                  ";







                            echo "                           
                     <td class='noprint'>";



                            echo "";






                            echo "</td>

                    </tr> ";

                        } else if ($row['status'] == 5) {
                            echo " <tr style='color:orange;'>
                            <td >Purchased</td>
                            <td ></td>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['item'] . "</td>
                            <td>" . $row['qty'] . "</td>
                            <td>" . $row['stock'] . "</td>
                            <td>" . $row['purchaser'] . "</td>
                            <td>" . $row['poqty'] . "</td>
                            <td>" . $row['pqty'] . "</td>
                            <td>" . $row['comments'] . "</td>
                            <td>" . $row['value'] . "</td>
                            <td>" . $row['person'] . "</td>
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['reason'] . "</td>
                            <td>" . $row['remarks'] . "</td>
                            <td>" . $row['subd'] . "</td>
                            <td>" . $row['byuser'] . "</td>
                  ";







                            echo "                           
                     <td class='noprint'>";



                            echo "";






                            echo "</td>

                    </tr> ";

                        }

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
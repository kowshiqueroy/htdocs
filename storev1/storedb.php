<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: index.php");
    die();
}
$role = $_SESSION['SESSION_ROLE'];
include '../config.php';

$query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);

    if ($_SESSION['SESSION_ROLE'] != "store") {

        header("Location: ../" . $_SESSION['SESSION_ROLE'] . "/index.php");

    }
}

include "layout.php";
?>







<div class="fullbox">



    <?php


    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM store WHERE role= '$role' ORDER BY id DESC";
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
                    <th class='noprint'>Date</th>
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
                    echo " <tr>

                <td class='noprint'>" . $row['id'] . "</td>  
                <td class='noprint'>" . $row['byuser'] . "</td>  
                <td>" . $sl . "</td>
                <td class='noprint'>" . $row['date'] . "</td>
                <td>" . $row['item'] . "</td>
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
                    $sl++;
                }
    } else {
        echo "0 results";
    }

    mysqli_close($conn);
    ?>
        </table>

    </div>

</div>
<?php


include "layout2.php";

?>
<?php

include "layout.php";

if (isset($_REQUEST['del'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['del']);
    $id2 = $id / 5877;
    $sql = "UPDATE requisitioninfo SET status='1' WHERE id='$id2' AND byuser='$user'";

    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-info'>Deleted</div>";


    } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error</div>";


    }



}

if (isset($_REQUEST['undo'])) {

    $id = mysqli_real_escape_string($conn, $_REQUEST['undo']);
    $id2 = $id / 5877;
    $sql = "UPDATE requisitioninfo SET status='0' WHERE id='$id2' AND byuser='$user'";

    if ($conn->query($sql) === TRUE) {
        $msg = "<div class='alert alert-info'>Undo Deleted</div>";


    } else {
        echo "Error: " . $conn->error;
        $msg = "<div class='alert alert-info'>Error</div>";


    }



}


?>

<div class='row'>


<div class="col-sm-8">
    <div class='container'>
        <h1 class='text-center text-primary'>Create New Requisition</h1>
        <hr>
        <?php
        if (isset($_POST["submit"])) {
            $date = date("Y-m-d", strtotime($_POST["invoice_date"]));
            $person = mysqli_real_escape_string($conn, $_POST["cname"]);
           

            $grand_total = mysqli_real_escape_string($conn, $_POST["grand_total"]);
            $remarks ="";
            if(isset($_POST["submit"])){
                $remarks = mysqli_real_escape_string($conn, $_POST["remarks"]);

            }
         

            $sql = "insert into requisitioninfo (date,person,total,byuser,role,status,remarks) values 
            ('{$date}','{$person}','{$grand_total}','{$user}','{$role}','0','{$remarks}') ";
            if ($conn->query($sql)) {
                $sid = $conn->insert_id;

                $sql2 = "insert into requisition (rid,item,price,qty,total,purchaser) values ";
                $rows = [];
                for ($i = 0; $i < count($_POST["pname"]); $i++) {
                    $pname = mysqli_real_escape_string($conn, $_POST["pname"][$i]);
                    $price = mysqli_real_escape_string($conn, $_POST["price"][$i]);
                    $qty = mysqli_real_escape_string($conn, $_POST["qty"][$i]);
                    $total = mysqli_real_escape_string($conn, $_POST["total"][$i]);
                    $purchaser = mysqli_real_escape_string($conn, $_POST["purchaser"]);
                    $rows[] = "('{$sid}','{$pname}','{$price}','{$qty}','{$total}','{$purchaser}')";
                }
                $sql2 .= implode(",", $rows);
                if ($conn->query($sql2)) {
                    echo "<div class='alert alert-success'> Added. <a href='print.php?id={$sid}' target='_BLANK'>Click</a> here to Print Memo</div>";
                } else {
                    echo "<div class='alert alert-danger'>Add Failed.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Add Failed.</div>";
            }
        }

        ?>
        <form method='post' action='' autocomplete='off'>
            <div class='row'>



                <div class='col-sm-6'>

                    <div class='form-group'>


                        <label for="person">Person/Dept/Company/Shop</label>
                        <select id="select_boxp person" name="cname" class="form-control select2p" required="required"
                            data-error="Person/Dept/Company/Shop">
                            <option value="" selected disabled>Person/Dept/Company/Shop
                            </option>

                            <?php
                            include 'personselectbox.php';
                            ?>

                        </select>

                    </div>



                </div>

                <div class='col-sm-2'>

                    <div class='form-group'>
                        <label>Date</label>
                        <input type='text' name='invoice_date' id='date' class='date form-control'
                            value="<?php echo date('Y-m-d'); ?>" required class='form-control'>
                    </div>
                </div>
                
                <div class='col-sm-4'>

                    <div class='form-group'>
                        <label>Purchaser</label>
                        <select  id="purchaser" name="purchaser"
                            class="form-control" required="required" data-error="item">
                            <option selected >-
                            </option>
                            <option  >Shakil
                            </option>
                            <option  >Saju
                            </option>
                            </select>
                 
                    </div>
                </div>

                <h5 class='text-success col-sm-12'>Add Item Details</h5>

                <div class='col-sm-6'>

                    <div class='form-group'>


                        <label for="items">Item/Product</label>
                        <select onchange="updateInput(this.value)" id="select_boxi items" name=""
                            class="form-control select2i" required="required" data-error="item">
                            <option value="" selected disabled>Select
                            </option>

                            <?php
                            include 'itemselectbox.php';
                            ?>

                        </select>
                    </div>








                </div>

                <div class='col-sm-2'>

                    <div class='form-group'>


                        <label for="prices">Price</label>
                        <input onchange="updateInputp(this.value)" type='number' name='' id='prices' value="0" required
                            class='form-control'>

                    </div>








                </div>
                <div class='col-sm-2'>

                    <div class='form-group'>


                        <label for="qtys">Quantity</label>
                        <input onchange="updateInputq(this.value)" type='number' name='' id='qtys' value="0" required
                            class='form-control'>

                    </div>








                </div>


                <div class='col-sm-2' style="margin-top:30px; width:20px;">
                    <input type='button' value='+ Add Row' class='btn btn-primary btn-sm' id='btn-add-row'>

                </div>




            </div>







            <div class='row'>
                <div class='col-sm-12'>
                    <h5 class='text-success'>Product Details</h5>




                    <div style="overflow-x:auto;">
                        <table style=' min-width:700px  ' id='inv'>
                            <thead>
                                <tr>
                                    <th style='width:38%;'>Product</th>
                                    <th style='width:20%;'>Price</th>
                                    <th style='width:20%;'>Qty</th>
                                    <th style='width:20%;'>Total</th>
                                    <th style='width:2%;'>Action</th>
                                </tr>
                            </thead>
                            <tbody id='product_tbody'>




                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan='2' class='text-right'>Remarks: <input type='text' name='remarks' id='remarks'
                                            class='form-control' ></td>
                                    <td class='text-right'>=<input type='text' readonly name='grand_total' id='grand_total'
                                            class='form-control' required></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <input type='submit' name='submit' value='Save'
                        class='btn btn-success btn-send pt-3 mt-3  btn-block '>
                </div>
            </div>
        </form>
    </div>
</div>




<div class="col-sm-4">


<div class=" text-center">

<h1>Submission Table</h1>

</div>

<?php

// Create connection
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT id,subd,person,total,status FROM requisitioninfo  ORDER BY id DESC LIMIT 8";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
?>




<div style="overflow-x:auto;">
    <table>
        <tr>
            <th></th>
            <th>Person</th>
            <th>Sub</th>
            <th>Total</th>
            

        </tr>
        <?PHP
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {

            if ($row['status'] == 1) {

                echo " <tr style='color:red;'>
                <td><a href='" . $_SERVER["PHP_SELF"] . "?undo=" . intval($row['id']) * 5877 . "'>+</a>
               </td>
        <td>" . $row['person'] . "</td>
        <td>" . $row['subd'] . "</td>
        <td>" . $row['total'] . "</td>
    
        </tr> ";
            } else {
                echo " <tr>
                <td><a href='" . $_SERVER["PHP_SELF"] . "?del=" . intval($row['id']) * 5877 . "'>X</a>
                <a href='requisitionedit.php?edit=" . intval($row['id']) * 5877 . "'>/</a></td>
                <td>" . $row['person'] . "</td>
                <td>" . $row['subd'] . "</td>
                <td>" . $row['total'] . "</td>
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



<div id="itemg">
</div>
<div id="priceg">
</div>
<div id="qtyg">
</div>

<script>
    function updateInput(ish) {
        document.getElementById("itemg").value = ish;
    }
    function updateInputp(ish) {
        document.getElementById("priceg").value = ish;
    }
    function updateInputq(ish) {
        document.getElementById("qtyg").value = ish;
    }

    $(document).ready(function () {


        $("#btn-add-row").click(function () {

            var p = "";
            var e = document.getElementById("itemg");
            var p = e.value;



            var pr = 0;
            var ep = document.getElementById("priceg");
            var pr = ep.value;



            var pq = 0;
            var eq = document.getElementById("qtyg");
            var pq = eq.value;






            var row = "<tr> <td ><input type='text' required name='pname[]' readonly class='form-control pn ' value='" + p + "'></td> <td><input type='number' readonly required name='price[]' class='form-control price' value='" + pr + "'></td> <td><input type='number' required name='qty[]' class='form-control qty' value='" + pq + "'></td> <td><input type='number' required name='total[]' readonly class='form-control total'></td> <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td> </tr>";

            $("#product_tbody").append(row);
        });

        $("body").on("click", ".btn-row-remove", function () {
            if (confirm("Are You Sure?")) {
                $(this).closest("tr").remove();
                grand_total();
            }
        });




        $("body").on("click", ".pn", function () {
            var price = Number($(this).closest("tr").find(".price").val());
            var qty = Number($(this).closest("tr").find(".qty").val());
            $(this).closest("tr").find(".total").val(price * qty);
            grand_total();
        });
        $("body").on("click", ".price", function () {
            var price = Number($(this).closest("tr").find(".price").val());
            var qty = Number($(this).closest("tr").find(".qty").val());
            $(this).closest("tr").find(".total").val(price * qty);
            grand_total();
        });
        $("body").on("click", ".qty", function () {
            var price = Number($(this).closest("tr").find(".price").val());
            var qty = Number($(this).closest("tr").find(".qty").val());
            $(this).closest("tr").find(".total").val(price * qty);
            grand_total();
        });
        $("body").on("click", ".total", function () {
            var price = Number($(this).closest("tr").find(".price").val());
            var qty = Number($(this).closest("tr").find(".qty").val());
            $(this).closest("tr").find(".total").val(price * qty);
            grand_total();
        });


        $("body").on("keyup", ".total", function () {
            var price = Number($(this).val());
            var qty = Number($(this).closest("tr").find(".qty").val());
            $(this).closest("tr").find(".total").val(price * qty);
            grand_total();
        });

        $("body").on("change", ".price", function () {
            var price = Number($(this).val());
            var qty = Number($(this).closest("tr").find(".qty").val());
            $(this).closest("tr").find(".total").val(price * qty);
            grand_total();
        });

        $("body").on("keyup", ".qty", function () {
            var qty = Number($(this).val());
            var price = Number($(this).closest("tr").find(".price").val());
            $(this).closest("tr").find(".total").val(price * qty);
            grand_total();
        });

        $("body").on("change", ".qty", function () {
            var qty = Number($(this).val());
            var price = Number($(this).closest("tr").find(".price").val());
            $(this).closest("tr").find(".total").val(price * qty);
            grand_total();
        });
        $("body").on("load", ".qty", function () {
            var qty = Number($(this).val());
            var price = Number($(this).closest("tr").find(".price").val());
            $(this).closest("tr").find(".total").val(price * qty);
            grand_total();
        });

        function grand_total() {
            var tot = 0;
            $(".total").each(function () {
                tot += Number($(this).val());
            });
            $("#grand_total").val(tot);
        }
    });
</script>
<?php


include "layout2.php";

?>
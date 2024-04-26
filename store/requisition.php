<?php

include "layout.php";
?>

<div class='row'>


<div class="col-sm-10">
    <div class='container'>
        <h1 class='text-center text-primary'>Create New Requisition</h1>
        <hr>
        <?php
        if (isset($_POST["submit"])) {
            $date = date("Y-m-d", strtotime($_POST["invoice_date"]));
            $person = mysqli_real_escape_string($conn, $_POST["cname"]);

            $grand_total = mysqli_real_escape_string($conn, $_POST["grand_total"]);

            $sql = "insert into requisitioninfo (date,person,total,byuser,role,status) values 
            ('{$date}','{$person}','{$grand_total}','{$user}','{$role}','0') ";
            if ($conn->query($sql)) {
                $sid = $conn->insert_id;

                $sql2 = "insert into requisition (rid,item,price,qty,total) values ";
                $rows = [];
                for ($i = 0; $i < count($_POST["pname"]); $i++) {
                    $pname = mysqli_real_escape_string($conn, $_POST["pname"][$i]);
                    $price = mysqli_real_escape_string($conn, $_POST["price"][$i]);
                    $qty = mysqli_real_escape_string($conn, $_POST["qty"][$i]);
                    $total = mysqli_real_escape_string($conn, $_POST["total"][$i]);
                    $rows[] = "('{$sid}','{$pname}','{$price}','{$qty}','{$total}')";
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

                <div class='col-sm-4'>

                    <div class='form-group'>
                        <label>Date</label>
                        <input type='text' name='invoice_date' id='date' class='date form-control'
                            value="<?php echo date('Y-m-d'); ?>" required class='form-control'>
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
                                    <td colspan='2' class='text-right'>Total</td>
                                    <td><input type='text' readonly name='grand_total' id='grand_total'
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




<div class="col-sm-2">
table
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
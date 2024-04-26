<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: ../index.php");
    die();
}

include '../config.php';
$role = $_SESSION['SESSION_ROLE'];
$user = $_SESSION['SESSION_EMAIL'];
$email = $_SESSION['SESSION_EMAIL'];
$query = mysqli_query($conn, "SELECT id FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}' AND status='0'");

if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);

    if (!str_contains($_SERVER['REQUEST_URI'],$role)) {

        header("Location: ../" . $_SESSION['SESSION_ROLE'] . "/index.php");

    }
}
else {
    header("Location: ../logout.php");


}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>EOvijat</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dynamically Add New Option in Select2 using Ajax in PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        @media print {
            .noprint {
                visibility: hidden;
                display: none;
            }


            @page {
                size: A4;
                margin: 1cm;

            }

            body {
                font-size: 16px;
            }

            table td {
                border: solid 1px #666;
                width: auto;
                height: auto;
                word-wrap: break-word;

            }

            .itemnametb {}

        }

        /* Style the body */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }

        /* Header/logo Title */
        .header {
            padding: 01px;
            text-align: center;
            background: green;
            color: white;
        }

        /* Increase the font size of the heading */
        .header h1 {
            font-size: 40px;
        }

        /* Sticky navbar - toggles between relative and fixed, depending on the scroll position. It is positioned relative until a given offset position is met in the viewport - then it "sticks" in place (like position:fixed). The sticky value is not supported in IE or Edge 15 and earlier versions. However, for these versions the navbar will inherit default position */
        .navbar {
            overflow: hidden;
            background-color: #333;

            top: 0;


        }

        /* Style the navigation bar links */

        .navbar span {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 1px;
            text-decoration: none;
        }

        .navbar p {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 1px;
            text-decoration: none;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }



        /* Right-aligned link */
        .navbar a.right {
            float: right;
        }

        .navbar p.right {
            float: right;
        }

        /* Change color on hover */
        .navbar a b:hover {

            color: red;
        }

        /* Active/current link */
        .navbar a.active {
            background-color: #666;
            color: white;
        }

        /* Column container */
        .row {
            display: -ms-flexbox;
            /* IE10 */
            display: flex;
            -ms-flex-wrap: wrap;
            /* IE10 */
            flex-wrap: wrap;
        }

        /* Create two unequal columns that sits next to each other */
        /* Sidebar/left column 
        .leftbox {
            -ms-flex: 50%;
          
            flex: 50%;
            background-color: #f1f1f1;
            padding-left: 5px;
            padding-right: 5px;
        }

   
        .rightbox {
            -ms-flex: 50%;

            flex: 50%;
            background-color: white;

            padding-left: 5px;
            padding-right: 5px;
        }

        .fullbox {

            background-color: white;
            padding-left: 5px;
            padding-right: 5px;
        }

        */
        /* Fake image, just for this example */


        /* Footer */
        .footer {
            padding: 01px;
            text-align: center;
            background: green;
            color: white;
        }

        .footer p {
            margin: 10px;
        }

        .navbar {


            font-size: 20px;
        }

        /* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 700px) {
            .row {
                flex-direction: column;
            }
        }

        /* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
        @media screen and (max-width: 400px) {
            .navbar a {
                float: none;
                width: 50%;

            }

            .navbar {


                font-size: 10px;
            }
        }
    </style>
    <style>
        body {
            font-family: "Lato", sans-serif;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        #box {
            transition: margin-left .5s;
            padding: 16px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        }
    </style>

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

        td {
            border: solid thin;


        }

        th {
            border: solid thin;


        }
    </style>

</head>

<body>

    <div id="mySidenav" class="sidenav noprint">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <a href="index.php">Home</a>
        <br>
        <a href="storeitems.php">Store App</a>
        <a href="in.php">In Report</a>
        <a href="out.php">Out Report</a>
        <a href="stock.php">Stock Report</a>
        <a href="storedb.php">Database</a>
        <br>
        <a href="requisition">Requisition App</a>
     
        <br>


    </div>

    <div id="box">
        <div class="header noprint   col-lg-12">
            <h1>E-Ovijat</h1>
            <p>A <b>Store Inventory</b> management web app</p>
        </div>

        <div class="navbar noprint">


            <span class="active menu" style="cursor:pointer" onclick="openNav()"> &#9776; Menu</span>







            <a href="../logout.php" class="right"><?php
            echo $_SESSION['SESSION_EMAIL'] . " - " . $_SESSION['SESSION_ROLE']
                ?> <b>Logout</b></a>

        </div>
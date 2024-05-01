<?php
date_default_timezone_set('Asia/Dhaka');


$u = "root";
$p = "";
//$u="root";
//$p="";
$db = "erp";

$conn = mysqli_connect("localhost", "$u", "$p", "$db");
$connect = new PDO("mysql:host=localhost; dbname=$db", "$u", "$p");

if (!$conn) {
    echo "Connection Failed";
}

?>
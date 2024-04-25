<?php
    session_start();
    if (!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: index.php");
        die();
    }

    include '../config.php';

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);

        if($_SESSION['SESSION_ROLE']!="admin"){

            header("Location: ../".$_SESSION['SESSION_ROLE']."/index.php");

        }
    }

    include "layout.php";
?>



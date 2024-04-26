<?php

//add.php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
	header("Location: index.php");
	die();
}
include ('../config.php');

if (isset($_POST["select_box_name"])) {
	$select_box_name = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $_POST["select_box_name"]);

	$role = $_SESSION['SESSION_ROLE'];
	$data = array(
		':select_box_name' => $select_box_name,
		':role' => $role
	);

	$query = "
	SELECT * FROM select_boxp 
	WHERE select_box_name = :select_box_name  AND role = :role
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	if ($statement->rowCount() == 0) {
		$query = "
		INSERT INTO select_boxp 
		(select_box_name,role) 
		VALUES (:select_box_name,:role)
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		echo 'yes';
	}
}

?>
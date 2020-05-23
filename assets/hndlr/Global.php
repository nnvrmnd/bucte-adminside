<?php

if (isset($_POST['who'])) {
	require 'db.hndlr.php';

	$whoami = $_POST['who'];

	$stmnt = 'SELECT * FROM user WHERE BINARY username = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$whoami];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$username = $data['username'];
			$given = $data['given_name'];
			$surname = $data['surname'];
			$gender = $data['gender'];

			$dbData = ['username' => $username, 'given' => $given, 'surname' => $surname, 'gender' => $gender];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	} else {
		echo 'INTRUDER!';
	}
}

/* Fetch id of username */
if (isset($_POST['username'])) {
	require 'db.hndlr.php';

	$username = $_POST['username'];

	$stmnt = 'SELECT * FROM user WHERE username = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$username];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			echo $data['u_id'];
		}
	} else {
		echo 'null';
	}
}

/* Fetch name of id */
if (isset($_POST['userid'])) {
	require 'db.hndlr.php';

	$id = $_POST['userid'];

	$stmnt = 'SELECT * FROM user WHERE u_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$id];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			echo $data['given_name'] . '&nbsp;' . $data['surname'];
		}
	} else {
		echo 'null';
	}
}

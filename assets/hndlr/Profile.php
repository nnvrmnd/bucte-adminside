<?php

if (isset($_POST['fetchaccount'])) {
	require './db.hndlr.php';
	$id = $_POST['fetchaccount'];

	$stmnt = 'SELECT * FROM user WHERE BINARY (username = ? OR email = ?) ;';
	$query = $db->prepare($stmnt);
	$param = [$id, $id];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count <= 0) {
		exit('err:fetch');
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $row) {
			$id = $row['u_id'];
			$given = $row['given_name'];
			$surname = $row['surname'];
			$username = $row['username'];
			$email = $row['email'];
			$gender = $row['gender'];
			$position = $row['position'];
			$dbData[] = ['id' => $id, 'given' => $given, 'surname' => $surname, 'username' => $username, 'email' => $email, 'position' => $position, 'gender' => $gender];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* Update account */
if (isset($_POST['username']) && isset($_POST['email'])) {
	require './db.hndlr.php';

	$id = $_POST['account'];
	$given = $_POST['given'];
	$surname = $_POST['surname'];
	$username = $_POST['username'];
	$email = $_POST['email'];

	$db->beginTransaction();
	$stmnt = 'UPDATE user SET given_name = ?, surname = ?, username = ?, email = ? WHERE u_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$given, $surname, $username, $email, $id];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		$db->commit();
		exit('true');
	} else {
		$db->rollBack();
		exit('err:update');
	}
}

/* Check current password */
if (isset($_POST['id']) && isset($_POST['current'])) {
	require './db.hndlr.php';

	$id = $_POST['id'];
	$current = $_POST['current'];

	$stmnt = 'SELECT * FROM user WHERE BINARY (username = ? OR email = ?) ;';
	$query = $db->prepare($stmnt);
	$param = [$id, $id];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			$hash = $data['passkey'];
			if (password_verify($current, $hash)) {
				echo 'true';
			} else {
				echo 'false';
			}
		}
	} else {
		echo 'err:current';
	}
}

/* Change password */
if (isset($_POST['account']) && isset($_POST['new'])) {
	require './db.hndlr.php';

	$id = $_POST['account'];
	$new = password_hash($_POST['new'], PASSWORD_DEFAULT);

	$db->beginTransaction();
	$stmnt = 'UPDATE user SET passkey = ? WHERE (username = ? OR email = ?) ;';
	$query = $db->prepare($stmnt);
	$param = [$new, $id, $id];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		$db->commit();
		echo 'true';
	} else {
		$db->rollBack();
		echo 'false';
	}
}

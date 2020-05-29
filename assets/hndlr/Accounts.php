<?php

/* Fetch for render */
if (isset($_POST['fetchaccounts'])) {
	require './db.hndlr.php';

	$stmnt = 'SELECT * FROM user WHERE position = "Admin" ORDER BY given_name ASC ;';
	$query = $db->prepare($stmnt);
	$query->execute();
	$count = $query->rowCount();
	if ($count <= 0) {
		exit('err:fetch');
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$account_id = $data['u_id'];
			$given = $data['given_name'];
			$surname = $data['surname'];
			$username = $data['username'];
			$email = $data['email'];
			$type = $data['position'];
			$status = $data['account_status'];
			$gender = $data['gender'];

			$dbData[] = ['account_id' => $account_id, 'given' => $given, 'surname' => $surname, 'username' => $username, 'email' => $email, 'type' => $type, 'status' => $status, 'gender' => $gender];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* Fetch 1 account */
if (isset($_POST['fetchaccount'])) {
	require './db.hndlr.php';

	$id = $_POST['fetchaccount'];

	$stmnt = 'SELECT * FROM user WHERE u_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$id];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count <= 0) {
		exit('err:fetch');
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$account_id = $data['u_id'];
			$given = $data['given_name'];
			$surname = $data['surname'];
			$username = $data['username'];
			$email = $data['email'];
			$type = $data['position'];
			$status = $data['account_status'];
			$gender = $data['gender'];

			$dbData[] = ['account_id' => $account_id, 'given' => $given, 'surname' => $surname, 'username' => $username, 'email' => $email, 'type' => $type, 'status' => $status, 'gender' => $gender];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* Check username availability */
if (isset($_POST['id']) && isset($_POST['username'])) {
	require './db.hndlr.php';

	$id = $_POST['id'];
	$username = $_POST['username'];

	if ($id !== '0') {
		$stmnt = 'SELECT * FROM user WHERE BINARY username = ? AND u_id != ? ;';
		$param = [$username, $id];
	} else {
		$stmnt = 'SELECT * FROM user WHERE BINARY username = ? ;';
		$param = [$username];
	}

	$query = $db->prepare($stmnt);
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		exit('false');
	} else {
		exit('true');
	}
}

/* Check email availability */
if (isset($_POST['id']) && isset($_POST['email'])) {
	require './db.hndlr.php';

	$id = $_POST['id'];
	$email = $_POST['email'];

	if ($id !== '0') {
		$stmnt = 'SELECT * FROM user WHERE BINARY email = ? AND u_id != ? ;';
		$param = [$email, $id];
	} else {
		$stmnt = 'SELECT * FROM user WHERE BINARY email = ? ;';
		$param = [$email];
	}

	$query = $db->prepare($stmnt);
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		exit('false');
	} else {
		exit('true');
	}
}

/* Create account */
if (isset($_POST['username']) && isset($_POST['email'])) {
	require './db.hndlr.php';

	function sequence() {
		require './db.hndlr.php';
		$stmnt = 'SELECT seq FROM user ORDER BY seq DESC LIMIT 1 ;';
		$query = $db->prepare($stmnt);
		$query->execute();
		$count = $query->rowCount();
		if ($count > 0) {
			foreach ($query as $data) {
				$seq = $data['seq'];
				$seqlen = strlen($seq);
				$newseq = $seq + 1;
				return 'CTE' . str_pad($newseq, $seqlen, '0', STR_PAD_LEFT);
			}
		}
	}

	$given = $_POST['given'];
	$surname = $_POST['surname'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$gender = $_POST['gender2'];
	$status = $_POST['status2'];
	$position = 'Admin';
	$default = password_hash('cte@bu', PASSWORD_DEFAULT);
	$sequence = sequence();

	$db->beginTransaction();
	$stmnt = 'INSERT INTO user (given_name, surname, username, email, gender, account_status, position, passkey, u_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ;';
	$query = $db->prepare($stmnt);
	$param = [$given, $surname, $username, $email, $gender, $status, $position, $default, $sequence];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		$db->commit();
		exit('true');
	} else {
		$db->rollBack();
		exit('err:create');
	}
}

/* Update account */
if (isset($_POST['edt_username']) && isset($_POST['edt_email'])) {
	require './db.hndlr.php';

	$id = $_POST['account'];
	$given = $_POST['edt_given'];
	$surname = $_POST['edt_surname'];
	$username = $_POST['edt_username'];
	$email = $_POST['edt_email'];
	$status = $_POST['edt_status2'];

	$db->beginTransaction();
	$stmnt = 'UPDATE user SET given_name = ?, surname = ?, username = ?, email = ?, account_status = ? WHERE u_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$given, $surname, $username, $email, $status, $id];
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

if (isset($_POST['action']) && isset($_POST['id'])) {
	require './db.hndlr.php';

	$username = $_POST['id'];
	$default = password_hash('cte@bu', PASSWORD_DEFAULT);

	$db->beginTransaction();
	$stmnt = 'UPDATE user SET passkey = ? WHERE username = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$default, $username];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
			$db->commit();
			exit('true');
		} else {
			$db->rollBack();
			exit('false');
	}
}
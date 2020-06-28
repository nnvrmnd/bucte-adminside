<?php

if (isset($_POST['contact'])) {
	require './db.hndlr.php';

	$stmnt = 'SELECT * FROM content WHERE alias = "contact" ;';
	$query = $db->prepare($stmnt);
	$query->execute();
	$count = $query->rowCount();
	if ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$dbData[] = ['phone' => $data['meta1'], 'address' => $data['meta2'], 'email' => $data['meta3'], 'open' => $data['meta4'], 'close' => $data['meta5'], 'embed' => $data['content']];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

if (isset($_POST['phone']) && isset($_POST['email'])) {
	require './db.hndlr.php';

	$author = $_POST['author'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$email = $_POST['email'];
	$open = $_POST['opening'];
	$close = $_POST['closing'];
	$embed = $_POST['embed'];

	$db->beginTransaction();
	$stmnt = 'UPDATE content SET u_id = ?, meta1 = ?, meta2 = ?, meta3 = ?, meta4 = ?, meta5 = ?, content = ? WHERE alias = "contact" ;';
	$query = $db->prepare($stmnt);
	$param = [$author, $phone, $address, $email, $open, $close, $embed];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		$db->commit();
		exit('true');
	} else {
		$db->rollBack();
		exit('err:save');
	}
}

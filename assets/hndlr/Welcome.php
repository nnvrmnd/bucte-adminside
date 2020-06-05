<?php

if (isset($_POST['carousel'])) {
	require './db.hndlr.php';
	$stmnt = 'SELECT * FROM events';
	$query = $db->prepare($stmnt);
	$query->execute();
	$count = $query->rowCount();
	if ($count <= 0) {
		exit('err:fetch');
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$title = $data['title'];
			$image = $data['image'];

			$dbData[] = ['title' => $title, 'image' => $image];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

if (isset($_POST['vmgo'])) {
	require './db.hndlr.php';

	$vmgo = $_POST['vmgo'];

	$stmnt = 'SELECT * FROM content WHERE alias = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$vmgo];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count <= 0) {
		exit('err:fetch');
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$content = $data['content'];

			$dbData[] = ['content' => $content];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

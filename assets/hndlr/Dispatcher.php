<?php

require './db.hndlr.php';

$stmnt = 'SELECT * FROM dispatcher ;';
$query = $db->prepare($stmnt);
$query->execute();
$count = $query->rowCount();
if ($count > 0) {
	foreach ($query as $data) {
		$dispatcher = $data['e'];
		$key = $data['p'];
	}
}

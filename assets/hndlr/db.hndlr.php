<?php
date_default_timezone_set('Asia/Manila');

try {
	$db = new PDO('mysql: host=localhost; dbname=bucte_db; charset=utf8', 'root', '');
	$db->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// var_dump($db);
} catch(PDOException $e) {
	// header('Location: 500.php');
	exit('Cannot establish database connection...');
	// echo '<p class="text-danger">&nbsp;Cannot establish database connection...</p>';
}

/*echo $_SERVER['SERVER_NAME'];
echo '<br>';
echo $_SERVER['REQUEST_URI'];*/
?>
<?php
date_default_timezone_set('Asia/Manila');

try {
	// $db = new PDO('mysql:host=sql206.epizy.com;dbname=epiz_25829211_bucte_db;charset=utf8', 'epiz_25829211', '4wHZrCvzg4mXI1f');
	$db = new PDO('mysql:host=localhost;dbname=bucte_db;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	// exit('Cannot establish database connection...');
	exit('Cannot establish database connection...' . PHP_EOL . $e->getMessage());
}
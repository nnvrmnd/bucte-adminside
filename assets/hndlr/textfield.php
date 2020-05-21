<?php
require 'db.hndlr.php';
$stmnt = 'SELECT * FROM content WHERE alias = ? ORDER BY updated_at DESC LIMIT 1';
$query = $db->prepare($stmnt);
$param = ['homepage'];
$query->execute($param);
$count = $query->rowCount();
$data = $query ->fetch(PDO::FETCH_ASSOC);
echo json_encode($data);             

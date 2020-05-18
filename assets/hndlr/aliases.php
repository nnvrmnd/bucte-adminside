<?php
require 'db.hndlr.php';
$aliases = ['vision', 'mission', 'objectives'];

$stmntGetContent = "SELECT alias, content  FROM content";
$queryContent = $db->prepare($stmntGetContent);
$queryContent->execute();
$contentData = $queryContent ->fetchall(PDO::FETCH_ASSOC);

$exist_alias = array();

foreach($aliases as $alias){
    foreach($contentData as $key){
      if($key['alias'] == $alias){
        $exist_alias[] = $key;
       // array_merge($exist_alias, $key);
        }
    } 
}
echo json_encode($exist_alias);


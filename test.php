<?php
$some_relative_path = "hello";
$server_url = $_SERVER["SERVER_NAME"];
$doc_root = $_SERVER["DOCUMENT_ROOT"];


echo $url = $server_url.'/'. $some_relative_path."<br />";
echo $dir = $doc_root.'/'. $some_relative_path;
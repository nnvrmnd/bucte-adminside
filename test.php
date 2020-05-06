<?php
	/* $some_relative_path = "hello";
	$doc_root = $_SERVER["DOCUMENT_ROOT"];
	echo $url = $server_url.'/'. $some_relative_path."<br />";
	echo $dir = $doc_root.'/'. $some_relative_path;
	echo dirname(__FILE__);
	echo '$_SERVER[PHP_SELF]: ' . $_SERVER['PHP_SELF'] . '<br />'; */

	$server_url = $_SERVER['SERVER_NAME'];
	$server_url = $server_url . dirname($_SERVER['PHP_SELF'], 2);
?>

<?php date_default_timezone_set('Asia/Manila'); ?>

<?php
	/* $za = new ZipArchive();

	$za->open('D:\Folder\Folders\Compressed\IDM_Fake_Fixed.zip');

	for( $i = 0; $i < $za->numFiles; $i++ ){
			$stat = $za->statIndex( $i );
			print_r( basename( $stat['name'] ) . PHP_EOL );
			echo '<br>';
	} */


$zip = zip_open('D:\Folder\Folders\Compressed\IDM_Fake_Fixed.zip');

if (is_resource($zip)) {
	while ($zip_entry = zip_read($zip)) {
		echo '<p>';
		echo 'Name: ' . zip_entry_name($zip_entry) . '<br />';

		if (zip_entry_open($zip, $zip_entry)) {
			// echo 'File Contents:<br/>';
			$contents = zip_entry_read($zip_entry);
			// echo "$contents<br />";
			zip_entry_close($zip_entry);
		}
		echo '</p>';
	}

	zip_close($zip);
}

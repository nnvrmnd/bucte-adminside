<?php
//CONSTANTS
define('INSERT', 'insert');
define('UPDATE', 'update');
define('OPTIONAL', 'optional');
define('CONTENT', 'content');
define('SAVE_PATH', '../../../files/contents/'); //folder path where images is saved
define('DESTINATION', '../files/contents/'); //folder path to be saved in database

//Data validation
function checkFileExist($filepath, $file, $operation) {
	$extensions = ['.jpg', '.jpeg', '.tif', '.png'];
	$boolean = false;
	foreach ($extensions as $extension) {
		if (file_exists($filepath . $file . $extension)) {
			$operation == 1 ?: unlink($filepath . $file . $extension);
			$boolean = true;
		}
	}
	return $boolean;
}

function getImagePath($image, $path) {
	$extension = strtolower(pathinfo($_FILES[$image]['name'], PATHINFO_EXTENSION));
	$attachment = $image . '.' . $extension;
	$destination = $path . basename($attachment);
	return $destination;
}

function getImageName($image) {
	$extension = strtolower(pathinfo($_FILES[$image]['name'], PATHINFO_EXTENSION));
	$attachment = $image . '.' . $extension;
	$destination = basename($attachment);
	return $destination;
}

function uploadImage($image) {
	try {
		$destination = getImagePath($image, SAVE_PATH);
		move_uploaded_file($_FILES[$image]['tmp_name'], $destination);
	} catch (\Throwable $th) {
		return 'UPLOAD ERROR';//$errCount++;
	}
}

function filterExistIndex($posts) {
	$keys = array_filter($posts, function ($key) {
		return  isset($_POST[$key]) || (isset($_FILES[$key]['name']) && !empty($_FILES[$key]['tmp_name']));
	});
	return $keys;
}

function filterFileExistIndex($posts) {
	$keys = array_filter($posts, function ($key) {
		return file_exists(@$_FILES[$key]['tmp_name']) || is_uploaded_file(@$_FILES[$key]['tmp_name']);
	});
	return $keys;
}

function getExistValues($action, $data, $additionalData) {
	$values = [];
	foreach ($data as $key) {
		if (file_exists(@$_FILES[$key]['tmp_name']) || is_uploaded_file(@$_FILES[$key]['tmp_name'])) {
			$existFile = SAVE_PATH;
			$destination = getImagePath($key, DESTINATION);
			$boolean = checkFileExist($existFile, $key, 2);
			uploadImage($key);
			$values[':' . $key] = $destination;
		} else {
			$values[':' . $key] = $_POST[$key];
		}
	}
	if ($action == 'update') {
		$values = $values + $additionalData;
	}

	return $values;
}

function getValExistPost($data) {
	return  implode(', :', $data);
}

function getTableExistPost($data) {
	return  implode(', ', $data);
}

function createUpdateStatement($data) {
	$values = [];
	foreach ($data as $key) {
		$string = "$key= :$key";
		array_push($values, $string);
	}
	return  implode(', ', $values);
}

function getSQLStatement($action, $data, $table, $condition) {
	$columns = getTableExistPost($data);
	$values = getValExistPost($data);
	$updateStatement = createUpdateStatement($data);

	if ($action == 'insert') {
		return "INSERT INTO $table ($columns) VALUES (:$values)";
	} elseif ($action == 'update') {
		return "UPDATE $table SET $updateStatement WHERE $condition";
	}
}

<?php
if (isset($_GET['user'])) {
	require 'db.hndlr.php';
	$user = $_GET['user'];
	$stmnt = 'SELECT * FROM user WHERE username =?';
	$query = $db->prepare($stmnt);
	$query->execute([$user]);
	$data = $query->fetch(PDO::FETCH_ASSOC);
	echo json_encode($data);
}

if (isset($_POST['save_changes'])) {
	require 'db.hndlr.php';
	require 'DataValidator.php';

	// if (!is_dir('../../files/images')) {
	//     //Create our directory if it does not exist
	//     mkdir('../../files/images');
	// }

	//Post Keys
	$posts = ['u_id', 'title', 'content', 'meta1', 'meta2', 'meta3', 'alias'];
	$images = ['image-1', 'image-2', 'image-3'];

	function getDifference($postData, $contentData) {
		$count = 0;
		foreach ($postData as $postKey) {
			foreach ($contentData as $sqlKey => $value) {
				if ((@$_POST[$postKey] == $value && $value != 'homepage' && $value != $_POST['u_id']) || (file_exists(@$_FILES[$key]['tmp_name']))) {
					$count++;
				}
			}
		}
		return $count;
	}

	//Check Content if data exists
	$stmntGetContent = 'SELECT * FROM content where content.alias = ? ORDER BY updated_at DESC LIMIT 1';
	$alias = ['homepage'];
	$queryContent = $db->prepare($stmntGetContent);
	$queryContent->execute($alias);
	$contentData = $queryContent->fetch(PDO::FETCH_ASSOC);
	$countContent = $queryContent->rowCount();
	//print_r($contentData);

	//Content Function Calls
	$data = filterExistIndex($posts);
	//var_dump($data); //test
	$table = 'content';
	$condition = 'c_id= :c_id'; //substitute for Where Condition if UPDATE SCRIPT
	$additionalData = [':c_id' => $contentData['c_id']]; //equevalent of the Where Condition in UPDATE (!should be in array)

	//Content Image Function Call
	$image_data = filterFileExistIndex($images);

	$diffCount = getDifference($data, $contentData);
	//echo $diffCount;

	if ($diffCount != (count($data) - 2)) {
		if ($countContent > 0) {
			$existValues = getExistValues(UPDATE, $data, $additionalData);
			$sqlStatement = getSQLStatement(UPDATE, $data, CONTENT, $condition);
			// var_dump($existValues);
			// echo "<br >".$sqlStatement;
			$db->beginTransaction();
			$query = $db->prepare($sqlStatement);
			$query->execute($existValues);
			$count = $query->rowCount();
			//var_dump($query);
			$contentKey = $contentData['c_id'];
			$errCount = 0;
			if ($count > 0) {
				foreach ($image_data as $image) {
					try {
						$existFile = SAVE_PATH;
						$destination = getImagePath($image, DESTINATION);
						$image_name = getImageName($image);
						$boolean = checkFileExist($existFile, $image, 1);
						if ($boolean) {
							$stmnt = 'UPDATE content_images SET folder = ? where image = ?';
							$query = $db->prepare($stmnt);
							$param = [$image_name, $image];
							$query->execute($param);
							if ($query) {
								checkFileExist($existFile, $image, 2);
								uploadImage($image);
							}
						} else {
							$stmnt = 'INSERT INTO content_images (c_id, folder, image) VALUES (?, ?, ?) ';
							$query = $db->prepare($stmnt);
							$param = [$contentData['c_id'], $image_name, $image];
							$query->execute($param);
							if ($query) {
								checkFileExist($existFile, $image, 2);
								uploadImage($image);
							}
						}
					} catch (\Throwable $th) {
						$errCount++;
					}
				}
				if ($errCount > 0) {
					$db->rollBack();
					echo 'err:upload';
				} else {
					$db->commit();
					echo 'true';
				}
			} else {
				$db->rollBack();
				echo 'err:save';
			}
		} else {
			$existValues = getExistValues(INSERT, $data, OPTIONAL);
			$sqlStatement = getSQLStatement(INSERT, $data, CONTENT, OPTIONAL);
			$db->beginTransaction();
			$query = $db->prepare($sqlStatement);
			$query->execute($existValues);
			$count = $query->rowCount();
			$contentKey = $db->lastInsertId();
			$errCount = 0;
			if ($count > 0) {
				foreach ($image_data as $image) {
					try {
						$destination = getImagePath($image, SAVE_PATH);
						$image_name = getImageName($image);
						$stmnt = 'INSERT INTO content_images (c_id, folder, image) VALUES (?, ?, ?) ';
						$query = $db->prepare($stmnt);
						$param = [$contentKey, $image_name, $image];
						$query->execute($param);
						if ($query) {
							uploadImage($image);
						}
					} catch (\Throwable $th) {
						$errCount++;
					}
				}
				if ($errCount > 0) {
					$db->rollBack();
					echo 'err:upload';
				} else {
					$db->commit();
					echo 'true';
				}
			} else {
				$db->rollBack();
				echo 'err:save';
			}
		}
		//IF ENDS!!!
	} else {
		//var_dump($image_data);
		$numImage = count($image_data);
		$countImagePass = 0;
		foreach ($image_data as $image) {
			try {
				$extension = strtolower(pathinfo($_FILES[$image]['name'], PATHINFO_EXTENSION));
				$attachment = $image . '.' . $extension;
				$existFile = SAVE_PATH;
				$destination = getImagePath($image, DESTINATION);
				$image_name = getImageName($image);
				$boolean = checkFileExist($existFile, $image, 1);
				$errorUpload = 0;
				$db->beginTransaction();
				if ($boolean) {
					$stmnt = 'UPDATE content_images SET folder = ? where image = ?';
					$query = $db->prepare($stmnt);
					$param = [$image_name, $image];
					$query->execute($param);
					if ($query) {
						checkFileExist($existFile, $image, 2);
						uploadImage($image);
					} else {
						$errorUpload++;
					}
				} else {
					$stmnt = 'INSERT INTO content_images (c_id, folder, image) VALUES (?, ?, ?) ';
					$query = $db->prepare($stmnt);
					$param = [$contentData['c_id'], $image_name, $image];
					$query->execute($param);
					if ($query) {
						checkFileExist($existFile, $image, 2);
						uploadImage($image);
					} else {
						$errorUpload++;
						echo 'Err: Image Upload';
					}
				}
				if ($errorUpload > 0) {
					$db->rollBack();
				} else {
					$db->commit();
					$countImagePass++;
				}
			} catch (\Throwable $th) {
				echo 'Err: Image Upload';
				throw $th;
			}
		}
		if ($numImage == $countImagePass) {
			echo 'true';
		}
	}
}

if (isset($_POST['image'])) {
	require 'db.hndlr.php';
	require 'DataValidator.php';
	$db->beginTransaction();
	$stmnt = 'DELETE FROM content_images WHERE image = ?';
	$query = $db->prepare($stmnt);
	$param = [$_POST['image']];
	$query->execute($param);
	if ($query) {
		$db->commit();
		checkFileExist(SAVE_PATH, $_POST['image'], 2);
		echo 'true';
	} else {
		$db->rollBack();
		echo 'Err: delete';
	}
}

if (isset($_POST['signatureImage'])) {
	require 'db.hndlr.php';
	$db->beginTransaction();
	$stmnt = 'UPDATE content SET meta2=NULL where alias="homepage"';
	$query = $db->prepare($stmnt);
	$query->execute();
	$row = $query->rowCount();
	if ($row > 0) {
		$db->commit();
		echo 'true';
	} else {
		$db->rollBack();
		echo 'Err: delete';
	}
}

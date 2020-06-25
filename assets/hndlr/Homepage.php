<?php

if (isset($_POST['welcome'])) {
	require './db.hndlr.php';

	$rootDir = realpath('../../../files/contents/') . '/';

	$stmnt = 'SELECT * FROM content WHERE alias = "homepage" ;';
	$query = $db->prepare($stmnt);
	$query->execute();
	$count = $query->rowCount();
	if ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$title = $data['title'];
			$content = $data['content'];
			$image = $data['meta1'];
			$noimage = './assets/img/noimg.png';

			if (!file_exists($rootDir . $image)) {
				$image = $noimage;
			} else {
				$image = '../files/contents/' . $image;
			}

			$dbData[] = ['title' => $title, 'content' => $content, 'image' => $image];
		}

		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

if (isset($_POST['title']) && isset($_POST['author'])) {
	require './db.hndlr.php';

	$title = $_POST['title'];
	$body = $_POST['body'];

	if (isset($_FILES['image']['name'])) {
		$extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
		$attachment = 'image1_' . date('ymdhis') . '.' . $extension;
		$rootDir = realpath('../../../files/contents/') . '/';
		$destination = $rootDir . basename($attachment);

		$stmnt = 'UPDATE content SET title = ?, content = ?, meta1 = ? WHERE alias = "homepage" ;';
		$param = [$title, $body, $attachment];
	} else {
		$stmnt = 'UPDATE content SET title = ?, content = ? WHERE alias = "homepage" ;';
		$param = [$title, $body];
	}

	$db->beginTransaction();
	$query = $db->prepare($stmnt);
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		if (!isset($attachment)) {
			$db->commit();
			exit('true');
		} else {
			if (DeleteCurrentImage() !== false) {
				if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
					$db->commit();
					exit('true');
				} else {
					$db->rollBack();
					exit('err:upload');
				}
			} else {
				$db->rollBack();
				exit('err:delete_current');
			}
		}
	} else {
		$db->rollBack();
		exit('err:save');
	}
}

function DeleteCurrentImage() {
	require './db.hndlr.php';

	$rootDir = realpath('../../../files/contents/') . '/';

	$stmnt = 'SELECT meta1 FROM content WHERE alias = "homepage" ;';
	$query = $db->prepare($stmnt);
	$query->execute();
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			$image = $data['meta1'];
			$image = $rootDir . $image;
			if (file_exists($image)) {
				unlink($image);
			}
		}
		return true;
	}
}

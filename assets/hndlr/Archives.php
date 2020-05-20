<?php

/* Fetch for render */
if (isset($_POST['fetcharchives'])) {
	require './db.hndlr.php';

	function ZipEmpty() {
		require './db.hndlr.php';

		$stmnt = 'SELECT * FROM archive ;';
		$query = $db->prepare($stmnt);
		$query->execute();
		$count = $query->rowCount();
		if ($count > 0) {
			foreach ($query as $data) {
				$aid = $data['archv_id'];
				$stmnt = 'SELECT * FROM archived_documents WHERE archv_id = ? ;';
				$query = $db->prepare($stmnt);
				$param = [$aid];
				$query->execute($param);
				$count = $query->rowCount();
				if ($count <= 0) {
					$db->beginTransaction();
					$stmnt = 'DELETE FROM archive WHERE archv_id = ? ;';
					$query = $db->prepare($stmnt);
					$param = [$aid];
					$query->execute($param);
					$count = $query->rowCount();
					if ($count > 0) {
						$db->commit();
						return true;
					} else {
						$db->rollBack();
						return false;
					}
				} else {
					return true;
				}
			}
		} else {
			return true;
		}
	}

	if (ZipEmpty() === true) {
		$stmnt = 'SELECT * FROM archive';
		$query = $db->prepare($stmnt);
		$query->execute();
		$count = $query->rowCount();
		if ($count <= 0) {
			exit('err:fetch');
		} elseif ($count > 0) {
			$dbData = [];
			foreach ($query as $data) {
				$archive_id = $data['archv_id'];
				$author = $data['u_id'];
				$zipname = $data['zipname'];
				$description = $data['description'];
				$created_at = date('jS M Y \a\t h:i A', strtotime($data['created_at']));

				$dbData[] = ['archive_id' => $archive_id, 'author' => $author, 'zipname' => $zipname, 'description' => $description, 'created_at' => $created_at];
			}
			$arrObject = json_encode($dbData);
			echo $arrObject;
		}
	}

}

/* Fetch 1 archive */
if (isset($_POST['archive'])) {
	require './db.hndlr.php';

	$archive = $_POST['archive'];

	$stmnt = 'SELECT a.zipname, ad.*, d.* FROM archive AS a, archived_documents AS ad, document AS d WHERE a.archv_id = ? AND ad.archv_id = a.archv_id AND d.doc_id = ad.doc_id ;';
	$query = $db->prepare($stmnt);
	$param = [$archive];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count <= 0) {
		exit('err:fetch');
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$document_id = $data['doc_id'];
			$zipname = $data['zipname'];
			$title = $data['title'];
			$format = $data['file_format'];
			$description = $data['description'];
			$uploaded_at = date('jS M Y \a\t h:i A', strtotime($data['uploaded_at']));

			$dbData[] = ['document_id' => $document_id, 'zipname' => $zipname, 'title' => $title, 'format' => $format, 'description' => $description, 'uploaded_at' => $uploaded_at];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

if (isset($_POST['extract'])) {
	require './db.hndlr.php';

	/* Unzip files passed */
	function Unzipper($fileName, $archiveName) {
		$ctrl = false;
		$rootDir = realpath('../../files/documents/') . '/';
		$archiveName = $rootDir . $archiveName . '.zip';

		$zip = new ZipArchive;
		if ($zip->open($archiveName) === true) {
			if (file_exists($archiveName)) {
				$zip->extractTo($rootDir, $fileName);
				$ctrl = true;
			} else {
				$zip->unchangeAll();
			}

			$zip->close();
		}

		if ($ctrl === true) {
			if ($zip->open($archiveName) === true) {
				$zip->deleteName($fileName);
				$zip->close();
			}
		}

		return $ctrl;
	}

	$id = $_POST['extract'];

	$stmnt = 'SELECT a.zipname, ad.*, d.* FROM archive AS a, archived_documents AS ad, document AS d WHERE ad.doc_id = ? AND d.doc_id = ad.doc_id AND ad.archv_id = a.archv_id ;';
	$query = $db->prepare($stmnt);
	$param = [$id];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			$document_id = $data['doc_id'];
			$archive_id = $data['archv_id'];
			$attachment = $data['attachment'];
			$zipname = $data['zipname'];
		}

		$db->beginTransaction();
		$stmnt = 'DELETE FROM archived_documents WHERE doc_id = ? ;';
		$query = $db->prepare($stmnt);
		$param = [$document_id];
		$query->execute($param);
		$count = $query->rowCount();
		if ($count > 0) {
			$stmnt = 'UPDATE document SET status = "present" WHERE doc_id = ? ;';
			$query = $db->prepare($stmnt);
			$param = [$document_id];
			$query->execute($param);
			$count = $query->rowCount();
			if ($count > 0) {
				if (Unzipper($attachment, $zipname) === true) {
					$db->commit();
					echo 'true';
				} else {
					$db->rollBack();
					echo 'err:unzipper';
				}
			} else {
				$db->rollBack();
				echo 'err:docstate';
			}
		} else {
			$db->rollBack();
			echo 'err:archivedoc';
		}
	}
}

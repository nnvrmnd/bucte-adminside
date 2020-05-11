<?php

/* Fetch for render */
if (isset($_POST['fetchrecords'])) {
	require 'db.hndlr.php';

	$stmnt = 'SELECT * FROM document WHERE status = "present" ;';
	$query = $db->prepare($stmnt);
	//  $param = [$who];
	$query->execute();
	$count = $query->rowCount();
	if ($count <= 0) {
		echo 'err:fetch';
		exit();
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$doc_id = $data['doc_id'];
			$author = $data['u_id'];
			$title = $data['title'];
			$description = $data['description'];
			$attachment = $data['attachment'];
			$doctype = $data['doc_type'];
			$format = $data['file_format'];
			$status = $data['status'];
			$uploaded_at = date('jS M Y \a\t h:i A', strtotime($data['uploaded_at']));

			$dbData[] = ['doc_id' => $doc_id, 'author' => $author, 'title' => $title, 'description' => $description, 'attachment' => $attachment, 'doctype' => $doctype, 'format' => $format, 'status' => $status, 'uploaded_at' => $uploaded_at];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* Add new record */
if (isset($_POST['title']) && isset($_POST['author'])) {
	require 'db.hndlr.php';
	require 'Global.php';

	$author = $_POST['author'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$file_format = $_POST['file_format'];

	$extension = strtolower(pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION));
	$attachment = preg_replace('/[^A-Za-z0-9_.-]+/', '_', ucwords($title)) . '_' . date('ymd_his') . '.' . $extension;
	$folder = date('Y-m');
	$destination = '../../files/records/' . basename($attachment);

	$db->beginTransaction();
	$stmnt = 'INSERT INTO document (u_id, title, description, attachment, doc_type, file_format) VALUES (?, ?, ?, ?, ?, ?) ;';
	$query = $db->prepare($stmnt);
	$param = [$author, $title, $description, $attachment, 'record', $file_format];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		if (move_uploaded_file($_FILES['select_file']['tmp_name'], $destination)) {
			$db->commit();
			echo 'true';
		} else {
			$db->rollBack();
			echo 'err:upload';
		}
	} else {
		$db->rollBack();
		echo 'err:save';
	}
}

/* Fetch 1 record to update */
if (isset($_POST['record'])) {
	require 'db.hndlr.php';

	$record = $_POST['record'];

	$stmnt = 'SELECT * FROM document WHERE doc_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$record];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count <= 0) {
		echo 'err:fetch';
		exit();
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$record_id = $data['doc_id'];
			$title = $data['title'];
			$attachment = $data['attachment'];
			$doctype = $data['doc_type'];
			$format = $data['file_format'];
			$description = $data['description'];

			$dbData[] = ['record_id' => $record_id, 'title' => $title, 'attachment' => $attachment, 'doctype' => $doctype, 'format' => $format, 'description' => $description];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* Update record */
if (isset($_POST['record_id']) && isset($_POST['edt_title'])) {
	require 'db.hndlr.php';

	$id = $_POST['record_id'];
	$title = $_POST['edt_title'];
	$description = $_POST['edt_description'];

	$db->beginTransaction();
	$stmnt = 'UPDATE document SET title = ?, description = ? WHERE doc_id = ? ;';
	$param = [$title, $description, $id];
	$query = $db->prepare($stmnt);
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		$db->commit();
		echo 'true';
	} else {
		$db->rollBack();
		echo 'err:save';
	}
}

/* Delete record */
if (isset($_POST['action']) && isset($_POST['id'])) {
	require 'db.hndlr.php';

	$record = $_POST['id'];
	$dir = '../../files/records/';

	$stmnt = 'SELECT attachment FROM document WHERE doc_id = ?';
	$query = $db->prepare($stmnt);
	$param = [$record];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			$file = $data['attachment'];
			$file = $dir . $file;

			if (file_exists($file) === true) {
				if (unlink($file)) {
					$db->beginTransaction();
					$stmnt = 'DELETE FROM document WHERE doc_id = ? ;';
					$query = $db->prepare($stmnt);
					$param = [$record];
					$query->execute($param);
					$count = $query->rowCount();
					if ($count > 0) {
						$db->commit();
						echo 'true';
					} else {
						$db->rollBack();
						echo 'err:delete';
					}
				} else {
					echo 'err:rm';
				}
			} else {
				echo 'err:!exist';
			}
		}
	}
}

/* Validate zip name */
if (isset($_POST['new_archivename'])) {
	require './db.hndlr.php';

	$archiveName = $_POST['new_archivename'];

	$stmnt = 'SELECT zipname FROM archive WHERE BINARY zipname = ?;';
	$query = $db->prepare($stmnt);
	$param = [$archiveName];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		echo 'true';
	} else {
		echo 'false';
	}
}

/* Create archive zipname record entry */
if (isset($_POST['archive_author']) && isset($_POST['archive_name'])) {
	require './db.hndlr.php';

	$author = $_POST['archive_author'];
	$filename = $_POST['archive_name'];
	$filename = preg_replace('/[^A-Za-z0-9 _.-]+/', '_', $filename);

	$db->beginTransaction();
	$stmnt = 'INSERT INTO archive (u_id, zipname) VALUES (?, ?) ;';
	$query = $db->prepare($stmnt);
	$param = [$author, $filename];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		$id = $db->lastInsertId();
		$db->commit();

		$dbData = [];
		$dbData[] = ['lid' => $id];
		echo json_encode($dbData);
	} else {
		$db->rollBack();
		echo 'err:newarchive';
	}
}

/* Archive files */
if (isset($_POST['archive'])) {
	require './db.hndlr.php';

	/* Unsave archive zipname entry */
	function RollbackZipname($id, $msg) {
		require './db.hndlr.php';
		$db->beginTransaction();
		$stmnt = 'DELETE FROM archive WHERE archv_id = ? ;';
		$query = $db->prepare($stmnt);
		$param = [$id];
		$query->execute($param);
		$count = $query->rowCount();
		if ($count > 0) {
			$db->commit();
			return $msg;
		} else {
			$db->rollBack();
			return 'err:rollbackzipname';
		}
	}

	/* Return new archive name */
	function ArchiveName($id) {
		require './db.hndlr.php';

		$stmnt = 'SELECT zipname FROM archive WHERE archv_id = ? ;';
		$query = $db->prepare($stmnt);
		$param = [$id];
		$query->execute($param);
		$count = $query->rowCount();
		if ($count > 0) {
			foreach ($query as $data) {
				return $data['zipname'];
			}
		}
	}

	/* Compress files passed */
	function Zipper($files, $archiveName) {
		$ctrl = false;
		$rootDir = realpath('../../files/records/') . '/';
		$archiveName = $rootDir . $archiveName . '.zip';

		$zip = new ZipArchive;
		if ($zip->open($archiveName, ZipArchive::CREATE) === true) {
			foreach ($files as $file) {
				$docid = $file['doc_id'];
				$fileName = $file['attachment'];
				$filePath = $file['path'];

				if (file_exists($filePath)) {
					$zip->addFile($filePath, $fileName);
					$ctrl = true;
				} else {
					$zip->unchangeAll();
					break;
				}
			}
			$zip->close();

			if ($ctrl === true) {
				foreach ($files as $file) {
					$filePath = $file['path'];
					/* CAUTION: Enable 'unlink' on production */
					unlink($filePath);
				}
			}


		}

		return $ctrl;
	}

	$archiveJson = json_decode($_POST['archive']);
	$archive_id = $archiveJson->{'archive_id'};
	$archive_name = ArchiveName($archive_id);
	$files_id = $archiveJson->{'files'};
	$rootDir = realpath('../../files/records/') . '/';
	$files = [];

	/* Put data in an array '$files" */
	foreach ($files_id as $file) {
		$stmnt = 'SELECT * FROM document WHERE doc_id = ?;';
		$query = $db->prepare($stmnt);
		$param = [$file];
		$query->execute($param);
		$count = $query->rowCount();
		if ($count > 0) {
			foreach ($query as $data) {
				$id = $data['doc_id'];
				$attachment = $data['attachment'];
				$path = str_replace('/', DIRECTORY_SEPARATOR, $rootDir . $attachment);
				$files[] = [
					'archive_id' => $archive_id,
					'doc_id' => $id,
					'attachment' => $attachment,
					'path' => $path
				];
			}
		}
	}

	// TODO: Archival
	// - Read zip file on modal
	// - Add retrieval

	$db->beginTransaction();
	$stmnt = 'INSERT INTO archived_documents (archv_id, doc_id) VALUES (?, ?) ;';
	$query = $db->prepare($stmnt);
	foreach ($files as $file) {
		$archiveid = $file['archive_id'];
		$docid = $file['doc_id'];
		$param = [$archiveid, $docid];
		$query->execute($param);
	}
	$count = $query->rowCount();
	if ($count > 0) {
		$stmnt = 'UPDATE document SET status = "archived" WHERE doc_id = ? ;';
		$query = $db->prepare($stmnt);
		foreach ($files as $file) {
			$docid = $file['doc_id'];
			$param = [$docid];
			$query->execute($param);
		}
		$count = $query->rowCount();
		if ($count > 0) {
			if (Zipper($files, $archive_name) === true) {
				$db->commit();
				echo 'true';
			} else {
				$db->rollBack();
				echo RollbackZipname($archive_id, 'err:zipper');
			}
		} else {
			$db->rollBack();
			echo RollbackZipname($archive_id, 'err:docstate');
		}
	} else {
		$db->rollBack();
		echo RollbackZipname($archive_id, 'err:archivedoc');
	}
}

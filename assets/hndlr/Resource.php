<?php

/* Fetch for render */
if (isset($_POST['fetchresources'])) {
	require './db.hndlr.php';

	$stmnt = 'SELECT * FROM resource WHERE status = "present" ORDER BY uploaded_at ASC;';
	$query = $db->prepare($stmnt);
	//  $param = [$who];
	$query->execute();
	$count = $query->rowCount();
	if ($count <= 0) {
		exit('err:fetch');
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$res_id = $data['res_id'];
			$author = $data['u_id'];
			$title = $data['title'];
			$description = $data['description'];
			$attachment = $data['attachment'];
			$restype = $data['res_type'];
			$format = $data['file_format'];
			$status = $data['status'];
			$uploaded_at = $data['uploaded_at'];

			$dbData[] = ['res_id' => $res_id, 'author' => $author, 'title' => $title, 'description' => $description, 'attachment' => $attachment, 'restype' => $restype, 'format' => $format, 'status' => $status, 'uploaded_at' => $uploaded_at];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* Add new resource */
if (isset($_POST['title']) && isset($_POST['author'])) {
	require './db.hndlr.php';
	require 'Global.php';

	$author = $_POST['author'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$file_format = $_POST['file_format'];

	$extension = strtolower(pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION));
	$attachment = preg_replace('/[^A-Za-z0-9_.-]+/', '_', ucwords($title)) . '_' . date('ymd_his') . '.' . $extension;
	$folder = date('Y-m');
	$destination = '../../../files/library/' . basename($attachment);

	$db->beginTransaction();
	$stmnt = 'INSERT INTO resource (u_id, title, description, attachment, res_type, file_format) VALUES (?, ?, ?, ?, ?, ?) ;';
	$query = $db->prepare($stmnt);
	$param = [$author, $title, $description, $attachment, 'resource', $file_format];
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

/* Fetch 1 resource to update */
if (isset($_POST['resource'])) {
	require './db.hndlr.php';

	$resource = $_POST['resource'];

	$stmnt = 'SELECT * FROM resource WHERE res_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$resource];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count <= 0) {
		echo 'err:fetch';
		exit();
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$resource_id = $data['res_id'];
			$title = $data['title'];
			$attachment = $data['attachment'];
			$restype = $data['res_type'];
			$format = $data['file_format'];
			$description = $data['description'];

			$dbData[] = ['resource_id' => $resource_id, 'title' => $title, 'attachment' => $attachment, 'restype' => $restype, 'format' => $format, 'description' => $description];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* Update resource */
if (isset($_POST['resource_id']) && isset($_POST['edt_title'])) {
	require './db.hndlr.php';

	$id = $_POST['resource_id'];
	$title = $_POST['edt_title'];
	$description = $_POST['edt_description'];

	$db->beginTransaction();
	$stmnt = 'UPDATE resource SET title = ?, description = ? WHERE res_id = ? ;';
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

/* Delete 1 resource */
if (isset($_POST['action']) && isset($_POST['id'])) {
	require './db.hndlr.php';

	$resource = $_POST['id'];
	$dir = '../../../files/library/';

	$stmnt = 'SELECT attachment FROM resource WHERE res_id = ?';
	$query = $db->prepare($stmnt);
	$param = [$resource];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			$file = $data['attachment'];
			$file = $dir . $file;

			$db->beginTransaction();
			$stmnt = 'DELETE FROM resource WHERE res_id = ? ;';
			$query = $db->prepare($stmnt);
			$param = [$resource];
			$query->execute($param);
			$count = $query->rowCount();
			if ($count > 0) {
				$db->commit();
				if (file_exists($file)) {
					unlink($file);
				}
				echo 'true';
			} else {
				$db->rollBack();
				echo 'err:delete';
			}
		}
	}
}

/* Delete selected files */
if (isset($_POST['delete'])) {
	require './db.hndlr.php';

	$deletefiles = json_decode($_POST['delete']);
	$rootDir = realpath('../../../files/library/') . '/';
	$files = [];

	$stmnt = 'SELECT * FROM resource WHERE res_id = ?;';
	$query = $db->prepare($stmnt);
	foreach ($deletefiles as $file) {
		$param = [$file];
		$query->execute($param);
		$count = $query->rowCount();
		if ($count > 0) {
			foreach ($query as $data) {
				$id = $data['res_id'];
				$attachment = $data['attachment'];
				$path = str_replace('/', DIRECTORY_SEPARATOR, $rootDir . $attachment);
				$files[] = [
					'res_id' => $id,
					'attachment' => $attachment,
					'path' => $path
				];
			}
		}
	}

	$db->beginTransaction();
	$stmnt = 'DELETE FROM resource WHERE res_id = ? ;';
	$query = $db->prepare($stmnt);
	foreach ($files as $file) {
		$id = $file['res_id'];
		$param = [$id];
		$query->execute($param);
	}
	$count = $query->rowCount();
	if ($count > 0) {
		$db->commit();
		foreach ($files as $file) {
			$attachment = $file['path'];
			if (file_exists($attachment)) {
				unlink($attachment);
			}
		}
		echo 'true';
	} else {
		$db->rollBack();
		echo 'false';
	}
}

/* Validate new zip name -> validationRes */
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

/* Create archive resource entry -> zipnameRes */
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

/* Archive selected files */
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
		$rootDir = realpath('../../../files/library/') . '/';
		$archiveName = $rootDir . $archiveName . '.zip';

		$zip = new ZipArchive;
		if ($zip->open($archiveName, ZipArchive::CREATE) === true) {
			foreach ($files as $file) {
				$resid = $file['res_id'];
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
	$rootDir = realpath('../../../files/library/') . '/';
	$files = [];

	/* Put data in an array '$files" */
	foreach ($files_id as $file) {
		$stmnt = 'SELECT * FROM resource WHERE res_id = ?;';
		$query = $db->prepare($stmnt);
		$param = [$file];
		$query->execute($param);
		$count = $query->rowCount();
		if ($count > 0) {
			foreach ($query as $data) {
				$id = $data['res_id'];
				$attachment = $data['attachment'];
				$path = str_replace('/', DIRECTORY_SEPARATOR, $rootDir . $attachment);
				$files[] = [
					'archive_id' => $archive_id,
					'res_id' => $id,
					'attachment' => $attachment,
					'path' => $path
				];
			}
		}
	}

	$db->beginTransaction();
	$stmnt = 'INSERT INTO archived_resources (archv_id, res_id) VALUES (?, ?) ;';
	$query = $db->prepare($stmnt);
	foreach ($files as $file) {
		$archiveid = $file['archive_id'];
		$resid = $file['res_id'];
		$param = [$archiveid, $resid];
		$query->execute($param);
	}
	$count = $query->rowCount();
	if ($count > 0) {
		$stmnt = 'UPDATE resource SET status = "archived" WHERE res_id = ? ;';
		$query = $db->prepare($stmnt);
		foreach ($files as $file) {
			$resid = $file['res_id'];
			$param = [$resid];
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
			echo RollbackZipname($archive_id, 'err:resstate');
		}
	} else {
		$db->rollBack();
		echo RollbackZipname($archive_id, 'err:archiveres');
	}
}

<?php

/* Fetch for render */
if (isset($_POST['fetchevents'])) {
	require 'db.hndlr.php';

	$stmnt = 'SELECT * FROM events ORDER BY created_at ASC;';
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
			$event_id = $data['evnt_id'];
			$author = $data['u_id'];
			$image = $data['image'];
			$title = $data['title'];
			$start = $data['start_date'];
			$end = $data['end_date'];
			$deadline = $data['reg_deadline'];
			$venue = $data['venue'];
			$description = $data['description'];
			$created_at = $data['created_at'];

			$dbData[] = [
				'event_id' => $event_id,
				'author' => $author,
				'title' => $title,
				'image' => $image,
				'start' => $start,
				'end' => $end,
				'deadline' => $deadline,
				'venue' => $venue,
				'description' => $description,
				'created_at' => $created_at
			];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* Add event */
if (isset($_POST['title']) && isset($_POST['author'])) {
	require 'db.hndlr.php';

	$author = $_POST['author'];
	$title = $_POST['title'];
	$start = $_POST['start_datetime'];
	$end = $_POST['end_datetime'];
	$deadline = $_POST['reg_deadline'];
	$venue = $_POST['venue'];
	$description = $_POST['description'];

	$extension = strtolower(pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION));
	// preg_replace('/[^A-Za-z0-9_.-]+/', '_', $title)
	$attachment = 'event_' . date('ymdhis') . '.' . $extension;
	$rootDir = realpath('../../../files/events/') . '/';
	$destination = $rootDir . basename($attachment);

	$db->beginTransaction();
	$stmnt = 'INSERT INTO events (u_id, title, image, start_date, end_date, reg_deadline, venue, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ;';
	$query = $db->prepare($stmnt);
	$param = [$author, $title, $attachment, $start, $end, $deadline, $venue, $description];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		if (move_uploaded_file($_FILES['select_file']['tmp_name'], $destination)) {
			$db->commit();
			exit('true');
		} else {
			$db->rollBack();
			exit('err:upload');
		}
	} else {
		$db->rollBack();
		exit('err:save');
	}
}

/* Fetch 1 event to update */
if (isset($_POST['event'])) {
	require 'db.hndlr.php';

	$event = $_POST['event'];

	$stmnt = 'SELECT * FROM events WHERE evnt_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$event];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count <= 0) {
		exit('err:fetch');
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$event_id = $data['evnt_id'];
			$image = $data['image'];
			$title = $data['title'];
			$start = $data['start_date'];
			$end = $data['end_date'];
			$deadline = $data['reg_deadline'];
			$venue = $data['venue'];
			$description = $data['description'];

			$dbData[] = [
				'event_id' => $event_id,
				'title' => $title,
				'image' => $image,
				'start' => $start,
				'end' => $end,
				'deadline' => $deadline,
				'venue' => $venue,
				'description' => $description,
			];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* Update event */
if (isset($_POST['event_id']) && isset($_POST['edt_title'])) {
	require 'db.hndlr.php';

	$id = $_POST['event_id'];
	$title = $_POST['edt_title'];
	$start = $_POST['edt_start_datetime'];
	$end = $_POST['edt_end_datetime'];
	$deadline = $_POST['edt_reg_deadline'];
	$venue = $_POST['edt_venue'];
	$description = $_POST['edt_description'];

	if (isset($_FILES['edt_select_file']['name'])) {
		$extension = strtolower(pathinfo($_FILES['edt_select_file']['name'], PATHINFO_EXTENSION));
		$attachment = 'event_' . date('ymdhis') . '.' . $extension;
		$rootDir = realpath('../../../files/events/') . '/';
		$destination = $rootDir . basename($attachment);

		$stmnt = 'UPDATE events SET title = ?, image = ?, start_date = ?, end_date = ?, reg_deadline = ?, venue = ?, description = ? WHERE evnt_id = ? ;';
		$param = [$title, $attachment, $start, $end, $deadline, $venue, $description, $id];
	} else {
		$stmnt = 'UPDATE events SET title = ?, start_date = ?, end_date = ?, reg_deadline = ?, venue = ?, description = ? WHERE evnt_id = ? ;';
		$param = [$title, $start, $end, $deadline, $venue, $description, $id];
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
			if (DeleteCurrentImage($id) !== false) {
				if (move_uploaded_file($_FILES['edt_select_file']['tmp_name'], $destination)) {
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

/* Delete event */
if (isset($_POST['action']) && isset($_POST['id'])) {
	require 'db.hndlr.php';

	$event = $_POST['id'];
	$rootDir = realpath('../../../files/events/') . '/';

	$stmnt = 'SELECT image FROM events WHERE evnt_id = ?';
	$query = $db->prepare($stmnt);
	$param = [$event];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			$image = $data['image'];

			if (file_exists($rootDir . $image)) {
				unlink($rootDir . $image);
			}

			$db->beginTransaction();
			$stmnt = 'DELETE FROM events WHERE evnt_id = ? ;';
			$query = $db->prepare($stmnt);
			$param = [$event];
			$query->execute($param);
			$count = $query->rowCount();
			if ($count > 0) {
				$db->commit();
				exit('true');
			} else {
				$db->rollBack();
				exit('err:delete');
			}
		}
	}
}

function DeleteCurrentImage($event) {
	require './db.hndlr.php';

	$rootDir = realpath('../../../files/events/') . '/';

	$stmnt = 'SELECT image FROM events WHERE evnt_id = ?';
	$query = $db->prepare($stmnt);
	$param = [$event];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			$image = $data['image'];
			$image = $rootDir . $image;
			if (file_exists($image)) {
				unlink($image);
			}
		}
		return true;
	}
}

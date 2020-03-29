<?php

if (isset($_POST['fetchevents'])) {
    require 'db.hndlr.php';

    $stmnt = "SELECT * FROM events ORDER BY evnt_id DESC;";
    $query = $db->prepare($stmnt);
    //  $param = [$who];
    $query->execute();
    $count = $query->rowCount();
    if ($count <= 0) {
        echo "err:fetch";
        exit();
    } elseif ($count > 0) {
        $dbData = [];
        foreach ($query as $data) {
            $event_id = $data['evnt_id'];
            $author = $data['u_id'];
            $image = $data['image'];
            $title = $data['title'];
            $sched = date('jS M Y', strtotime($data['sched']));
            $venue = $data['venue'];
            $description = $data['description'];
            $created_at = date('jS M Y \a\t h:i A', strtotime($data['created_at']));

            $dbData[] = ['event_id' => $event_id, 'author' => $author, 'image' => $image, 'title' => $title, 'sched' => $sched, 'venue' => $venue, 'description' => $description, 'created_at' => $created_at];
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
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $description = $_POST['description'];

    $extension = strtolower(pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION));
    $attachment = preg_replace('/\s+/', '_', $title) . "_" . date('Ymdhis') . "." . $extension;
    $destination = "../../files/events/" . basename($attachment);

    $db->beginTransaction();
    $stmnt = "INSERT INTO events (u_id, title, image, sched, venue, description) VALUES (?, ?, ?, ?, ?, ?) ;";
    $query = $db->prepare($stmnt);
    $param = [$author, $title, $attachment, $date, $venue, $description];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        if (move_uploaded_file($_FILES['select_file']['tmp_name'], $destination)) {
            $db->commit();
            echo "true";
        } else {
            $db->rollBack();
            echo "err:upload";
        }
    } else {
        $db->rollBack();
        echo "err:save";
    }
}

/* Fetch 1 event to update */
if (isset($_POST['event'])) {
    require 'db.hndlr.php';

    $event = $_POST['event'];

    $stmnt = "SELECT * FROM events WHERE evnt_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$event];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count <= 0) {
        echo "err:fetch";
        exit();
    } elseif ($count > 0) {
        $dbData = [];
        foreach ($query as $data) {
            $event_id = $data['evnt_id'];
            $title = $data['title'];
            $image = $data['image'];
            $date = $data['sched'];
            $venue = $data['venue'];
            $description = $data['description'];

            $dbData[] = ['event_id' => $event_id, 'title' => $title, 'image' => $image, 'date' => $date, 'venue' => $venue, 'description' => $description];
        }
        $arrObject = json_encode($dbData);
        echo $arrObject;
    }
}

/* Update event */
if (isset($_POST['event_id']) && isset($_POST['edit_title'])) {
    require 'db.hndlr.php';

    $id = $_POST['event_id'];
    $title = $_POST['edit_title'];
    $date = $_POST['edit_date'];
    $venue = $_POST['edit_venue'];
    $description = $_POST['edit_description'];

    if (isset($_FILES['edit_select_file']['name'])) {
        $extension = strtolower(pathinfo($_FILES['edit_select_file']['name'], PATHINFO_EXTENSION));
        $attachment = preg_replace('/\s+/', '_', $title) . "_" . date('Ymdhis') . "." . $extension;
        $destination = "../../files/events/" . basename($attachment);

        $stmnt = "UPDATE events SET title = ?, image = ?, sched = ?, venue = ?, description = ? WHERE evnt_id = ? ;";
        $param = [$title, $attachment, $date, $venue, $description, $id];
    } else {
        $stmnt = "UPDATE events SET title = ?, sched = ?, venue = ?, description = ? WHERE evnt_id = ? ;";
        $param = [$title, $date, $venue, $description, $id];
    }

    $db->beginTransaction();
    $query = $db->prepare($stmnt);
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        if (!isset($attachment)) {
            $db->commit();
            echo "true";
        } else {
            if (move_uploaded_file($_FILES['edit_select_file']['tmp_name'], $destination)) {
                $db->commit();
                echo "true";
            } else {
                $db->rollBack();
                echo "err:upload";
            }
        }
    } else {
        $db->rollBack();
        echo "err:save";
    }
}

/* Delete event */
if (isset($_POST['action']) && isset($_POST['id'])) {
    require 'db.hndlr.php';

    $event = $_POST['id'];

    $db->beginTransaction();
    $stmnt = "DELETE FROM events WHERE evnt_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$event];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        $db->commit();
        echo "true";
    } else {
        $db->rollBack();
        echo "err:delete";
    }
}

function NumberOfItems($id)
{
    require 'db.hndlr.php';

    $stmnt = "SELECT * FROM questionnaire WHERE rvwr_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$id];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        return $count;
    } else {
        return "0";
    }
}

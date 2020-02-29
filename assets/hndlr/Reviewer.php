<?php

if (isset($_POST['fetchreviewers'])) {
    require 'db.hndlr.php';

    $stmnt = "SELECT * FROM reviewer ORDER BY rvwr_id DESC;";
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
            $reviewer_id = $data['rvwr_id'];
            $author = $data['u_id'];
            $title = $data['title'];
            $source = $data['source'];
            $level = $data['level'];
            $duration = $data['duration'];
            $items = NumberOfItems($reviewer_id);
            $description = $data['description'];
            $created_at = date('jS M Y \a\t h:i A', strtotime($data['created_at']));

            $dbData[] = ['rvwr_id' => $reviewer_id, 'author' => $author, 'title' => $title, 'source' => $source, 'level' => $level, 'duration' => $duration, 'items' => $items, 'description' => $description, 'created_at' => $created_at];
        }
        $arrObject = json_encode($dbData);
        echo $arrObject;
    }
}

/* Add reviewer */
if (isset($_POST['title']) && isset($_POST['author'])) {
    require 'db.hndlr.php';

    $author = $_POST['author'];
    $title = $_POST['title'];
    $source = $_POST['source'];
    $level = $_POST['level'];
    $duration = $_POST['duration'];
    $description = $_POST['description'];

    $db->beginTransaction();
    $stmnt = "INSERT INTO reviewer (u_id, title, source, level, duration, description) VALUES (?, ?, ?, ?, ?, ?) ;";
    $query = $db->prepare($stmnt);
    $param = [$author, $title, $source, $level, $duration, $description];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        $db->commit();
        echo "true";
    } else {
        $db->rollBack();
        echo "err:save";
    }
}

/* Fetch 1 reviewer to update */
if (isset($_POST['reviewer'])) {
    require 'db.hndlr.php';

    $reviewer = $_POST['reviewer'];

    $stmnt = "SELECT * FROM reviewer WHERE rvwr_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$reviewer];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count <= 0) {
        echo "err:fetch";
        exit();
    } elseif ($count > 0) {
        $dbData = [];
        foreach ($query as $data) {
            $reviewer_id = $data['rvwr_id'];
            $title = $data['title'];
            $source = $data['source'];
            $level = $data['level'];
            $duration = $data['duration'];
            $description = $data['description'];

            $dbData[] = ['reviewer_id' => $reviewer_id, 'title' => $title, 'source' => $source, 'level' => $level, 'duration' => $duration, 'description' => $description];
        }
        $arrObject = json_encode($dbData);
        echo $arrObject;
    }
}

/* Update reviewer */
if (isset($_POST['title']) && isset($_POST['reviewer_id'])) {
    require 'db.hndlr.php';

    $reviewer = $_POST['reviewer_id'];
    $title = $_POST['title'];
    $source = $_POST['source'];
    $level = $_POST['level'];
    $duration = $_POST['duration'];
    $description = $_POST['description'];

    $db->beginTransaction();
    $stmnt = "UPDATE reviewer SET title = ?, source = ?, level = ?, duration = ?, description = ? WHERE rvwr_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$title, $source, $level, $duration, $description, $reviewer];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        $db->commit();
        echo "true";
    } else {
        $db->rollBack();
        echo "err:save";
    }
}

/* Delete reviewer */
if (isset($_POST['action']) && isset($_POST['id'])) {
    require 'db.hndlr.php';

    $reviewer = $_POST['id'];

    $db->beginTransaction();
    $stmnt = "DELETE FROM reviewer WHERE rvwr_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$reviewer];
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

<?php

if (isset($_POST['fetchrecords'])) {
    require 'db.hndlr.php';

    $stmnt = "SELECT * FROM document ;";
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
            $doc_id = $data['doc_id'];
            $author = $data['u_id'];
            $title = $data['title'];
            $description = $data['description'];
            $attachment = $data['attachment'];
            $doc_type = $data['doc_type'];
            $file_format = $data['file_format'];
            $folder = $data['folder'];
            $category = $data['category'];
            $status = $data['status'];
            $uploaded_at = date('jS M Y \a\t h:i A', strtotime($data['uploaded_at']));

            $dbData[] = ['doc_id' => $doc_id, 'author' => $author, 'title' => $title, 'description' => $description, 'attachment' => $attachment, 'doc_type' => $doc_type, 'file_format' => $file_format, 'folder' => $folder, 'category' => $category, 'status' => $status, 'uploaded_at' => $uploaded_at];
        }
        $arrObject = json_encode($dbData);
        echo $arrObject;
    }
}

if (isset($_POST['author']) && $_POST['format'] != "") {
    require 'db.hndlr.php';
    require 'Global.php';

    $author = $_POST['author'];
    $file_format = $_POST['format'];
    $title = $_POST['title'];
    $type = $_POST['file_type']; // file type & folder
    if ($type == 'other') {
        $type = $_POST['other_type'];
    }
    $description = $_POST['description'];
    $extension = strtolower(pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION));
    $attachment = "file_" . date('Ymdhis') . "." . $extension;
    $folder = date("Y-m");
    $destination = "../../files/" . $type . "/" . $folder . "/" . basename($attachment);

    if (!is_dir("../../files/" . $type . "/" . $folder)) {
        mkdir("../../files/" . $type . "/" . $folder, 0777, true);
    }

    if (move_uploaded_file($_FILES['select_file']['tmp_name'], $destination)) {
        $db->beginTransaction();
        $stmnt = "INSERT INTO document (u_id, title, description, attachment, doc_type, file_format, folder) VALUES (?, ?, ?, ?, ?, ?, ?) ;";
        $query = $db->prepare($stmnt);
        $param = [$author, $title, $description, $attachment, $type, $file_format, $folder];
        $query->execute($param);
        $count = $query->rowCount();
        if ($count > 0) {
            $db->commit();
            echo "true";
        } else {
            $db->rollBack();
            echo "err:save";
        }
    } else {
        echo "err:upload";
    }
}

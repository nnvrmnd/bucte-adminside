<?php

/* reviewer sesh */
if (isset($_POST['sesh'])) {
    require 'db.hndlr.php';

    $reviewer = $_POST['sesh'];

    $stmnt = "SELECT title FROM reviewer WHERE rvwr_id = ?";
    $query = $db->prepare($stmnt);
    $param = [$reviewer];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        foreach ($query as $data) {
            echo $data['title'];
        }
    } else {
        echo '!exist';
    }
}

if (isset($_POST['fetchitems']) && isset($_POST['reviewer'])) {
    require 'db.hndlr.php';

    $reviewer = $_POST['reviewer'];

    $stmnt = "SELECT * FROM questionnaire WHERE rvwr_id = ? ORDER BY qstn_id DESC ;";
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
            $question_id = $data['qstn_id'];
            $question = $data['question'];
            $optionA = $data['optionA'];
            $optionB = $data['optionB'];
            $optionC = $data['optionC'];
            $optionD = $data['optionD'];
            $answer = $data['answer'];

            $dbData[] = ['question_id' => $question_id, 'question' => $question, 'optionA' => $optionA, 'optionB' => $optionB, 'optionC' => $optionC, 'optionD' => $optionD, 'answer' => $answer];
        }
        $arrObject = json_encode($dbData);
        echo $arrObject;
    }
}

/* New item */
if (isset($_POST['answer']) && isset($_POST['reviewer'])) {
    require 'db.hndlr.php';

    $reviewer = $_POST['reviewer'];
    $question = $_POST['question'];
    $optionA = $_POST['optionA'];
    $optionB = $_POST['optionB'];
    $optionC = $_POST['optionC'];
    $optionD = $_POST['optionD'];
    $answer = $_POST['answer'];

    $db->beginTransaction();
    $stmnt = "INSERT INTO questionnaire (rvwr_id, question, optionA, optionB, optionC, optionD, answer) VALUES (?, ?, ?, ?, ?, ?, ?) ;";
    $query = $db->prepare($stmnt);
    $param = [$reviewer, $question, $optionA, $optionB, $optionC, $optionD, $answer];
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

/* Fetch 1 item to update */
if (isset($_POST['item'])) {
    require 'db.hndlr.php';

    $question = $_POST['item'];

    $stmnt = "SELECT * FROM questionnaire WHERE qstn_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$question];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count <= 0) {
        echo "err:fetch";
        exit();
    } elseif ($count > 0) {
        $dbData = [];
        foreach ($query as $data) {
            $question_id = $data['qstn_id'];
            $question = $data['question'];
            $optionA = $data['optionA'];
            $optionB = $data['optionB'];
            $optionC = $data['optionC'];
            $optionD = $data['optionD'];
            $answer = $data['answer'];

            $dbData[] = ['question_id' => $question_id, 'question' => $question, 'optionA' => $optionA, 'optionB' => $optionB, 'optionC' => $optionC, 'optionD' => $optionD, 'answer' => $answer];
        }
        $arrObject = json_encode($dbData);
        echo $arrObject;
    }
}

/* Update item */
if (isset($_POST['answer']) && isset($_POST['question_id'])) {
    require 'db.hndlr.php';

    $item = $_POST['question_id'];
    $question = $_POST['question'];
    $optionA = $_POST['optionA'];
    $optionB = $_POST['optionB'];
    $optionC = $_POST['optionC'];
    $optionD = $_POST['optionD'];
    $answer = $_POST['answer'];

    $db->beginTransaction();
    $stmnt = "UPDATE questionnaire SET question = ?, optionA = ?, optionB = ?, optionC = ?, optionD = ?, answer = ? WHERE qstn_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$question, $optionA, $optionB, $optionC, $optionD, $answer, $item];
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

/* Delete item */
if (isset($_POST['action']) && isset($_POST['id'])) {
    require 'db.hndlr.php';

    $item = $_POST['id'];

    $db->beginTransaction();
    $stmnt = "DELETE FROM questionnaire WHERE qstn_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$item];
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

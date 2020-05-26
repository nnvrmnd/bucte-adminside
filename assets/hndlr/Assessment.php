<?php

/* Fetch for render */
if (isset($_POST['fetchitems'])) {
	require './db.hndlr.php';

	$stmnt = 'SELECT * FROM assessment ORDER BY assmnt_id DESC ;';
	$query = $db->prepare($stmnt);
	$query->execute();
	$count = $query->rowCount();
	if ($count <= 0) {
		exit('err:fetch');
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$assessment_id = $data['assmnt_id'];
			$question = $data['question'];
			$optionA = $data['optionA'];
			$optionB = $data['optionB'];
			$optionC = $data['optionC'];
			$optionD = $data['optionD'];
			$answer = $data['answer'];

			$dbData[] = ['assessment_id' => $assessment_id, 'question' => $question, 'optionA' => $optionA, 'optionB' => $optionB, 'optionC' => $optionC, 'optionD' => $optionD, 'answer' => $answer, 'count' => $count];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* New item */
if (isset($_POST['answer']) && isset($_POST['question'])) {
	require './db.hndlr.php';

	$question = $_POST['question'];
	$optionA = $_POST['optionA'];
	$optionB = $_POST['optionB'];
	$optionC = $_POST['optionC'];
	$optionD = $_POST['optionD'];
	$answer = $_POST['answer'];

	$db->beginTransaction();
	$stmnt = 'INSERT INTO assessment (question, optionA, optionB, optionC, optionD, answer) VALUES (?, ?, ?, ?, ?, ?) ;';
	$query = $db->prepare($stmnt);
	$param = [$question, $optionA, $optionB, $optionC, $optionD, $answer];
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

/* Fetch 1 item to update */
if (isset($_POST['item'])) {
	require './db.hndlr.php';

	$question = $_POST['item'];

	$stmnt = 'SELECT * FROM assessment WHERE assmnt_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$question];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count <= 0) {
		exit('err:fetch');
	} elseif ($count > 0) {
		$dbData = [];
		foreach ($query as $data) {
			$assessment_id = $data['assmnt_id'];
			$question = $data['question'];
			$optionA = $data['optionA'];
			$optionB = $data['optionB'];
			$optionC = $data['optionC'];
			$optionD = $data['optionD'];
			$answer = $data['answer'];

			$dbData[] = ['assessment_id' => $assessment_id, 'question' => $question, 'optionA' => $optionA, 'optionB' => $optionB, 'optionC' => $optionC, 'optionD' => $optionD, 'answer' => $answer];
		}
		$arrObject = json_encode($dbData);
		echo $arrObject;
	}
}

/* Update item */
if (isset($_POST['edt_item']) && isset($_POST['edt_question']) ) {
	require './db.hndlr.php';

	$item = $_POST['edt_item'];
	$question = $_POST['edt_question'];
	$optionA = $_POST['optionA'];
	$optionB = $_POST['optionB'];
	$optionC = $_POST['optionC'];
	$optionD = $_POST['optionD'];
	$answer = $_POST['answer'];

	$db->beginTransaction();
	$stmnt = 'UPDATE assessment SET question = ?, optionA = ?, optionB = ?, optionC = ?, optionD = ?, answer = ? WHERE assmnt_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$question, $optionA, $optionB, $optionC, $optionD, $answer, $item];
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

/* Delete item */
if (isset($_POST['action']) && isset($_POST['id'])) {
	require './db.hndlr.php';

	$item = $_POST['id'];

	$db->beginTransaction();
	$stmnt = 'DELETE FROM assessment WHERE assmnt_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$item];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		$db->commit();
		echo 'true';
	} else {
		$db->rollBack();
		echo 'err:delete';
	}
}

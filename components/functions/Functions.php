<?php

function SeshStart($where) {
	date_default_timezone_set('Asia/Manila');
	session_start();

	if (!isset($_SESSION['who']) && isset($_COOKIE['who']) && isset($_COOKIE['token'])) {
		$_SESSION['who'][0] = $_COOKIE['who'];
		$_SESSION['who'][1] = $_COOKIE['token'];
		$who = $_SESSION['who'][0];
		$token = $_SESSION['who'][1];
		AuthWho($who, $token, $where);
	} elseif (isset($_SESSION['who'])) {
		$who = $_SESSION['who'][0];
		$token = $_SESSION['who'][1];
		AuthWho($who, $token, $where);
	} else {
		if ($where != 'auth') {
			header('location: authenticate.php');
		}
	}
}

function AuthWho($who, $token, $where) {
	require './assets/hndlr/db.hndlr.php';
	$stmnt = 'SELECT * FROM user WHERE BINARY (username = ? OR email = ?) ;';
	$query = $db->prepare($stmnt);
	$param = [$who, $who];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			$db_token = $data['token'];
			if (password_verify($db_token, $token)) {
				if ($where != 'page') {
					header('location: events.php');
				}
			} else {
				setcookie('who', '', time() - 28801, '/bucte/');
				setcookie('token', '', time() - 28801, '/bucte/');
				unset($_SESSION['who']);
				if ($where != 'auth') {
					header('location: authenticate.php');
				}
			}
		}
	} else {
		setcookie('who', '', time() - 28801, '/bucte/');
		setcookie('token', '', time() - 28801, '/bucte/');
		unset($_SESSION['who']);
		if ($where != 'auth') {
			header('location: authenticate.php');
		}
	}
}

function Author($id) {
	require 'db.hndlr.php';

	$stmnt = 'SELECT * FROM user WHERE u_id = ? ;';
	$query = $db->prepare($stmnt);
	$param = [$id];
	$query->execute($param);
	$count = $query->rowCount();
	if ($count > 0) {
		foreach ($query as $data) {
			return $data['given_name'] . '&nbsp;' . $data['surname'];
		}
	} else {
		return 'null';
	}
}

<?php

function SetToken($token, $who)
{
    // echo $token;
    // echo $who;

    require 'db.hndlr.php';

    $db->beginTransaction();
    $stmnt = "UPDATE user SET token = ? WHERE username = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$token, $who];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        $db->commit();
        return "true";
    } else {
        $db->rollBack();
        return "err:fn";
    }
}

if (isset($_POST['sudo_username']) && isset($_POST['sudo_password'])) {
    require 'db.hndlr.php';

    $who = $_POST['sudo_username'];
    $key = $_POST['sudo_password'];

    $stmnt = "SELECT * FROM user WHERE BINARY (username = ? OR email = ?) ;";
    $query = $db->prepare($stmnt);
    $param = [$who, $who];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        foreach ($query as $data) {
            $usrnm = $data['username'];
            $email = $data['email'];
            $hash = $data['passkey'];
            $token = $usrnm . '' . date('mdYHis'); // set date to time 24
            if (($who == $usrnm || $who == $email) && password_verify($key, $hash)) {
                if (SetToken($token, $usrnm) == "true") {
                    session_start();
                    $_SESSION['who'] = [$usrnm, password_hash($token, PASSWORD_DEFAULT)];
                    if (isset($_POST['sudo_remember'])) {
                        setcookie("who", $usrnm, time() + 28800, "/bucte/");
                        setcookie("token", password_hash($token, PASSWORD_DEFAULT), time() + 28800, "/bucte/");
                    }
                    echo "true";
                }
            } else {
                echo "err:1";
            }
        }
    } else {
        echo "err:0";
    }
}

if (isset($_POST['sudo_exit'])) {
    session_start();
    setcookie("who", "", time() - 28801, "/bucte/");
    setcookie("token", "", time() - 28801, "/bucte/");
    unset($_SESSION['who']);
    echo "true";
}

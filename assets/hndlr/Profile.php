<?php

if (isset($_POST['who'])) {
    require 'db.hndlr.php';
    $who = $_POST['who'];

    $stmnt = "SELECT * FROM user WHERE username = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$who];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count <= 0) {
        echo "err:";
        exit();
    } elseif ($count > 0) {
        $dbData = [];
        foreach ($query as $row) {
            $id = $row['u_id'];
            $given = $row['given_name'];
            $surname = $row['surname'];
            $username = $row['username'];
            $email = $row['email'];
            $gender = $row['gender'];
            $position = $row['position'];
            $password = $row['passkey'];
            $created_at = $row['created_at'];
            $dbData[] = ['id' => $id, 'given' => $given, 'surname' => $surname, 'username' => $username, 'email' => $email, 'position' => $position, 'gender' => $gender];
        }
        $arrObject = json_encode($dbData);
        echo $arrObject;
    }
}

if (isset($_POST['profile'])) {
    $profile = $_POST['profile'];

    if (isset($_POST['validatewho'])) {
        require 'db.hndlr.php';
        $who = $_POST['validatewho'];

        $stmnt = "SELECT * FROM user WHERE BINARY username = ?  AND NOT username = ?  ;";
        $query = $db->prepare($stmnt);
        $param = [$who, $profile];
        $query->execute($param);
        $count = $query->rowCount();
        if ($count > 0) {
            echo "not available";
        } else {
            echo "available";
        }
    }

    if (isset($_POST['validateemail'])) {
        require 'db.hndlr.php';
        $who = $_POST['validateemail'];

        $stmnt = "SELECT * FROM user WHERE BINARY email = ?  AND NOT username = ? ;";
        $query = $db->prepare($stmnt);
        $param = [$who, $profile];
        $query->execute($param);
        $count = $query->rowCount();
        if ($count > 0) {
            echo "not available";
        } else {
            echo "available";
        }
    }
}

/* Update user profile */
if (isset($_POST['user_profile'])) {
    require 'db.hndlr.php';

    $id = $_POST['user_profile'];
    $given = $_POST['given'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $db->beginTransaction();
    $stmnt = "UPDATE user SET given_name = ?, surname = ?, username = ?, email = ? WHERE u_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$given, $surname, $username, $email, $id];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        $db->commit();
        echo "true";
    } else {
        $db->rollBack();
        echo "err:update";
    }
}

/* Change password */
if (isset($_POST['user_profile2'])) {
    require 'db.hndlr.php';

    $id = $_POST['user_profile2'];
    $current = $_POST['current'];
    $confirmed = $_POST['confirmed'];
    $newpasssword = password_hash($confirmed, PASSWORD_DEFAULT);

    $stmnt = "SELECT passkey FROM user WHERE u_id = ? ;";
    $query = $db->prepare($stmnt);
    $param = [$id];
    $query->execute($param);
    $count = $query->rowCount();
    if ($count > 0) {
        foreach ($query as $data) {
            $hash = $data['passkey'];
            if (password_verify($current, $hash)) {

                $db->beginTransaction();
                $stmnt = "UPDATE user SET passkey = ? WHERE u_id = ? ;";
                $query = $db->prepare($stmnt);
                $param = [$newpasssword, $id];
                $query->execute($param);
                $count = $query->rowCount();
                if ($count > 0) {
                    $db->commit();
                    echo "true";
                } else {
                    $db->rollBack();
                    echo "err:update";
                }
            } else {
                echo "err:incorrect";
            }
        }
    }
}

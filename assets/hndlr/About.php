<?php
if(isset($_POST['save_changes'])){
    require 'db.hndlr.php';
    require 'DataValidator.php';

    $posts = ['u_id', 'content', 'alias'];
    //Check Content if data exists
    $stmntGetContent = "SELECT * FROM content where content.alias = ? ORDER BY updated_at DESC LIMIT 1";
    $alias = [$_POST['alias']];
    $queryContent = $db->prepare($stmntGetContent);
    $queryContent->execute($alias);
    $contentData = $queryContent ->fetch(PDO::FETCH_ASSOC);
    $countContent = $queryContent->rowCount();
    //print_r($contentData);
    //Content Function Calls
    $data = filterExistIndex($posts);
    //var_dump($data); //test
    $table = "content";
    $condition = "c_id= :c_id"; //substitute for Where Condition if UPDATE SCRIPT
    $additionalData = array(":c_id" => $contentData["c_id"] ) ; //equevalent of the Where Condition in UPDATE (!should be in array)
    
    $existValues = getExistValues(INSERT,$data, OPTIONAL);
    $sqlStatement = getSQLStatement(INSERT, $data, CONTENT, $condition);
    
    $existValuesU = getExistValues(UPDATE, $data, $additionalData);
    $sqlStatementU = getSQLStatement(UPDATE, $data, CONTENT, $condition);
    
     if($countContent > 0){
        $db->beginTransaction();
        try {
            $query = $db->prepare($sqlStatementU);
            $query->execute($existValuesU);
            $count = $query->rowCount();
            if($count) $db->commit();
            echo "true";
        } catch (\Throwable $th) {
            $db->rollback();
            echo "Err: $th";
        }
    }else{
        $db->beginTransaction();
        try {
            $query = $db->prepare($sqlStatement);
            $query->execute($existValues);
            $count = $query->rowCount();
            if($count) $db->commit();
            echo "true";
        } catch (\Throwable $th) {
            $db->rollback();
            echo "Err: $th";
        }  
     }
}


<?php

require_once '../Classified/dbCred.php';

function getDB() {

    $data = getCred();

    $dsn = "mysql:host={$data[0]};dbname={$data[3]};charset=utf8";  // Removed extra space after semicolons

    try {
        $db_conn = new PDO($dsn, $data[1], $data[2]);
        $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db_conn;
    } catch (PDOException $e) {
        // Capture the error message
        return "Connection failed: " . $e->getMessage();
    }
}

function getAll($dbObj) {
    $sql = "
    SELECT u.*, s.type AS school
    FROM users u
    JOIN schools s ON u.school_id = s.school_id
    ";            
    $stmt = $dbObj->prepare($sql);
    
    $stmt->execute();

    $dataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $dataArray;
}

?>
<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Redirect user to login page
    header("location: login.php");
    exit;
}

// Check if user ID is provided in the URL
if (!isset($_GET["id"])) {
    // Redirect user to login page if user ID is not provided
    header("location: login.php");
    exit;
}

$userId = $_GET["id"];

if(isset($_POST['create'])){

    require_once("../Back_End/dbConnection.php");
    $dbObj = getDB(); 

    $target_dir1 = 'images/';
    $fileName1 = basename($_FILES['photo']['name']);
    $targetPath1 = $target_dir1 . $fileName1;

    if(!is_dir($target_dir1)){
        echo "Error1: Destination directory does not exist or is not writable.";
    } else{
        if(move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPath1)) {
            // File uploaded successfully
            echo '    console.log("Waiting for 5 seconds on the Photo...");';
            echo '    setTimeout(function() {';
            echo '        console.log("This is printed after a 5-second delay.");';
            echo '    }, 5000);'; 
        } else {
            echo "Failed to move uploaded file1.";
        }
    }

    $about = $_POST['about'];
    $date = $_POST['date'];

    $target_dir2 = 'CVfiles/';
    $fileName2 = basename($_FILES['file']['name']);
    $targetPath2 = $target_dir2 . $fileName2;

    if(!is_dir($target_dir2)){
        echo "Error2: Destination directory does not exist or is not writable.";
    } else{
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath2)) {
            // File uploaded successfully
            echo '    console.log("Waiting for 5 seconds on the CV...");';
            echo '    setTimeout(function() {';
            echo '        console.log("This is printed after a 5-second delay.");';
            echo '    }, 5000);';       
        } else {
            echo "Failed to move uploaded file2.";
        }
    }


    $sql2 = "UPDATE users SET photo = :photo, pdf = :pdf, about = :about, 
    date = :date WHERE id = :userId";
    $stmt = $dbObj->prepare($sql2);
    $stmt->execute(array(
    ':photo' => $targetPath1,
    ':pdf' => $targetPath2,
    ':about' => $about,
    ':date' => $date,
    ':userId' => $userId
    ));

    if ($stmt !== false) {
       // echo "Data updated successfully.<br>";
    header('location: ../index.html');
    exit;
    } else {
    //echo "Error: " . $stmt->errorInfo()[2];
    echo "Error updating data.<br>";
    }
}


?>
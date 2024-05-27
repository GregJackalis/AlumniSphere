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

if (isset($_POST['create'])) {

    require_once("../Back_End/dbConnection.php");
    $dbObj = getDB();

    // Handle photo upload
    $target_dir1 = 'images/';
    $fileName1 = basename($_FILES['photo']['name']);
    $fileExt1 = pathinfo($fileName1, PATHINFO_EXTENSION);
    $newFileName1 = uniqid() . '.' . $fileExt1;
    $targetPath1 = $target_dir1 . $newFileName1;

    if (!is_dir($target_dir1)) {
        mkdir($target_dir1, 0777, true);
    }

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPath1)) {
        // File uploaded successfully
    } else {
        echo "Failed to move uploaded photo file.";
        exit;
    }

    // Handle CV upload
    $about = $_POST['about'];
    $date = $_POST['date'];

    $target_dir2 = 'CVfiles/';
    $fileName2 = basename($_FILES['file']['name']);
    $fileExt2 = pathinfo($fileName2, PATHINFO_EXTENSION);
    $newFileName2 = uniqid() . '.' . $fileExt2;
    $targetPath2 = $target_dir2 . $newFileName2;

    if (!is_dir($target_dir2)) {
        mkdir($target_dir2, 0777, true);
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath2)) {
        // File uploaded successfully
    } else {
        echo "Failed to move uploaded CV file.";
        exit;
    }

    // Update database with new file paths
    $sql2 = "UPDATE users SET photo = :photo, pdf = :pdf, about = :about, date = :date WHERE id = :userId";
    $stmt = $dbObj->prepare($sql2);
    $stmt->execute(array(
        ':photo' => $targetPath1,
        ':pdf' => $targetPath2,
        ':about' => $about,
        ':date' => $date,
        ':userId' => $userId
    ));

    if ($stmt !== false) {
        header('location: ../index.php');
        exit;
    } else {
        echo "Error updating data.<br>";
    }
}

?>

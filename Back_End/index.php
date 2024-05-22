<?php
declare(strict_types=1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'dbConnection.php';

// Get database connection
$db_conn = getDB();

$request_method = $_SERVER['REQUEST_METHOD'];

$data = json_decode(file_get_contents('php://input'), true);

$response = array(
    "status" => "hello",
    "message" => 'message'
);

if ($request_method === 'POST' && $db_conn !== null) {
    if (isset($data['type'])) {
        if ($data['type'] === 'card') {
            // Assuming getAll() retrieves data from the database
            $data = getAll($db_conn);

            if ($data !== null) {
                $response["status"] = "success";
                $response["message"] = $data;
            } else {
                $response["status"] = "failed";
                $response["message"] = "Error with getAll query";
            }
        } else {
            $response["status"] = "failed";
            $response["message"] = "Unknown type: " . $data['type'];
        }
    } else {
        $response["status"] = "failed";
        $response["message"] = "Type parameter missing";
    }
} elseif ($db_conn === null) {
    $response["status"] = "failed";
    $response["message"] = "Couldn't connect to the database";
}

header("Content-type: application/json; charset=UTF-8");
echo json_encode($response);
exit;
?>

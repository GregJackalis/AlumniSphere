<?php
// Database configuration (similar to your existing code)
$servername = "localhost";
$username = "alumniAdmin";
$password = "Iamtheadmin20";
$dbname = "AlumniSphere";

// Check if student_id and school_id are set and not empty
if(isset($_POST['student_id']) && !empty($_POST['student_id']) && isset($_POST['school_id']) && !empty($_POST['school_id'])) {
    // Sanitize the input to prevent SQL injection
    $student_id = $_POST['student_id'];
    $school_id = $_POST['school_id'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Construct the DELETE query
    $sql = "DELETE FROM users WHERE id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);

    // Execute the query
    if ($stmt->execute()) {
        // Success message
        echo "<script>alert('Student deleted successfully.')</script>";
    } else {
        // Error message
        echo "Error deleting student: " . $conn->error;
    }

    // Close the statement
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Redirect back to displaySchool.php with school_id parameter
    header("Location: displaySchool.php?school_id=$school_id");
    exit(); // Ensure that subsequent code is not executed after redirection
} else {
    // Error message if student_id or school_id is not provided
    echo "Student ID or School ID not provided.";
}
?>

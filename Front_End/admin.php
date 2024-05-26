<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - Schools</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <div class="header">
        <div class="logo">AlumniSphere-Admin</div>
        <button class="btn btn-primary inspect-btn">Logout</button>
    </div>
    
    <?php
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Database configuration
    $servername = "localhost";
    $username = "alumniAdmin";
    $password = "Iamtheadmin20";
    $dbname = "AlumniSphere";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from the database
    $sql = "
    SELECT s.school_id, s.type, COUNT(u.id) AS student_count
    FROM schools s
    LEFT JOIN users u ON s.school_id = u.school_id
    GROUP BY s.school_id, s.type";


    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $schools = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $schools[] = $row;
        }
    } else {
        echo "No schools found.";
    }
    $conn->close();
    ?>

    <div class="container py-5">
        <h1 class="text-center">Admin - Schools</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 py-5">
            <?php if (!empty($schools)): ?>
                <?php foreach ($schools as $school): ?>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($school['type']); ?></h5>
                                <p class="card-text">School ID: <?php echo htmlspecialchars($school['school_id']); ?></p>
                                <p class="card-text">Number of Students: <?php echo htmlspecialchars($school['student_count']); ?></p>
                                <button onclick="location.href='displaySchool.php?school_id=<?php echo htmlspecialchars($school['school_id']); ?>'" class="btn btn-primary inspect-btn">Inspect</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No schools available.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

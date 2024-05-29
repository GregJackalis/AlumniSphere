<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="displaySchool.css">
    
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Display School</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">AlumniSphere-Admin</div>
        <button class="btn btn-primary inspect-btn" style="margin-left:auto;margin-right:5px;" onclick="window.location.href = './admin.php'">Back</button>
        <a href="../Back_End/logout.php"><button class="btn btn-primary inspect-btn">Logout</button></a>
    </div>

    <?php
    // Database configuration (similar to your existing code)
    $servername = "localhost";
    $username = "alumniAdmin";
    $password = "Iamtheadmin20";
    $dbname = "AlumniSphere";

    // Check if the school ID is provided in the URL
    if(isset($_GET['school_id'])) {
        $school_id = $_GET['school_id'];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Construct the SQL query to fetch students of the specific school
        $sql = "SELECT id, name, surname, email, about, photo, pdf FROM users WHERE school_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $school_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Get the base URL to prepend to the image paths
        // $base_url = rtrim(dirname($_SERVER['PHP_SELF']), '/') . '/';
        // $base_url = str_replace('/Front_End/', '/', $base_url);
        $base_url = "";
        
        // Display student information
        while ($row = $result->fetch_assoc()) {
            // Determine which image to display
            // $photo_url = !empty($row['photo']) ? $base_url . htmlspecialchars($row['photo']) : 'images/default.png';

            $photo_path = !empty($row['photo']) ? $base_url . htmlspecialchars($row['photo']) : 'images/default.png';



            if (!empty($row['photo']) && file_exists($base_url . $row['photo'])) {
                $photo_url = $base_url . htmlspecialchars($row['photo']);
            } else {
                $photo_url = 'images/default.png';
            }

            

    
            // Output student information as HTML
            echo "<div class='student-info'>";
            echo "<img src='" . $photo_url . "' class='student-photo' alt='Student Photo'>";
            echo "<p class='student-name'>" . htmlspecialchars($row['name']) . " " . htmlspecialchars($row['surname']) . "</p>";
            echo "<p class='student-detail'>ID: " . htmlspecialchars($row['id']) . "</p>";
            echo "<p class='student-detail'>Email: " . htmlspecialchars($row['email']) . "</p><br>";
    
            // Display the 'About' section only if 'about' is not null
            if(!empty($row['about'])) {
                echo "<p class='student-detail'>About: " . htmlspecialchars($row['about']) . "</p>";
            }

            // echo "console.log(" . $row['pdf'] . ")";
    
            if (file_exists($row['pdf'])) {
                // If the file exists, display the button
                echo "<a href='#' onclick=\"window.open('" . $row['pdf'] . "', '_blank');\" class='btn btn-primary'>See CV</a>";
            } else {
                // If the file doesn't exist, display an alert
                // echo "<script>alert('File does not exist');</script>";
                echo "<a class='btn btn-primary'>No CV was Found</a>";

            }

            // See CV button
            // echo "<a href='#' onclick=\"window.open('" . $row['pdf'] . "', '_blank');\" class='btn btn-primary'>See CV</a>";            
            // Delete button
            echo "<form action='delete.php' method='POST'>";
            echo "<input type='hidden' name='student_id' value='" . $row['id'] . "'>";
            echo "<input type='hidden' name='school_id' value='" . $school_id . "'>";
            echo "<button type='submit' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</button>";
            echo "</form>";
            echo "</div>";
        }

        // Close the statement
        $stmt->close();

        // Close the database connection
        $conn->close();
    } else {
        // Display an error message or redirect to a page where the user can select a school
        echo "School ID not provided.";
    }
    ?>


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

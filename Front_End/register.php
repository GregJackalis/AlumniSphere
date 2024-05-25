
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../Back_End/dbConnection.php");
$dbObj = getDB();

function setup_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$surnameregister = $nameregister = $emailregister = $passwordregister = $schoolregister = "";
$registration_success_msg = $registration_error_msg = "";

// Registration method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $surnameregister = setup_data($_POST["surname"]);
    $nameregister = setup_data($_POST["name"]);
    $emailregister = setup_data($_POST["email"]); 

    // Validate email
    if (empty($emailregister) || !filter_var($emailregister, FILTER_VALIDATE_EMAIL)) {
        $emailregister_err = "Email is required or invalid.";
    } else {
        $sql = "SELECT id FROM users WHERE email = :email";

        if ($stmt = $dbObj->prepare($sql)) {
            $stmt->bindParam(':email', $emailregister, PDO::PARAM_STR);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    echo "<script>alert('This email already exists')</script>";
                } else {
                    $passwordregister = setup_data($_POST["password"]);
                    $schoolregister = setup_data($_POST["school"]);
            
                    // Fetch school_id based on the school type
                    $sql = "SELECT school_id FROM schools WHERE type = :schoolregister";
                    $stmt_school = $dbObj->prepare($sql);
                    $stmt_school->bindParam(':schoolregister', $schoolregister, PDO::PARAM_STR);
                    if ($stmt_school->execute()) {
                        $result = $stmt_school->fetch(PDO::FETCH_ASSOC);
                        if ($result) {
                            $schoolID = $result['school_id'];
            
                            // Proceed with user registration
                            $sql2 = "INSERT INTO users (surname, name, email, password, school_id) VALUES 
                            (:surname, :name, :email, :password, :school_id)";
                            $stmt_user = $dbObj->prepare($sql2);
                            $stmt_user->bindParam(':surname', $surnameregister, PDO::PARAM_STR);
                            $stmt_user->bindParam(':name', $nameregister, PDO::PARAM_STR);
                            $stmt_user->bindParam(':email', $emailregister, PDO::PARAM_STR);
                            $stmt_user->bindParam(':password', $passwordregister, PDO::PARAM_STR);
                            $stmt_user->bindParam(':school_id', $schoolID, PDO::PARAM_INT);
            
                            if ($stmt_user->execute()) {
                                $registration_success_msg = "Registration successful!";
                                header("Location: login.php");

                            } else {
                                $registration_error_msg = "Something went wrong. Try again later.";
                            }
                        } else {
                            $registration_error_msg = "School type not found.";
                        }
                    } else {
                        echo "Error: " . $stmt_school->errorInfo()[2];
                    }
                }
            } else {
                echo "Something went wrong. Try again later.";
            }
        }
    }
} else {
    $registration_error_msg = "Registration failed. ";
    // header("Location: Register.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../Front_End/style.css">

</head>

<body>

    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">AlumniSphere</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <!-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Task</span>
                    </a>
                </li> -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-protection"></i>
                        <span>Auth</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="../Front_End/login.php" class="sidebar-link">Login</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../Front_End/register.php" class="sidebar-link">Register</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                        <i class="lni lni-layout"></i>
                        <span>Type of School</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Arts & Design</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Business</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Computing</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Education</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Engineering</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Health & Sport Sciences</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Psychology</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Shipping</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Tourism & Hospitality</a>
                        </li>
                    </ul>
                </li>

                <!-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Setting</span>
                    </a>
                </li> -->
            </ul>
        </aside>

        <!-- Register -->
        <div class="register w-100 mx-auto" style="max-width: 500px; height: 910px; padding-top: 80px;">
        <h1 class="text-center p-4">Register</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group mb-4">
                <input type="text" placeholder="Surname" name="surname" class="form-control" value="<?php echo htmlspecialchars($surnameregister); ?>" required>
            </div>
            <div class="form-group mb-4">
                <input type="text" placeholder="Name" name="name" class="form-control" value="<?php echo htmlspecialchars($nameregister); ?>" required>
            </div>
            <div class="form-group mb-4">
                <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo htmlspecialchars($emailregister); ?>"required>            
            </div>
            <div class="form-group mb-4">
                <input type="password" placeholder="Password" name="password" minlength="6" class="form-control" value="<?php echo htmlspecialchars($passwordregister); ?>" required> 
            </div>
            <div class="form-group mb-4">
                <label for="dropdown" class="mb-1">Select a school:</label>
                <select id="dropdown" name="school" class="form-control" style="border-radius: 0.375rem; padding: 0.375rem;" required>
                    <option value="Arts and Design">School of Arts & Design</option>
                    <option value="Shipping">School of Shipping</option>
                    <option value="Business">School of Business</option>
                    <option value="Tourism and Hospitality">School of Tourism & Hospitality</option>
                    <option value="Health and Sport Sciences">School of Health & Sport Sciences</option>
                    <option value="Computing">School of Computing</option>
                    <option value="Psychology">School of Psychology</option>
                    <option value="Education">School of Education</option>
                    <option value="Engineering">School of Engineering</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <input type="submit" class="btn btn-primary" name="register" value="Submit">
            </div>
        </form>
    </div>
    

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="../Front_End/script.js"></script>
    <script src="../Front_End/getData.js"></script>
    <script src = "../Front_End/uploadCV.js"></script>
</body>

</html>
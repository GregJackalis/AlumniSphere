
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once("../Back_End/dbConnection.php");
$dbObj = getDB();

function setup_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$emaillogin = $passwordlogin = $login_error_msg = "";

// Login method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {   
    $emaillogin = setup_data($_POST["email"]); 
    $passwordlogin = setup_data($_POST["password"]); 

    $sql = "SELECT id, email, password FROM users WHERE email = :emaillogin";

    if ($stmt = $dbObj->prepare($sql)) {
        $stmt->bindParam(':emaillogin', $emaillogin, PDO::PARAM_STR);

        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id = $row['id'];
                $email = $row['email'];
                $password = $row['password'];

                if ($passwordlogin == $password) {
                    // Password is correct, start a new session
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["email"] = $email;

                    // Redirect to welcome page or dashboard
                  // header("Location: ./uploadCV.php?id=$id");
                    header("Location: ./uploadCV.php");
                    exit();
                } else {
                    // Password is not valid
                    $login_error_msg = "Invalid email or password.";
                }
            } else {
                // Email doesn't exist
                $login_error_msg = "Invalid email or password.";
            }
        } else {
            // Debugging: Check SQL error
            $errorInfo = $stmt->errorInfo();
            $login_error_msg = "Something went wrong. Please try again later. Error: " . $errorInfo[2];
        }
    } else {
        // Debugging: Check statement preparation error
        $errorInfo = $dbObj->errorInfo();
        $login_error_msg = "Statement preparation failed. Error: " . $errorInfo[2];
    }
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

        <!-- Login -->
        <div class="register w-100 mx-auto" style="max-width: 500px; height: 910px; padding-top: 80px;">
        <h1 class="text-center p-4">Login</h1>

        <?php 
            if (!empty($login_error_msg)) {
                echo '<div class="alert alert-danger">' . $login_error_msg . '</div>';
            }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group mb-4">
                <input type="email" placeholder="Email" name="email" class="form-control" value="<?php echo htmlspecialchars($emaillogin); ?>"required>            
            </div>
            <div class="form-group mb-4">
                <input type="password" placeholder="Password" name="password" minlength="6" class="form-control" value="<?php echo htmlspecialchars($passwordlogin); ?>" required> 
            </div>
            <div class="form-group mb-4">
                <input type="submit" class="btn btn-primary" name="login" value="Submit">
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
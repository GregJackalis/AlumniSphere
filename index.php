<?php
session_start();

if (isset($_SESSION["loggedin"])) {
    if ($_SESSION["loggedin"] == true) {
        
        $html = '<li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="lni lni-popup"></i>
                <span>Upload your CV</span>
            </a>
        </li>';

        // JavaScript code to append the HTML to the element with class 'sidebar-nav'
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    var sidebarNav = document.querySelector(".sidebar-nav");
                    if (sidebarNav) {
                        sidebarNav.innerHTML += `' . $html . '`;
                    }
                });
            </script>';


        echo  '<script>
        // Call the removeDisplayBtnClass function if the user is signed in
        document.addEventListener("DOMContentLoaded", function() {
            setLoggedIn();
        });
        </script>';
       
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlumniSphere</title>
    <link rel="shortcut icon" href="./Front_End/images/logo.png" type="image/x-icon">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="Front_End/style.css">
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
                <!-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Profile</span>
                    </a>
                </li> -->
                <!-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Task</span>
                    </a>
                </li> -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-protection"></i>
                        <span>Auth</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="./Front_End/login.php" class="sidebar-link">Login</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="./Front_End/register.php" class="sidebar-link">Register</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                        <i class="lni lni-layout"></i>
                        <span>Type of School</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="artsBtn">Arts & Design</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="businessBtn">Business</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="computingBtn">Computing</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="educationBtn">Education</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="engineeringBtn">Engineering</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="healthSportBtn">Health & Sport Sciences</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="psychologyBtn">Psychology</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="shippingBtn">Shipping</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="tourismBtn">Tourism & Hospitality</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" id="showAllBtn">Show All</a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Upload your CV</span>
                    </a>
                </li> -->

                <!-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Setting</span>
                    </a>
                </li> -->
            </ul>
            <div class="sidebar-footer">
                <a href="./Back_End/logout.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>


        <div class="container py-5" id="card-container">
            <h1 class="text-center">Find your Alumnis</h1>
            
    
            <!-- <div class="row row-cols-1 row-cols-md-3 g-4 py-5" id="card-area">
    
                <!-- PERSON 1 
                <div class="col">
                    <div class="card">
                        <img src="./Front_End/images/person1.jpeg" class="card-img-top" alt="Profile Picture">
                        <div class="card-body">
                            <h5 class="card-title">Papadopoulou Athina</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                          </div>
                        <div class="d-flex justify-content-end pe-3 pb-3">
                            <button class="btn btn-primary">See CV</button>
                        </div>
                    </div>
                </div>
    
            </div> -->
        </div>
    </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="Front_End/script.js"></script>
    <script src="./Front_End/getData.js"></script>
    <!-- <script src="showBtns.js"></script> -->
</body>

</html>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>uploadCV</title>
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
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-protection"></i>
                        <span>Auth</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
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
            <div class="sidebar-footer">
                <a href="../Back_End/logout.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Form to upload CV -->
        <div class="create-form w-100 mx-auto" style="max-width: 500px; height:910px; padding-top:80px;">
            <h1 class="text-center p-4">Upload your CV</h1>

            <form action="../Back_End/processCV.php?id=<?php echo $_SESSION["id"]; ?>" method="post" enctype="multipart/form-data">
                <div class="text-center mb-4">
                    <img id="profilePicture" src="./images/default.png" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <div class="form-field mb-4">
                    <label for="profileImage" class="form-label">Upload a new profile picture (optional):</label>
                    <input type="file" class="form-control" id="profileImage" name="photo" accept="image/*" onchange="previewImage(event)">
                </div>
                <div class="form-field mb-4">
                    <textarea id="placeIdInput" rows="4" cols="50" name="about" placeholder="About" class="form-control" autocomplete="off" required></textarea>
                </div>

                <div class="form-field">
                    <input type="hidden" name="date" value="<?php echo date("Y/m/d"); ?>">
                </div>
                <div class="form-field mb-4">
                    <label for="CVupload" class="form-label">Upload you CV:</label>
                    <input type="file" class="form-control" id="" name="file" accept=".pdf" required>
                </div>
                <div class="form-field mb-4">
                    <input type="submit" class="btn btn-primary" name="create" value="Submit">
                </div>
            </form>
        </div>      
    </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="../Front_End/script.js"></script>
    <script src="../Front_End/getData.js"></script>
    <script>src="../Front_End/uploadCV.js"</script>
</body>

</html>
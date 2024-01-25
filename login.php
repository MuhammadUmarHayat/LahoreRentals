<?php
include("conn.php"); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the owners table using a prepared statement
    $sql_owner = "SELECT id, first_name, password FROM owners WHERE email = ?";
    $stmt_owner = mysqli_prepare($conn, $sql_owner);
    mysqli_stmt_bind_param($stmt_owner, 's', $email);
    mysqli_stmt_execute($stmt_owner);
    $result_owner = mysqli_stmt_get_result($stmt_owner);

    // Query the renters table using a prepared statement
    $sql_renter = "SELECT id, first_name, password FROM renters WHERE email = ?";
    $stmt_renter = mysqli_prepare($conn, $sql_renter);
    mysqli_stmt_bind_param($stmt_renter, 's', $email);
    mysqli_stmt_execute($stmt_renter);
    $result_renter = mysqli_stmt_get_result($stmt_renter);

    if ($result_owner && mysqli_num_rows($result_owner) > 0) {
        // Match found in owners table
        $row = mysqli_fetch_assoc($result_owner);
        $role = 'Owner';
    } elseif ($result_renter && mysqli_num_rows($result_renter) > 0) {
        // Match found in renters table
        $row = mysqli_fetch_assoc($result_renter);
        $role = 'Renter';
    } else {
        // No match found
        echo "Invalid email or password. Please try again.";
        exit();
    }

    $stored_password = $row['password'];

    if (password_verify($password, $stored_password)) {
        session_start();
        $_SESSION['user_role'] = $role; // Store user role in a session variable
        $_SESSION['first_name'] = $row['first_name']; // Store the user's first name in a session variable

        // Redirect to the respective profile page
        if ($role === 'Owner') {
            header("Location: owner_profile.php");
        } elseif ($role === 'Renter') {
            header("Location: renter_profile.php");
        }
        exit();
    } else {
        echo "Invalid password. Please try again.";
    }

    mysqli_stmt_close($stmt_owner);
    mysqli_stmt_close($stmt_renter);
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lahore Rentals</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/all.min.css">
</head>
<body class="body-bg">

<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="images/lahorerentals.png" alt="" width="130" height="40">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">About</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="index.php">Property</a>
        </li>
      </ul>
      
      <div class="signup d-inline-block mx-3">
        <div class="btn-group">
          <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-regular fa-user"></i>
        </button>
        <ul class="dropdown-menu justify-content-around">
          <li><a class="dropdown-item" href="login.php">Login</a></li>
          <li><a class="dropdown-item" href="register.php">Signup</a></li>
       </ul>
      </div>
      <div class="profile-img d-inline-block">
        <!-- <img src="images/bg/vector.jpeg" alt="" class="rounded-circle" width="60px"> -->
        <?php
            session_start();
            if (isset($_SESSION['user_role'])) {
                $role = $_SESSION['user_role'];
                $first_name = $_SESSION['first_name'];
                echo "<a href='{$role}_profile.php' class='btn btn-submit'> $first_name</a>";
                echo "<a href='logout.php'><i class='fa-solid fa-right-from-bracket'></i></a></li>";
            } else {
                // echo "<li><a href='login.php'>Login</a></li>";
                // echo "<li><a href='registration.php'>Register</a></li>";
            }
            ?>
      </div>
     </div>
      
    </div>
  </div>
</nav>
</header>
  
<div class="container p-3">
  <div class="search-box m-5 p-5">
      <div class="row p-5 g-3">
        <h2 class="text-center mb-5">Sign In Your Account</h2>
        <div class="col-md-6 px-5">
          <form action="login.php" method="post"  class="form-body">
            <input type="email" name="email" class="form-control" placeholder="abc@gamil.com">
            <br>
            <input type="password" name="password" class="form-control" placeholder="*****">
            <br>
            <input type="submit" value="Sign In" class="submit-btn btn">
            <br>
            <br>
            <a href="" data-bs-toggle="modal" data-bs-target="#forgot"><p>Forget Your Password?</p></a>
            </form>
          </div>
        <div class="col-md-6 text-center">
           <h4>Don't have an Account</h4>
           <p class="text-justify p-3">Add items to your wishlist get personalized recommendations check out more quickly track your orders register</p>
           <br>
           <a href="register.php" class="btn link-btn">Register Here?</a>
           <a href="" class="btn link-btn" data-bs-toggle="modal" data-bs-target="#admin">Admin Login</a>
        </div>
      </div>
  </div>
</div>

<div class="modal fade" id="admin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Admin Panel Login</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="admin_login.php" method="post">
          <div class="mb-3">
            <label for="text" class="col-form-label">Username:</label>
            <input type="text" name="username" class="form-control" placeholder="abc@gamil.com">
          </div>
          <div class="mb-3">
            <label for="password" class="col-form-label">Password:</label>
            <input type="password" name="password" class="form-control" placeholder="*****">
          </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Login</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="forgot" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Forgot Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="forgot.php" method="post">
          <div class="mb-3">
            <label for="email" class="col-form-label">Email:</label>
            <input type="email" name="email" class="form-control" placeholder="abc@gamil.com">
          </div>
          <div class="mb-3">
            <label for="new_password" class="col-form-label">New Password:</label>
            <input type="password" name="new_password" class="form-control" placeholder="*****">
          </div>
          <input type="hidden" name="role" value="Owner">
          <input type="hidden" name="role" value="Renter">
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Reset Password</button>
      </div>
      </form>
    </div>
  </div>
</div>

<footer class="p-3 bg-dark">
  <div class="container">
   <div class="row">
    <div class="col-md-6">
    <img src="images/lahorerentals.png" alt="" width="130" height="40">
    </div>
    <div class="col-md-6">
    <p class="text-white text-end">© Copyright 2023 All Rights Reserved</p>
    </div>
   </div>
  </div>
</footer>    

    <script src="vendor/font-awesome/js/all.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

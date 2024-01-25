<?php
include ("conn.php"); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $choice = $_POST['choice'];

    // Insert user data into the appropriate table based on the choice
    if ($choice === 'Owner') {
        $sql = "INSERT INTO owners (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";
        $welcome_msg = "Welcome Owner, $first_name!";
        $profile_page = "owner_profile.php";
    } elseif ($choice === 'Renter') {
        $sql = "INSERT INTO renters (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";
        $welcome_msg = "Welcome Renter, $first_name!";
        $profile_page = "renter_profile.php";
    }

    if (mysqli_query($conn, $sql)) {
      session_start();
      $_SESSION['user_role'] = $choice; // Store user role in a session variable
      $_SESSION['first_name'] = $first_name; // Store the user's first name in a session variable
      header("Location: $profile_page"); // Redirect to the respective profile page
      exit();
  } else {
      echo "Error: " . mysqli_error($conn);
  }
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
    <form action="register.php" method="post" enctype="multipart/form-data">
      <div class="row p-5 g-3 form-body">
        <h2 class="text-center mb-5">Register Yourself</h2>
        <div class="col-md-6 p-2">
            <input type="text" name="first name" class="form-control" placeholder="First Name">
        </div>
        <div class="col-md-6 p-2">
            <input type="text" name="last name" class="form-control" placeholder="Last Name">
        </div>
        <div class="col-md-6 p-2">
            <input type="email" name="email" class="form-control" placeholder="abc@gamil.com">
        </div>
        <div class="col-md-6 p-2">
            <input type="password" name="password" class="form-control" placeholder="*****">
        </div>
        <div class="col-md-4 p-2">
            <p class="px-2">Are you a?</p>
            <input type="radio" name="choice" value="Owner" class="mx-2">
            <label for="Owner">Owner</label>
            <input type="radio" name="choice" value="Renter" class="mx-2">
            <label for="Renter">Renter</label>
        </div>
        <div class="col-md-4 p-2 text-center mt-4">
          <input type="submit" value="Register" class="submit-btn btn">
        </div>
        <div class="col-md-4 p-2 text-end mt-3">
            <br>
          <a href="login.php"><p>Already Have an Account?</p></a>
          </div>
      </div>
    
    </form>
  </div>
</div>




    
    <script src="vendor/font-awesome/js/all.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
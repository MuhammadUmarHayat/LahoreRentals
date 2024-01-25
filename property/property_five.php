<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lahore Rentals</title>
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../vendor/font-awesome/css/all.min.css">
</head>
<body class="body-bg">

<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="../images/lahorerentals.png" alt="" width="130" height="40">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../index.php">About</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="../index.php">Property</a>
        </li>
      </ul>
      
      <div class="signup d-inline-block mx-3">
        <div class="btn-group">
          <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa-regular fa-user"></i>
        </button>
        <ul class="dropdown-menu justify-content-around">
          <li><a class="dropdown-item" href="../login.php">Login</a></li>
          <li><a class="dropdown-item" href="../register.php">Signup</a></li>
       </ul>
      </div>
      <div class="profile-img d-inline-block">
        <?php
        session_start();
        if (isset($_SESSION['user_role'])) {
            $role = $_SESSION['user_role'];
            $first_name = $_SESSION['first_name'];
            echo "<a href='../{$role}_profile.php' class='btn btn-submit'> $first_name</a>";
            echo "<a href='../logout.php'><i class='fa-solid fa-right-from-bracket'></i></a></li>";
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
  
<div class="container pt-5 pb-5">
  <div class="row g-4">
    <div class="col-md-8 fw-bold">
      <h2>Full House</h2>
    </div>
    <div class="col-md-4">
      <h3 class="text-muted">Rent/Month: 45,000 RS</h3>
    </div>
    <br>
    <div class="col-md-6 text-center">
      <img src="../images/bg/apartment-single-2.jpeg" alt="" width="100%" class="img-fluid rounded-3">
    </div>
    <div class="col-md-6">
      <div class="setting-tabs">
        <h4>Property Details</h4>
        <p><b>Address & Area :</b>  House-38, Model Town, Lahore Pakistan</p>
        <p><b>House Size :</b> 3000 Sq Feet.</p>
        <p><b>Room Category :</b> 4 Large Bed Rooms with 2 Verandas, Spacious Drawing, Dining & Family Living Room, Highly Decorated Kitchen with Store Room and Servant room with attached Toilet.</p>
        <p><b>Facilities :</b> 1 Modern Lift, All Modern Amenities & Semi Furnished.</p>
        <p><b>Additional Facilities :</b> a. Electricity with full generator load, b. Central Gas Geyser, c. 2 Car Parking with 1 Driver’s Accommodation, d. Community Conference Hall, e. Roof Top Beautified Garden and Grassy Ground, f. Cloth Hanging facility with CC camera</p>
      </div>
    </div>
  </div>
</div>

<footer class="p-3 bg-dark">
  <div class="container">
   <div class="row">
    <div class="col-md-6">
    <img src="../images/lahorerentals.png" alt="" width="130" height="40">
    </div>
    <div class="col-md-6">
    <p class="text-white text-end">© Copyright 2023 All Rights Reserved</p>
    </div>
   </div>
  </div>
</footer>
   
    <script src="../vendor/font-awesome/js/all.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
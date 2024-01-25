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
<body>

    
  <?php
  include("conn.php"); // Include the database connection file
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];
      $password = $_POST['password'];
  
      // Query the owners table
      $sql_owner = "SELECT id, first_name, password FROM owners WHERE email = '$email'";
      $result_owner = mysqli_query($conn, $sql_owner);
  
      // Query the renters table
      $sql_renter = "SELECT id, first_name, password FROM renters WHERE email = '$email'";
      $result_renter = mysqli_query($conn, $sql_renter);
  
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
  }
  
  mysqli_close($conn);
  ?>
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
          <a class="nav-link active" aria-current="page" href="">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#about">About</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="#property">Property</a>
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
        
      </div>
     </div>
      
    </div>
  </div>
</nav>
<div class="row bg-header p-5">
  <div class="col-md-12 p-5 d-block justify-content-center align-content-center">
    <h5 class="text-center text-white"><i class="fa-solid fa-house-user"></i> Real Estate Agency</h5>
    <h1>All Properties</h1>
    <div class="text-center">
        <a href="mailto:sahar.tanveer77@gmail.com" type="button"><button class="button-51">Enquire Now</button></a>
    </div>
  </div>
  <!-- <div class="col-md-6">
    <img src="images/bg/21.png" alt="" class="img-fluid" >
  </div> -->
</div>
</header>
  

   


  <!-- <h2 class="text-center mt-5" id="property">Featured Listings</h2> -->

  <div class="row g-3 property-container justify-content-center p-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
          <div class="card h-100">
            <img src="images/bg/apartment-one.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Full House</h5>
              <p class="card-text"><i class="fa-solid fa-location-dot"></i> Islamabad, Pakistan</p>
            </div>
            <div class="card-footer">
                <span class="d-flex justify-content-between">
                    <p class="card-text text-muted"><i class="fa-solid fa-bed"></i> 5 Bedrooms</p>
                    <p class="card-text text-muted"><i class="fa-solid fa-bath"></i> 5 Bathrooms</p>
                </span>
                <span class="d-flex justify-content-between">
                    <small class="fw-bold">65,000 RS</small>
                    <a href="property/property_one.php">Details <i class="fa-solid fa-arrow-right"></i></a>
                </span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100">
            <img src="images/bg/apartment-two.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Apartment</h5>
              <p class="card-text"><i class="fa-solid fa-location-dot"></i> Islamabad, Pakistan</p>
            </div>
            <div class="card-footer">
                <span class="d-flex justify-content-between">
                    <p class="card-text text-muted"><i class="fa-solid fa-bed"></i> 2 Bedrooms</p>
                    <p class="card-text text-muted"><i class="fa-solid fa-bath"></i> 2 Bathrooms</p>
                </span>
                <span class="d-flex justify-content-between">
                    <small class="fw-bold">67,000 RS</small>
                    <a href="property/property_two.php">Details <i class="fa-solid fa-arrow-right"></i></a>
                </span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100">
            <img src="images/bg/apartment-one.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Full House</h5>
              <p class="card-text"><i class="fa-solid fa-location-dot"></i> Islamabad, Pakistan</p>
            </div>
            <div class="card-footer">
                <span class="d-flex justify-content-between">
                    <p class="card-text text-muted"><i class="fa-solid fa-bed"></i> 5 Bedrooms</p>
                    <p class="card-text text-muted"><i class="fa-solid fa-bath"></i> 5 Bathrooms</p>
                </span>
                <span class="d-flex justify-content-between">
                    <small class="fw-bold">100,000 RS</small>
                    <a href="property/property_three.php">Details <i class="fa-solid fa-arrow-right"></i></a>
                </span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100">
            <img src="images/bg/apartment-six.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Single Family House</h5>
              <p class="card-text"><i class="fa-solid fa-location-dot"></i> Lahore, Pakistan</p>
            </div>
            <div class="card-footer">
                <span class="d-flex justify-content-between">
                    <p class="card-text text-muted"><i class="fa-solid fa-bed"></i> 2 Bedrooms</p>
                    <p class="card-text text-muted"><i class="fa-solid fa-bath"></i> 2 Bathrooms</p>
                </span>
                <span class="d-flex justify-content-between">
                    <small class="fw-bold">40,000 RS</small>
                    <a href="property/property_four.php">Details <i class="fa-solid fa-arrow-right"></i></a>
                </span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100">
            <img src="images/bg/apartment-five.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Full House</h5>
              <p class="card-text"><i class="fa-solid fa-location-dot"></i> Lahore, Pakistan</p>
            </div>
            <div class="card-footer">
                <span class="d-flex justify-content-between">
                    <p class="card-text text-muted"><i class="fa-solid fa-bed"></i> 4 Bedrooms</p>
                    <p class="card-text text-muted"><i class="fa-solid fa-bath"></i> 3 Bathrooms</p>
                </span>
                <span class="d-flex justify-content-between">
                    <small class="fw-bold">45,000 RS</small>
                    <a href="property/property_five.php">Details <i class="fa-solid fa-arrow-right"></i></a>
                </span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-100">
            <img src="images/bg/apartment-four.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Apartment</h5>
              <p class="card-text"><i class="fa-solid fa-location-dot"></i> Karachi, Pakistan</p>
            </div>
            <div class="card-footer">
                <span class="d-flex justify-content-between">
                    <p class="card-text text-muted"><i class="fa-solid fa-bed"></i> 1 Bedrooms</p>
                    <p class="card-text text-muted"><i class="fa-solid fa-bath"></i> 1 Bathrooms</p>
                </span>
                <span class="d-flex justify-content-between">
                    <small class="fw-bold">25,000 RS</small>
                    <a href="property/property_six.php">Details <i class="fa-solid fa-arrow-right"></i></a>
                </span>
            </div>
          </div>
        </div>


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





    <script src="js/chat.js"></script>
    <script src="vendor/font-awesome/js/all.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
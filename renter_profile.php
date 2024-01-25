<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Renter') {
    // Redirect unauthorized users or handle the case when the session is not set
    header("Location: login.php"); // Redirect to the login page
    exit();
}

// Display the welcome message and the logout button
$welcome_msg = "Welcome Renter, " . $_SESSION['first_name']; // Retrieve the user's first name from the session
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

<div class="row bg-header p-5">
  <div class="col-md-12 p-4 d-block mt-5">
    <h5 class="text-center text-white"><i class="fa-solid fa-house-user"></i> Real Estate Agency</h5>
    <h1><?php echo $welcome_msg; ?></h1>
    <p class="text-center text-white">Find The Perfect Place to Live With your Family</p>
    <br>
    <div class="text-center">
      <a href="logout.php" class="btn link-btn">Logout</a>
    </div>
  </div>
</div>
</header>
<h2 class="text-center mt-5" id="property">All Properties</h2>
  <!-- <div class="card-group m-5"> -->
  <div class="row g-5 property-container justify-content-center mt-3">
  <!-- <div class="row row-cols-1 row-cols-md-3 g-4"> -->
  <!-- <div class="col-md-3">  -->

  
  <?php
include("conn.php"); // Include the database connection file
// $sql = "SELECT * FROM properties";
// Fetch property details from the database with an additional condition for approval
$sql = "SELECT * FROM properties WHERE approval_status = 'approved'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $image_url = 'uploads/' . $row['image'];
    $area = $row['area'];
    $type = $row['type'];
    $bedrooms = $row['bedrooms'];
    $bathrooms = $row['bathrooms'];
    $price = $row['price'];

    echo '<div class="col-md-3 card h-100" data-area="' . $area . '" data-type="' . $type . '">';
    echo "<img src='$image_url' alt='$area' class='card-img-top'>";
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $type . '</h5>';
    echo '<p class="card-text"><i class="fa-solid fa-location-dot"></i> ' . $area . ', Pakistan</p>';
    echo '</div>';
    echo '<div class="card-footer">';
    echo '<span class="d-flex justify-content-between">';
    echo '<p class="card-text text-muted"><i class="fa-solid fa-bed"></i> ' . $bedrooms . ' Bedrooms</p>';
    echo '<p class="card-text text-muted"><i class="fa-solid fa-bath"></i> ' . $bathrooms . ' Bathrooms</p>';
    echo '</span>';
    echo '<span class="d-flex justify-content-between">';
    // echo '<small class="fw-bold">' . number_format($price) . ' RS</small>';
    echo '<small class="fw-bold">';
    if ($row['approval_status'] == 'pending') {
        echo 'Pending for Admin Approval';
    } else {
        echo number_format($price) . ' RS';
    }
    echo '</small>';
    echo '<a href="javascript:voi(0)" class="text-muted" id="heartIcon"><i class="fa-regular fa-heart"></i></a>';
    echo '</span>';
    echo '</div>';
    echo '</div>';
}

mysqli_close($conn);
?>

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


<script src="vendor/font-awesome/js/all.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
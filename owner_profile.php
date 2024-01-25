<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Owner') {
    // Redirect unauthorized users or handle the case when the session is not set
    header("Location: login.php"); // Redirect to the login page or another appropriate page
    exit();
}

// Display the welcome message and the logout button
$welcome_msg = "Welcome Owner, " . $_SESSION['first_name']; // Retrieve the user's first name from the session
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
            // session_start();
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
<div class="row bg-header p-5 justify-content-center">
  <div class="col-md-12 p-4 d-block mt-5">
    <h5 class="text-center text-white"><i class="fa-solid fa-house-user"></i> Real Estate Agency</h5>
    <h1 class="text-center"><?php echo $welcome_msg; ?></h1>
    <p class="mb-5 text-center text-white">Let’s find the right selling option for you</p>
    <div class="text-center">
     <a href="#tabs" class="btn link-btn">Post Your AD</a>
    </div>
  </div>
  <!-- <div class="col-md-6">
    <img src="images/bg/21.png" alt="" class="img-fluid" >
  </div> -->
</div>
</header>


<section class="container mt-5" id="tabs">
  <div class="d-flex align-items-start">
    <div class="setting-tabs">
      <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Pending AD's</button>
        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Post Ad</button>
        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Update Profile</button>
      </div>
    </div>
    <div class="desc-content">
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
          <!-- Content for Post AD tab -->
          <h2 class="text-center mt-5" id="property">Featured Houses</h2>
          <div class="row g-5 property-container justify-content-center mt-3">
            <?php
              include("conn.php"); // Include the database connection file
              // $sql = "SELECT * FROM properties";
              // Fetch property details from the database with an additional condition for approval
              $sql = "SELECT * FROM properties WHERE approval_status = 'pending'";
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

        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          <!-- Content for Pending Ads tab -->
          <!-- <div class="container p-3" id="ad"> -->
    <form action="property.php" method="post" enctype="multipart/form-data">
      <div class="row p-5 g-3 form-body">
        <h2 class="text-center">Add New Property</h2>
        <p class="text-center text-muted mb-5">We are glad to see you again!</p>
        <div class="col-md-6 p-2">
          <input type="file" name="image" accept="image/*" class="form-control">
        </div>
        <div class="col-md-6 p-2">
          <input type="text" name="type" placeholder="Property Type" class="form-control" required>
        </div>
        <div class="col-md-6 p-2">
          <input type="text" name="area" placeholder="Area" class="form-control" required>
        </div>
        <div class="col-md-6 p-2">
        <input type="number" name="bedrooms" placeholder="Number of Bedrooms" class="form-control" required>
        </div>
        <div class="col-md-6 p-2">
          <input type="number" name="bathrooms" placeholder="Number of Bathrooms" class="form-control" required>
        </div>
        <div class="col-md-6 p-2">
        <input type="number" name="price" placeholder="Price" class="form-control" required>
        </div>
        <input type="hidden" name="status" value="pending">
        <div class="col-md-12 p-2 text-center mt-4">
          <input type="submit" value="Submit Property" class="btn link-btn">
        </div>
      </div>
    
    </form>
    <!-- </div> -->
  </div>

  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
  <form action="update_owner_profile.php" method="post" enctype="multipart/form-data">
    <div class="row p-5 g-3 form-body">
        <h2 class="text-center mb-5">Update Your Profile</h2>
        <div class="col-md-6 p-2">
            <input type="text" name="first_name" class="form-control" placeholder="First Name">
        </div>
        <div class="col-md-6 p-2">
            <input type="text" name="last_name" class="form-control" placeholder="Last Name">
        </div>
        <div class="col-md-6 p-2">
            <input type="email" name="email" class="form-control" placeholder="abc@gmail.com">
        </div>
        <div class="col-md-6 p-2">
            <input type="password" name="password" class="form-control" placeholder="*****">
        </div>
        <div class="col-md-12 p-2 text-center mt-4">
            <input type="submit" value="Update" class="submit-btn btn">
        </div>
    </div>
</form>

        </div>
      </div>
    </div>
  </div>
</section>

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

<?php
// Additional PHP code for sending email notifications

// Include PHPMailer autoload file
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Your existing code for property submission

    // Send email notification to all renters
    $subject = 'New Property Available for Rent';
    $message = 'A new property is available for rent. Check it out on our website.';

    // Fetch all renters' emails from the database
    $sqlRenters = "SELECT email FROM renters";
    $resultRenters = mysqli_query($conn, $sqlRenters);

    // Create a PHPMailer instance
    $mailer = new PHPMailer(true);

    try {
        while ($row = mysqli_fetch_assoc($resultRenters)) {
            $to = $row['email'];

            // Set up PHPMailer with your SMTP configurations
            $mailer->isSMTP();
            $mailer->Host = 'Brevo';  // Replace with your SMTP host
            $mailer->SMTPAuth = true;
            $mailer->Username = 'Sahar';  // Replace with your SMTP username
            $mailer->Password = 'zQ@qrUcNkP7J!aC';  // Replace with your SMTP password
            $mailer->SMTPSecure = 'tls';  // Use 'tls' or 'ssl' depending on your server configuration
            $mailer->Port = 587;  // Adjust the port number accordingly

            // Set up sender and recipient
            $mailer->setFrom('sahar.tanveer77@gmail.com', 'Lahore Rentals');  // Replace with your email and name
            $mailer->addAddress($to);

            // Set email content
            $mailer->isHTML(true);
            $mailer->Subject = $subject;
            $mailer->Body = $message;

            // Send the email
            $mailer->send();
        }

        echo 'Emails sent successfully!';
    } catch (Exception $e) {
        echo "Mailer Error: {$mailer->ErrorInfo}";
    }
}
?>

<div class="modal fade" id="property" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add a Property</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="property.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <!-- <label for="file" class="col-form-label">Insert Image:</label> -->
            <input type="file" name="image" accept="image/*" class="form-control">
          </div>
          <div class="mb-3">
            <!-- <label for="type" class="col-form-label">Property Type:</label> -->
            <input type="text" name="type" placeholder="Property Type" class="form-control" required>
          </div>
          <div class="mb-3">
            <!-- <label for="area" class="col-form-label">Area:</label> -->
            <input type="text" name="area" placeholder="Area" class="form-control" required>
          </div>
          <div class="mb-3">
            <!-- <label for="bedrooms" class="col-form-label">No of Bedrooms:</label> -->
            <input type="number" name="bedrooms" placeholder="Number of Bedrooms" class="form-control" required>
          </div>
          <div class="mb-3">
            <!-- <label for="bathrooms" class="col-form-label">No of Bathrooms:</label> -->
            <input type="number" name="bathrooms" placeholder="Number of Bathrooms" class="form-control" required>
          </div>
          <div class="mb-3">
            <!-- <label for="price" class="col-form-label">Price:</label> -->
            <input type="number" name="price" placeholder="Price" class="form-control" required>
          </div>
          <!-- Add this to your property form -->
          <input type="hidden" name="status" value="pending">

      </div>
      <div class="modal-footer">
        <input type="submit" value="Submit Property" class="btn link-btn">
      </div>
      </form>
    </div>
  </div>
</div>

<script src="vendor/font-awesome/js/all.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
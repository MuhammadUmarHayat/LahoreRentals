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

<div id="chatbox" style="display: none;">
    <div id="chatMessages"></div>
    <div id="inputContainer">
        <input type="text" id="messageInput" placeholder="Type your message">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>
<button id="chatButton" onclick="toggleChat()"><i class="fa-solid fa-comments"></i></button>

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
<div class="row bg-header p-5">
  <div class="col-md-12 p-5 d-block justify-content-center align-content-center">
    <h5 class="text-center text-white"><i class="fa-solid fa-house-user"></i> Real Estate Agency</h5>
    <h1>Find Your Dream House By Us</h1>
    <p class="text-center text-white">Find The Perfect Place to Live With your Family</p>
    <div class="text-center">
        <a href="mailto:iqrawaheed047@gmail.com" type="button"><button class="button-51">Enquire Now</button></a>
    </div>
  </div>
</div>
</header>
  
<div class="container p-3">
  <div class="search-box p-5">
    <form action="" id="searchForm">
      <div class="row">
        <div class="col-md-5 p-2">
          <select name="area" id="area" class="form-control">
            <option value="Choose Area" selected disabled>Choose Area</option>
            <option value="Lahore">Lahore</option>
            <option value="Karachi">Karachi</option>
            <option value="Islamabad">Islamabad</option>
          </select>
        </div>
        <div class="col-md-5 p-2">
          <select name="type" id="type" class="form-control">
            <option value="Property Type" selected disabled>Property Type</option>
            <option value="Apartment">Apartment</option>
            <option value="Family Apartment">Family Apartment</option>
            <option value="Single Family House">Single Family House</option>
            <option value="Family House">Family House</option>
          </select>
        </div>
        <div class="col-md-2 p-2 text-center">
          <input type="button" value="Find Now" class="submit-btn btn" onclick="searchProperties()">
        </div>
      </div>
    
    </form>
  </div>
   
   <div class="conatiner" id="about">
      <div class="row">
        <div class="col-md-6 p-3">
            <div class="text-center justify-content-end">
            <img src="images/bg/apartment-two.png" alt="" width="70%" class="about_img">
            </div>
        </div>
        <div class="col-md-6 p-4">
         <h3>About Our Company:-</h3> 
         <p class="text-black"><b>Welcome to Lahore Rentals</b>, your trusted source for renting a house, bunglow ,and appartment. We are dedicated to providing valuable information, resources to our visitors.</p>
         <h5>Our Mission:</h5>
         <p>Our mission is to provide good owners with great houses. We are committed to give you the best house.</p>
         <p>We love to hear from our readers and are open to feedback, suggestions, and collaborations. Feel free to conatct us through email or website. We look forward to connecting with you!</p>
        </div>
      </div>
   </div>


  <h2 class="text-center mt-5" id="property">Discover Our Featured Listings</h2>
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
    echo '<a href="properties.php" class="text-muted" id="heartIcon">Details <i class="fa-solid fa-arrow-right"></i></a>';
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

<script>
    function expressInterest(propertyId) {
        // You can use AJAX to send the propertyId to the server
        // and update the database to record the interest.
        // Here's a basic example using the fetch API:

        fetch('express_interest.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ propertyId: propertyId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Interest expressed successfully!');
                // You might update the UI to reflect the change in interest,
                // for example, by changing the color of the heart icon.
            } else {
                alert('Failed to express interest. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again later.');
        });
    }
</script>

<script>
  // Get the heart icon element
  var heartIcon = document.getElementById('heartIcon');

  // Add a click event listener to the heart icon
  heartIcon.addEventListener('click', function() {
    // Toggle the 'clicked' class to change the color
    heartIcon.classList.toggle('clicked');
  });
</script>

<script>
function searchProperties() {
  const area = document.getElementById("area").value;
  const type = document.getElementById("type").value;

  // Hide all property cards
  const propertyCards = document.querySelectorAll(".card");
  propertyCards.forEach(card => {
    card.style.display = "none";
    // document.write("No Available Property to Display");
  });

  // Show property cards that match the selected criteria
  const matchingCards = document.querySelectorAll(`.card[data-area="${area}"][data-type="${type}"]`);
  matchingCards.forEach(card => {
    card.style.display = "block";
  });
}
</script>

    <script src="js/chat.js"></script>
    <script src="vendor/font-awesome/js/all.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
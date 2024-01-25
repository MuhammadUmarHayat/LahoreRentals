<?php
session_start();
include("conn.php"); // Include the database connection file

// Check if an admin session is already active
// if (isset($_SESSION['admin_id'])) {
//     header("Location: admin_panel.php"); // Redirect to the admin panel
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify the admin's credentials in the database
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $admin['password'])) {
            // Authentication successful
            $_SESSION['admin_id'] = $admin['id']; // Store the admin's unique identifier
            header("Location: admin_panel.php"); // Redirect to the admin panel
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }

    mysqli_stmt_close($stmt);
}


// Query for renters
$sqlRenters = "SELECT * FROM renters";
$resultRenters = mysqli_query($conn, $sqlRenters);

// Query for owners
$sqlOwners = "SELECT * FROM owners";
$resultOwners = mysqli_query($conn, $sqlOwners);

$sqlPendingProperties = "SELECT * FROM properties";
// $sqlPendingProperties = "SELECT * FROM properties WHERE properties.approval_status = 'pending'";
$resultPendingProperties = mysqli_query($conn, $sqlPendingProperties);

mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Lahore Rentals</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/all.min.css">
</head>
<body>
    
<header class="p-3 bg-light">
  <div class="container">
   <div class="row">
    <div class="col-md-4">
    <img src="images/lahorerentals.png" alt="" width="130" height="40">
    </div>
    <div class="col-md-4">
    <h1 class="text-center">Admin Panel</h1>
    </div>
    <div class="col-md-4 text-end">
    <a href="logout.php" class="btn link-btn">Logout</a>
    </div>
   </div>
  </div>
</header>

<div class="container">
<h4 class="text-center mt-5">Renters</h4>
<table class="table table-striped justify-content-center">
    <tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Update User</th>
        <th>Delete User</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultRenters)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><a href="#" class="btn submit-btn" onclick="openUpdateModal('renter', <?php echo $row['id']; ?>)"><i class="fa-solid fa-pen-to-square"></i> Update</a></td>
            <td><a href="delete_user.php?type=renters&id=<?php echo $row['id']; ?>" class="btn submit-btn"><i class="fa-solid fa-trash"></i> Delete</a></td>
        </tr>
    <?php endwhile; ?>
</table>

<h4 class="text-center mt-5">Owners</h4>
<table class="table table-striped justify-content-center">
    <tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Update User</th>
        <th>Delete User</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultOwners)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><a href="#" class="btn submit-btn" onclick="openUpdateModal('owner', <?php echo $row['id']; ?>)"><i class="fa-solid fa-pen-to-square"></i> Update</a></td>
            <td><a href="delete_user.php?type=owners&id=<?php echo $row['id']; ?>" class="btn submit-btn"><i class="fa-solid fa-trash"></i> Delete</a></td>
        </tr>
    <?php endwhile; ?>
</table>

<h4 class="text-center mt-5">Pending Property Ads</h4>
<table class="table table-striped justify-content-center">
    <tr>
        <th>Property ID</th>
        <th>Type</th>
        <th>Area</th>
        <th>Bedrooms</th>
        <th>Bathrooms</th>
        <th>Price</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultPendingProperties)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['area']; ?></td>
            <td><?php echo $row['bedrooms']; ?></td>
            <td><?php echo $row['bathrooms']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['approval_status']; ?></td>
            <td><a href="approve_property.php?id=<?php echo $row['id']; ?>" class="btn submit-btn"><i class="fa-solid fa-check-double"></i> Approve</a></td>
            <td><a href="reject_property.php?id=<?php echo $row['id']; ?>" class="btn submit-btn"><i class="fa-solid fa-ban"></i> Reject</a></td>
            <td><a href="delete_property.php?id=<?php echo $row['id']; ?>" class="btn submit-btn"><i class="fa-solid fa-trash"></i> Delete</a></td>
        </tr>
    <?php endwhile; ?>

   </table>
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

<div class="modal" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update User Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="update_user.php" method="post">
               <input type="hidden" name="type" id="type" value="">
               <input type="hidden" name="id" id="id" value="">
               <div class="mb-3">
                 <label for="first_name" class="col-form-label">First Name:</label>
                 <input type="text" name="first_name" id="first_name" class="form-control" value="" required>
               </div>
               <div class="mb-3">
                 <label for="last_name" class="col-form-label">Last Name:</label>
                 <input type="text" name="last_name" id="last_name" class="form-control" value="" required>
              </div>
              <div class="mb-3">
                <label for="email" class="col-form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="" required>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update</button>
              </div>
           </form>
        </div>
    </div>
</div>

<script>
    function openUpdateModal(type, id) {
        document.getElementById('type').value = type;
        document.getElementById('id').value = id;
        document.getElementById('update').style.display = 'block';
    }
</script>

    <script src="vendor/font-awesome/js/all.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve property details from the form
    $type = $_POST['type'];
    $area = $_POST['area'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $price = $_POST['price'];

    // Handle image upload
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmp = $image['tmp_name'];
    $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
    $new_image_name = uniqid() . '.' . $image_extension;

    // Move uploaded file to the 'uploads' directory
    if (move_uploaded_file($image_tmp, 'uploads/' . $new_image_name)) {
        // Set the status to 'pending' by default
        $status = 'pending';
        $approvalStatus = 'pending';

        // Insert property details into the database
        $sql = "INSERT INTO properties (type, area, bedrooms, bathrooms, price, image, status, approval_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ssssssss", $type, $area, $bedrooms, $bathrooms, $price, $new_image_name, $status, $approvalStatus);
        if (mysqli_stmt_execute($stmt)) {
            // Property submitted successfully.
            header("Location: owner_profile.php"); // Redirect to the respective profile page
            exit();
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error moving the uploaded file.";
    }
}

mysqli_close($conn);
?>

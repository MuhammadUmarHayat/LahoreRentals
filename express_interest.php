<?php
// express_interest.php

// Include your database connection code
include("conn.php");

// Retrieve the property ID from the AJAX request
$propertyId = isset($_POST['propertyId']) ? $_POST['propertyId'] : null;

if ($propertyId) {
    // Update the database to record the interest
    $sql = "INSERT INTO property_interests (property_id, renter_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Assuming you have a renter ID stored in the session
    $renterId = $_SESSION['renter_id'];

    mysqli_stmt_bind_param($stmt, "ii", $propertyId, $renterId);

    if (mysqli_stmt_execute($stmt)) {
        $response = ['success' => true];
    } else {
        $response = ['success' => false];
    }

    mysqli_stmt_close($stmt);
} else {
    $response = ['success' => false];
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

mysqli_close($conn);
?>

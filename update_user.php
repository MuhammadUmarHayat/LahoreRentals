<?php
echo "Reached here 1";
session_start();
include("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Reached here 2";

    // Handle the form submission to update user information
    $type = $_POST['type'];
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    
    // Construct SQL query based on the fields that have values
    $sql = "UPDATE $type SET";
    $updates = array();

    if (!empty($first_name)) {
        $updates[] = "first_name = '$first_name'";
    }
    if (!empty($last_name)) {
        $updates[] = "last_name = '$last_name'";
    }
    if (!empty($email)) {
        $updates[] = "email = '$email'";
    }

    $sql .= implode(", ", $updates);
    $sql .= " WHERE id = $id";
    // Debugging: Output received data
    echo "Type: $type, ID: $id, First Name: $first_name, Last Name: $last_name, Email: $email";

    // Perform the update based on the user type (renter or owner)
    if ($type === 'renter') {
        $sql = "UPDATE renters SET first_name=?, last_name=?, email=? WHERE id=?";
    } elseif ($type === 'owner') {
        $sql = "UPDATE owners SET first_name=?, last_name=?, email=? WHERE id=?";
    }

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo "Prepare failed: " . mysqli_error($conn);
    } else {
        echo "Reached here 3";
        mysqli_stmt_bind_param($stmt, "sssi", $first_name, $last_name, $email, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Update successful!";
        } else {
            echo "Execute failed: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
} else {
    echo "No post data received.";
}

// Redirect back to the admin panel
header("Location: admin_panel.php");
exit();
?>

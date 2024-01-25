<?php
// Include the database connection file
include("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $role = $_POST['role']; // Added hidden input for user's role

    // Determine the table name based on the user's role
    $table_name = ($role === 'Owners') ? 'owners' : 'renters';

    // Check if the email exists in the appropriate database table
    $sql = "SELECT id FROM $table_name WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Update the user's password in the appropriate database table
        $update_sql = "UPDATE $table_name SET password = '$new_password' WHERE email = '$email'";
        if (mysqli_query($conn, $update_sql)) {
            // echo "Password updated successfully. You can now login with your new password.";
            header("Location: login.php");
        } else {
            echo "Error updating password: " . mysqli_error($conn);
        }
    } else {
        echo "Email not found in the database. Please check your email address.";
    }
}

mysqli_close($conn);
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['type'];
    $id = $_GET['id'];

    // Validate type to prevent SQL injection
    if ($type === 'renters' || $type === 'owners') {
        // Perform the delete based on the user type
        $sql = "DELETE FROM $type WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                echo "User deleted successfully!";
            } else {
                echo "Error executing delete query: " . mysqli_error($conn);
            }            

            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing delete statement: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid user type.";
    }
} else {
    echo "Invalid request method.";
}

// Redirect back to the admin panel
header("Location: admin_panel.php");
exit();
?>

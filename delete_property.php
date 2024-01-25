<?php
include("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $propertyId = $_GET['id'];

    $deleteSql = "DELETE FROM properties WHERE id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteSql);
    mysqli_stmt_bind_param($deleteStmt, "i", $propertyId);
    
    if (mysqli_stmt_execute($deleteStmt)) {
        echo "Property deleted successfully.";
        header("Location: admin_login.php");
        exit();
    } else {
        echo "Error deleting property: " . mysqli_stmt_error($deleteStmt);
    }

    mysqli_stmt_close($deleteStmt);
    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>

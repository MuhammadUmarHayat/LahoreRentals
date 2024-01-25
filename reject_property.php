<?php
include("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $propertyId = $_GET['id'];

    $updateSql = "UPDATE properties SET approval_status = 'rejected' WHERE id = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param($updateStmt, "i", $propertyId);
    mysqli_stmt_execute($updateStmt);

    echo "Property rejected successfully.";

    mysqli_stmt_close($updateStmt);
    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>

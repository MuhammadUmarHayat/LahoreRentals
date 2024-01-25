<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "project");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate and sanitize form data (add more validation as needed)

    // Example: Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle invalid email
        echo "Invalid email address";
        exit();
    }

    // Example: Hash the password (you should use password_hash() in a real scenario)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Example SQL query (use prepared statements for better security)
    $user_id = $_SESSION['user_id']; // Assuming you store the user ID in the session

    $sql = "UPDATE owners SET first_name=?, last_name=?, email=?";

    // Only update the password if a new one is provided
    if (!empty($password)) {
        $sql .= ", password=?";
    }

    $sql .= " WHERE id=?";

    // Use prepared statement
    $stmt = $conn->prepare($sql);

    // Initialize an array to hold the parameters and their types
    $params = array();

    // Add the parameters and their types based on whether the password is provided
    $types = "sss";
    $params[] = &$types;
    $params[] = &$first_name;
    $params[] = &$last_name;
    $params[] = &$email;

    // If updating the password, add it to the parameters
    if (!empty($password)) {
        $types .= "s";
        $params[] = &$hashed_password;
    }

    $types .= "i";
    $params[] = &$user_id;

    // Call bind_param with the array of parameters
    call_user_func_array(array($stmt, 'bind_param'), $params);

    // Execute the statement
    $result = $stmt->execute();

    // Check for errors
    if ($result === false) {
        echo "Error updating profile: " . $stmt->error;
        exit();
    }

    // Close the statement
    $stmt->close();

    // Redirect to the user profile page or another appropriate page
    header("Location: owner_profile.php");
    exit();
} else {
    echo "Profile Updated";
    header("Location: update_profile_form.php");
    exit();
}
?>

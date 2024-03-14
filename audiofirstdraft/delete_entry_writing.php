<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedIn'])) {
    // Redirect to the login page
    header("Location: dashboardlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Database connection parameters
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "audiosite";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the id from the URL
    $id = $_GET['id'];

    // Prepare and bind parameters for deleting the record
    $delete_stmt = $conn->prepare("DELETE FROM writings WHERE id = ?");
    $delete_stmt->bind_param("i", $id);

    // Execute the SQL statement to delete the record
    if ($delete_stmt->execute() === TRUE) {
        echo '<script>alert("Writing deleted successfully!"); window.location.href="uploaded-writing.php";</script>';
    } else {
        echo "Error deleting record: " . $delete_stmt->error;
    }

    // Close statements and connection
    $delete_stmt->close();
    $conn->close();
}
?>

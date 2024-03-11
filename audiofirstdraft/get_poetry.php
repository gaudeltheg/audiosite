<?php
// Include database connection
include_once 'db_connection.php';

// Check if ID parameter is set
if (isset($_GET['id'])) {
    // Sanitize the ID parameter to prevent SQL injection
    $poetryId = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to fetch poetry data by ID
    $sql = "SELECT * FROM poetries WHERE id = $poetryId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the poetry data as an associative array
        $poetryData = $result->fetch_assoc();

        // Convert the data to JSON format and echo it
        echo json_encode($poetryData);
    } else {
        // If no poetry found with the given ID, return an empty object
        echo json_encode([]);
    }
} else {
    // If ID parameter is not set, return an empty object
    echo json_encode([]);
}

// Close database connection
$conn->close();
?>

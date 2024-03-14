<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedIn'])) {
    // Redirect to the login page
    header("Location: dashboardlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Get the form data
    $id = $_POST['editId'];
    $title = $_POST['editTitle'];


    // Fetch the existing data from the database
    $query = "SELECT * FROM fpodcasts WHERE id = $id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    // Check if a new audio file is uploaded
    $audiofile = $_FILES['editAudioFile']['size'] > 0 ? $_POST['editAudioFile'] : $row['audiofile'];

    // Prepare and bind parameters for checking duplicate title
    $check_stmt = $conn->prepare("SELECT id FROM fpodcasts WHERE title = ? AND id <> ?");
    $check_stmt->bind_param("si", $title, $id);
    
    // Execute query to check if title already exists
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Sorry, a record with the same title already exists.";
    } else {
        // Prepare and bind parameters for updating the record
        $update_stmt = $conn->prepare("UPDATE fpodcasts SET title = ?, audiofile = ?, WHERE id = ?");
        $update_stmt->bind_param("ssi", $title, $audiofile, $id);

        // Execute the SQL statement to update the record
        if ($update_stmt->execute() === TRUE) {
            echo '<script>alert("Featured Podcast updated successfully!"); window.location.href="uploaded-featured-podcast.php";</script>';
        } else {
            echo "Error updating record: " . $update_stmt->error;
        }
    }

    // Close statements and connection
    $check_stmt->close();
    $update_stmt->close();
    $conn->close();
}
?>

<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedIn'])) {
    // Redirect to the login page
    header("Location: dashboardlogin.php");
    exit();
}

// Check if form is submitted
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

    // Set parameters
    $audio_title = $_POST['audio_title'];

    // Check if the file is uploaded successfully
    if ($_FILES['audio_file']['error'] == UPLOAD_ERR_OK) {
        // Set parameters for inserting new record
        $audio_file = $_FILES["audio_file"]["name"];
        $audio_tmp = $_FILES["audio_file"]["tmp_name"];

        // Prepare and bind parameters for checking duplicate title
        $check_stmt = $conn->prepare("SELECT id FROM fpoetries WHERE title = ?");
        $check_stmt->bind_param("s", $audio_title);
        
        // Execute query to check if title already exists
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            echo "Sorry, a record with the same title already exists.";
        } else {
            // Prepare and bind parameters for inserting new record
            $insert_stmt = $conn->prepare("INSERT INTO fpoetries (title, audiofile) VALUES (?, ?)");
            $insert_stmt->bind_param("ss", $audio_title, $audio_file);

            // Check if the file already exists in the destination directory
            $target_dir = "fpoetry/"; // Directory where audio files will be uploaded
            $target_file = $target_dir . basename($_FILES["audio_file"]["name"]);

            // File upload handling for audio file
            if (move_uploaded_file($audio_tmp, $target_file)) {
                // File uploaded successfully
                if ($insert_stmt->execute()) {
                    echo '<script>alert("Successfully uploaded!"); window.location.href="' . $_SERVER["PHP_SELF"] . '";</script>';
                } else {
                    echo "Error: " . $insert_stmt->error;
                }
            } else {
                echo "Sorry, there was an error moving the uploaded audio file.";
            }
        }

        // Close statements and connection
        $check_stmt->close();
        $insert_stmt->close();
    } else {
        echo "Error uploading file.";
    }
    
    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Featured Poetry</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        margin-top: 0;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"],
    input[type="file"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    textarea {
        height: 100px;
    }
    input[type="submit"] {
        background-color: #4caf50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Upload Poetry</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="audio_title">Featured Poetry Title:</label>
        <input type="text" id="audio_title" name="audio_title" required>

        <label for="audio_file">Poetry File:</label>
        <input type="file" id="audio_file" name="audio_file" accept=".mp3,.wav" required>
        <input type="submit" value="Upload">
    </form>
</div>
<script>
    // Disable browser back button for this page
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>
</body>
</html>

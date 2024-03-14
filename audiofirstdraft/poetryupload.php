<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedIn'])) {
    // Redirect to the login page
    header("Location: dashboardlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Poetry</title>
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
        <label for="audio_title">Poetry Title:</label>
        <input type="text" id="audio_title" name="audio_title" required>

        <label for="author_name">Author Name:</label>
        <input type="text" id="author_name" name="author_name" required>

        <label for="audio_file">Poetry File:</label>
        <input type="file" id="audio_file" name="audio_file" accept=".mp3,.wav" required>

        <label for="image_file">Poetry Image:</label>
        <input type="file" id="image_file" name="image_file" accept="image/*" required>

        <label for="lyrics_description">Lyrics/Description:</label>
        <textarea id="lyrics_description" name="lyrics_description" required></textarea>

        <input type="submit" value="Upload">
    </form>
    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>

<?php
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

    // Prepare and bind parameters for checking duplicate title
    $check_stmt = $conn->prepare("SELECT id FROM poetries WHERE title = ?");
    $check_stmt->bind_param("s", $audio_title);
    
    // Execute query to check if title already exists
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Sorry, a record with the same title already exists.";
    } else {
        // Prepare and bind parameters for inserting new record
        $insert_stmt = $conn->prepare("INSERT INTO poetries (title, author, audiofile, lyrics, image) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("sssss", $audio_title, $author_name, $audio_file, $lyrics_description, $image_file);

        // Set parameters for inserting new record
        $author_name = $_POST['author_name'];
        $audio_file = basename($_FILES["audio_file"]["name"]);
        $image_file = basename($_FILES["image_file"]["name"]);
        $lyrics_description = $_POST['lyrics_description'];

        // Check if the file already exists in the destination directory and overwrite it if needed
        $target_dir = "poetries/"; // Directory where audio files will be uploaded
        $target_file = $target_dir . basename($_FILES["audio_file"]["name"]);

        // File upload handling for audio file
        if (move_uploaded_file($_FILES["audio_file"]["tmp_name"], $target_file)) {
            // File uploaded successfully
            // Proceed with image upload and database insertion
            $image_target_dir = "images/"; // Directory where image files will be uploaded
            $image_target_file = $image_target_dir . basename($_FILES["image_file"]["name"]);

            // File upload handling for image file
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $image_target_file)) {
                // Execute the SQL statement to insert new record
                if ($insert_stmt->execute() === TRUE) {
                    echo '<script>alert("Successfully uploaded!"); window.location.href="' . $_SERVER["PHP_SELF"] . '";</script>';
                } else {
                    echo "Error: " . $insert_stmt->error;
                }
            } else {
                echo "Sorry, there was an error moving the uploaded image file.";
            }
        } else {
            echo "Sorry, there was an error moving the uploaded audio file.";
        }
    }

    // Close statements and connection
    $check_stmt->close();
    if (isset($insert_stmt)) {
        $insert_stmt->close();
    }
    $conn->close();
}
?>
<script>
    // Disable browser back button for this page
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>

</body>
</html>

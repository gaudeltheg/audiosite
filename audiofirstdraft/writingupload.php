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
<title>Upload Writing</title>
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
    <h2>Upload Writing</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="writing_title">Writing Title:</label>
        <input type="text" id="writing_title" name="writing_title" required>

        <label for="author_name">Author Name:</label>
        <input type="text" id="author_name" name="author_name" required>

        <label for="writing_description">Writing Description:</label>
        <textarea id="writing_description" name="writing_description" required></textarea>

        <input type="submit" value="Upload">
    </form>
    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "audiosite";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind parameters for inserting new record
    $insert_stmt = $conn->prepare("INSERT INTO writings (title, author, description) VALUES (?, ?, ?)");
    $insert_stmt->bind_param("sss", $writing_title, $author_name, $writing_description);

    // Set parameters for inserting new record
    $writing_title = $_POST['writing_title'];
    $author_name = $_POST['author_name'];
    $writing_description = $_POST['writing_description'];

    // Execute the SQL statement to insert new record
    if ($insert_stmt->execute() === TRUE) {
        echo '<script>alert("Successfully uploaded!"); window.location.href="' . $_SERVER["PHP_SELF"] . '";</script>';
    } else {
        echo "Error: " . $insert_stmt->error;
    }

    $insert_stmt->close();
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

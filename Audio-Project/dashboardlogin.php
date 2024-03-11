<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    $userID = $_POST['userID'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and sanitize user input to prevent SQL injection
    $userID = filter_var($userID, FILTER_SANITIZE_NUMBER_INT);
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);

    // Validate username and password to prevent SQL injection
    if (empty($userID) || empty($username) || empty($password)) {
        header("Location: dashboardlogin.php?error=invalid_input");
        exit();
    }

    // Establish a connection to the database
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "audiosite";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to check credentials
    $sql = $conn->prepare("SELECT * FROM loginadmin WHERE id = ? AND username = ? AND password = ?");
    $sql->bind_param("iss", $userID, $username, $password);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        // Credentials are correct, set session and redirect to dashboard
        $row = $result->fetch_assoc();
        $_SESSION['loggedIn'] = true;
        $_SESSION['adminID'] = $row['id']; // Set adminID session variable
        $_SESSION['username'] = $row['username']; // Set username session variable
        header("Location: dashboard.php");
        exit();
    } else {
        // Credentials are incorrect, redirect back to login page with error message
        header("Location: dashboardlogin.php?error=invalid_credentials");
        exit();
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
    .btn-login {
        width: 100%;
        padding: 10px;
        background-color: rgb(56, 145, 56);
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-login:hover {
        background-color: rgb(22, 147, 22);
    }
    @media (max-width: 480px) {
        .container {
            width: 90%;
            margin: 14vh auto;
            height: 50vh;
        }
    }
    h1 {
        text-align: center;
    }
</style>
</head>
<body>
    <h1>Audio Project</h1>
    <div class="container">
        <h2>Admin Panel</h2>
        <form method="post">
            <label for="userID">User ID:</label>
            <input type="number" id="userID" name="userID" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</body>
</html>

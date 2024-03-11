<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
        }
        .success-message {
            color: green;
            font-size: 24px;
        }
        .error-message {
            color: red;
            font-size: 24px;
        }
    </style>
    <meta http-equiv="refresh" content="3;url=index.php"> <!-- Redirect to index.php after 3 seconds -->
</head>
<body>
    <div class="container">
        <?php
            session_start();

            if (isset($_SESSION['success']) && $_SESSION['success']) {
                echo '<p class="success-message">Thank you for your submission!</p>';
                unset($_SESSION['success']); // Clear the success session variable
            } elseif (isset($_SESSION['error']) && $_SESSION['error']) {
                echo '<p class="error-message">Error: Something went wrong. Please try again later.</p>';
                unset($_SESSION['error']); // Clear the error session variable
            } else {
                echo '<p class="success-message">Thank you for your submission!</p>';
            }
        ?>
    </div>
</body>
</html>

<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedIn'])) {
    // Redirect to the login page
    header("Location: dashboardlogin.php");
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: dashboardlogin.php");
    exit();
}

// Retrieve the admin's credentials from session variables
$adminID = $_SESSION['adminID'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
        /* Basic styling for the dashboard */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        nav a {
            color: #fff;
            padding: 5px;
            margin: 6px 6px 6px;
            font-size: 1.2rem;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #fff;
            color: #333;
        }
        nav a .logout:hover {
            background-color: none;
        }
        .logout button {
            padding: 6px;
            margin: 4px;
            color: #333;
            border: none;
            width: 10vw;
            cursor: pointer;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }
        .section h2 a {
            text-decoration: none;
            color: #333;
        }
        .section h2 a:hover {
            text-decoration: underline;
        }
        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
        }
        @media only screen and (max-width: 450px) {
            nav {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .logout button {
                width: 25vw;
            }
            .logout button:hover {
                background-color: none;
            }
        }
    </style>

</head>
<body>
    <div class="navbar">
        <h1>Admin Dashboard</h1>
        <p>Logged in as: ID <?php echo $adminID; ?>, Username: <?php echo $username; ?></p>
        <form method="post">
            <button type="submit" class="logout" name="logout">Log Out</button>
        </form>
    </div>
    <div class="container">
        <div class="section">
            <h2><a href="poetryupload.php">Poetry Upload Section</a></h2>
        </div>
        <div class="section">
            <h2><a href="Uploaded-poetry.php">Uploaded-Poetry</a></h2>
        </div>
        <div class="section">
            <h2><a href="fpoetryupload.php">Featured Poetries Upload</a></h2>
        </div>
        <div class="section">
            <h2><a href="Uploaded-Featured-Poetry.php">Uploaded-Featured-Poetry</a></h2>
        </div>
        <div class="section">
            <h2><a href="podcastupload.php">Podcasts Upload Section</a></h2>
        </div>
        <div class="section">
            <h2><a href="uploaded-podcast.php">Uploaded-Podcast Section</a></h2>
        </div>
        <div class="section">
            <h2><a href="fpodcastupload.php">Featured Podcasts Upload</a></h2>
        </div>
        <div class="section">
            <h2><a href="uploaded-featured-podcast.php">Uploaded-featured-Podcast </a></h2>
        </div>
        <div class="section">
            <h2><a href="writingupload.php">Writings Upload Section</a></h2>
        </div>
        <div class="section">
            <h2><a href="uploaded-writing.php">Uploaded Writings Section</a></h2>
        </div>
        <div class="section">
            <h2><a href="usercontact.php">Users in Contact</a></h2>
        </div>
    </div>
    <div class="footer">
        &copy; 2024 Admin Dashboard | All rights reserved
    </div>
    <script type="text/javascript">
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>
</body>
</html>

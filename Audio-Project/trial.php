<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>single-podcast</title>
    <link rel="stylesheet" href="single-podcast.css" />
    <link rel="stylesheet" href="single-podcast-responsive.css" />
</head>
<body>
    <div id="navbarContainer"></div>

    <?php
    // Check if the title parameter is set in the URL
    if (isset($_GET['title'])) {
        // Sanitize and retrieve the title from the URL
        $title = htmlspecialchars($_GET['title']);
        
        // Establish a connection to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "audiosite";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from the 'podcasts' table based on the provided title
        $sql = "SELECT * FROM podcasts WHERE title = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a podcast with the provided title exists
        if ($result->num_rows > 0) {
            // Output podcast details
            while ($row = $result->fetch_assoc()) {
                echo '<h2>' . $row["title"] . '</h2>';
                echo '<div class="container">';
                echo '<section class="title">';
                echo '<h3>' . $row["title"] . '</h3>';
                echo '<h4>By: ' . $row["author"] . '</h4>';
                echo '<p>' . $row["description"] . '</p>';
                echo '</section>';
                echo '<section class="audio-container">';
                echo '<audio src="' . $row["audiofile"] . '" controls></audio>';
                echo '</section>';
                echo '</div>';
            }
        } else {
            echo 'No podcast found';
        }

        // Close database connection
        $stmt->close();
        $conn->close();
    } else {
        echo 'Warning: Undefined array key "title"';
    }
    ?>

    <div id="footerContainer"></div>
    <script src="importNavbar.js"></script>
    <script src="importFooter.js"></script>
</body>
</html>

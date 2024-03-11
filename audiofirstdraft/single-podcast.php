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
    <?php
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

    // Fetch data from the 'podcasts' table
    $sql = "SELECT * FROM podcasts ORDER BY id";
    $result = $conn->query($sql);

    $podcasts = [];
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $podcasts[] = $row;
        }
    }

    // Get the title from the URL
    $title = $_GET['title'];

    // Sanitize the title to prevent SQL injection
    $title = mysqli_real_escape_string($conn, $title);

    // Fetch data from the 'podcasts' table for the given title
    $sql = "SELECT * FROM podcasts WHERE title = '$title'";
    $result = $conn->query($sql);

    $currentPodcast = null;
    if ($result->num_rows > 0) {
        // Output data of the row
        $currentPodcast = $result->fetch_assoc();
    }

    $conn->close();

    // Find the current podcast in the array
    $currentIndex = array_search($currentPodcast, $podcasts);

    // Get the previous and next podcasts
    $previousPodcast = $currentIndex > 0 ? $podcasts[$currentIndex - 1] : null;
    $nextPodcast = $currentIndex < count($podcasts) - 1 ? $podcasts[$currentIndex + 1] : null;
    ?>

    <div id="navbarContainer"></div>

    <h2>Podcasts</h2>

    <div class="podcast-container">
        <?php
        if ($currentPodcast) {
            echo '<div class="container">';
            echo '<section class="title">';
            echo '<h3>' . $currentPodcast["title"] . '</h3>';
            echo '<h4>By: ' . $currentPodcast["author"] . '</h4>';
            echo '<p>' . $currentPodcast["lyrics"] . '</p>';
            echo '</section>';
            echo '<section class="audio-container">';
            echo '<audio src="podcasts/' . $currentPodcast["audiofile"] . '" controls></audio>'; // Assuming 'audiofile' is the field name for the audio file
            echo '</section>';
            echo '</div>';
        } else {
            echo "No podcast found with the given title";
        }
        ?>

        <div class="navigation">
            <?php
            if ($previousPodcast) {
                echo '<button onclick="loadPodcast(\'' . $previousPodcast['title'] . '\')">Previous</button>';
            }
            if ($nextPodcast) {
                echo '<button onclick="loadPodcast(\'' . $nextPodcast['title'] . '\')">Next</button>';
            }
            ?>
        </div>
    </div>

    <div id="footerContainer"></div>

    <!-- Add any necessary JavaScript code here -->
    <script src="single-podcast.js"></script>
    <script src="importNavbar.js"></script>
    <script src="importFooter.js"></script>
    <script>
        function loadPodcast(title) {
            // Redirect to the single-podcast page with the selected podcast title as a query parameter
            window.location.href = 'single-podcast.php?title=' + encodeURIComponent(title);
        }
    </script>
</body>
</html>

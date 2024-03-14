<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>single-podcast</title>
    <link rel="stylesheet" href="single-podcast.css" />
    <link rel="stylesheet" href="single-podcast-responsive.css" />
    <style>
      .nav-bar {
        display: none;
      }
      .nav-bar {
        border-bottom: 1px solid grey;
        width: 100vw;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        display: none;
      }
      .logo-flex img {
        width: 15vw;
      }
      .logo-flex {
        margin: 5px;
      }
      @media only screen and (max-width: 700px) {
        #navbarContainer {
          display: none;
        }
        .nav-bar {
          display: flex;
        }
      }
      .burger {
        width: 12vw;
        height: 5vh;
        border: 2px solid black;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        padding: 5px;
      }
      .line {
        border: 2px solid black;
      }
      .nav-items-flex {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999;
        transition: all 0.3s ease-in-out;
        background-color: rgba(71, 71, 71, 0.596); 
        backdrop-filter: blur(11px);
        color: whitesmoke;
      }
      *{
        font-family:sans-serif ;
      }
      .nav-items-flex ul {
 margin-top: 15vh; 
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
      }
      .nav-items-flex ul li a{
        text-decoration: none;
        color: white;
        font-size: 1.6rem;
      }
      .nav-items-flex ul li{
        margin: 5px;
        padding: 5px;
        list-style: none;
      }
      .nav-items-flex button{
        background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    margin-top: 0px;
      }
    </style>
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

    <div class="nav-bar">
        <div class="logo-flex">
            <a href="index.php"> <img src="logo.webp" alt="logo" /></a>
        </div>
        <div class="burger" onclick="toggleNavItemsFlex()">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
</div>

<div class="nav-items-flex" id="navItemsFlex">
    <button class="close-button" onclick="closeToggle()">✕</button>
    <ul>

        <li>
            <span class="material-symbols-outlined">home</span>
            <a href="index.php"> HOME </a>
        </li>
        <li>
            <span class="material-symbols-outlined">podcasts</span>
            <a href="podcast.php"> PODCASTS</a>
        </li>
        <li>
            <span class="material-symbols-outlined">library_music</span>
            <a href="poetry.php"> POETRIES</a>
        </li>
        <li>
            <span class="material-symbols-outlined">event_note</span>
            <a href="writing.php"> WRITINGS</a>
        </li>
        <li>
            <span class="material-symbols-outlined">contact_phone</span>
            <a href="contact.php"> CONTACT</a>
        </li>

    </ul>
</div>

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
   </div>
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

     <script>
      function toggleNavItemsFlex() {
       const aaa =  document.getElementById('navItemsFlex');
       aaa.style.display='inline-block';

      }
      function closeToggle(){

        const bbb = document.getElementById('navItemsFlex');
       bbb.style.display='none';
      }
    </script>
     <script>
    // Function to clear the browser's cache when leaving the page
    window.addEventListener('unload', function() {
        // Clear the cache by reloading the page
        window.location.reload(true);
    });
</script>
</body>
</html>

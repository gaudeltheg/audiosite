<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podcast</title>
    <link rel="stylesheet" href="podcast.css" />
    <link rel="stylesheet" href="podcast-responsive.css" />

    <style>
      *{
        font-family:sans-serif ;
      }
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
        background-color: rgba(71, 71, 71, 0.596);  
        transition: all 0.3s ease-in-out;
        backdrop-filter: blur(11px);
        color: whitesmoke;
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
    color: rgb(255, 255, 255);
        font-size: 1.6rem;
      }
      .nav-items-flex ul li{
        margin: 5px;
        padding: 5px;
        list-style: none;
      }
    </style>

</head>
<body>

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

    <div class="podcast-container">
      
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
        $sql = "SELECT * FROM podcasts";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="cards" onclick="redirectToPage(\'' . $row["title"] . '\')">
                        <div class="container">
                        <h3>' . $row["title"] . '</h3>
                        <h4>By: ' . $row["author"] . '</h4>
                        <div class="image-container">
                            <img src="images/' . $row["image"] . '" alt="" />
                        </div>
                        <div class="audio-container">
                            <audio class="audio" controls>
                            <source src="podcasts/' . $row["audiofile"] . '" type="audio/mpeg" />
                            </audio>
                        </div>
                        <canvas class="visualizer"></canvas>
                        <section><button class="playButton">Play</button></section>
                        </div>
                    </div>';
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>

    </div>

    <div id="footerContainer"></div>

    <!-- Add any necessary JavaScript code here -->
    <script src="podcast.js"></script>
    <script src="importNavbar.js"></script>
    <script src="importFooter.js"></script>
    <script>
    function redirectToPage(title) {
        // Redirect to the single-podcast page with the selected podcast title as a query parameter
        window.location.href = 'single-podcast.php?title=' + encodeURIComponent(title);
    }

        function toggleNavItemsFlex() {
            const aaa =  document.getElementById('navItemsFlex');
            aaa.style.display='inline-block';
        }

        function closeToggle() {
            const bbb = document.getElementById('navItemsFlex');
            bbb.style.display='none';
        }
    </script>
</body>
</html>

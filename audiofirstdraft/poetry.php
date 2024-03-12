<?php
// Include your database connection file
include 'db_connection.php';

// Function to retrieve individual poetry data by ID
function getPoetryByID($poetryID) {
    global $conn; // Assuming $conn is your database connection object

    // Prepare and bind parameters
    $stmt = $conn->prepare("SELECT * FROM poetries WHERE id = ?");
    $stmt->bind_param("i", $poetryID);

    // Execute query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Fetch data as associative array
    $poetryData = $result->fetch_assoc();

    // Close statement
    $stmt->close();

    return $poetryData;
}

// Check if poetry ID is provided in the URL
if(isset($_GET['id'])) {
    // Retrieve individual poetry data
    $poetryID = $_GET['id'];
    $poetryData = getPoetryByID($poetryID);
    echo json_encode($poetryData);
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poetry</title>
    <link rel="stylesheet" href="poetry.css" />
    <link rel="stylesheet" href="poetry-responsive.css" />

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

<h2>Poetry Section</h2>
<div class="poetry-container">
    <?php
    // Fetch all poetry data from the database and display each poetry card
    $sql = "SELECT * FROM poetries";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            ?>
            <div class="cards" onclick="openPopup(<?php echo $row['id']; ?>)">
                <div class="container">
                    <h3><?php echo $row['title']; ?></h3>
                    <h4>By: <?php echo $row['author']; ?></h4>
                    <div class="image-container">
                        <img src="images/<?php echo $row['image']; ?>" alt="Poetry Image" />
                    </div>
                    <div class="audio-container">
                        <audio class="audio" controls>
                            <source src="poetries/<?php echo $row['audiofile']; ?>" type="audio/mpeg" />
                        </audio>
                    </div>
                    <canvas class="visualizer"></canvas>
                    <section><button class="playButton">Play</button></section>
                </div>
            </div>
            <?php
        }
    } else {
        echo "No poetry available";
    }
    ?>
</div>

<!-- Popup -->
<!-- <div class="popup" id="popup" style="display: none;">
    <h2 id="popup-title"></h2>
    <div class="popup-image">
        <img src="" alt="Poetry Image" id="popup-image" />
    </div>
    <p id="popup-lyrics"></p>
    <audio class="audio popupaudio" controls id="popup-audio">
        <-- Audio Path -->
        <!-- <source src="" type="audio/mpeg" />
    </audio>
    <div class="canvas">
        <canvas class="visualizer popup-canvas"></canvas>
    </div>
    <button class="playButton popup-playbutton" id="popup-play">Play</button>
    <button class="okbtn" onclick="closePopup()">Close</button> -->
<!--</div>-->

<!--<script>
    // Function to open the popup and fetch data dynamically
    function openPopup(poetryId) {
        // Fetch data using AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var poetryData = JSON.parse(xhr.responseText);
                // Update popup content with fetched data
                document.getElementById('popup-title').innerText = poetryData.title;
                document.getElementById('popup-image').src = 'images/' + poetryData.image;
                document.getElementById('popup-lyrics').innerText = poetryData.description;
                document.getElementById('popup-audio').src = 'poetries/' + poetryData.audiofile;
                // Show the popup
                document.getElementById('popup').style.display = 'block';
            }
        };
        xhr.open("GET", "get_poetry.php?id=" + poetryId, true);
        xhr.send();
    }

    // Function to close the popup
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
        // Pause audio when closing popup
        document.getElementById('popup-audio').pause();
    }
</script> -->
<div id="footerContainer"></div>

    <script src="importNavbar.js"></script>
    <script src="importFooter.js"></script>
    <script src="poetry.js"></script>
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

</body>
</html>

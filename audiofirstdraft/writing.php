<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popular Writing</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
      }

      .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
      }

      .heading {
        text-align: center;
      }

      .card {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
        border: 1px solid rgba(52, 51, 51, 0.354);
      }

      .card-title {
        margin-top: 0;
      }

      .card-content {
        margin-bottom: 10px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 5; /* Limit number of lines displayed */
        -webkit-box-orient: vertical;
      }

      .read-more {
        display: block;
        text-align: center;
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
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
        background-color: rgba(71, 71, 71, 0.596); 
        backdrop-filter: blur(11px);
        color: whitesmoke;
        z-index: 999;
        transition: all 0.3s ease-in-out;
      }
      *{
        font-family:sans-serif ;
      }
      .nav-items-flex ul {
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
      .close-button{
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

<div class="container">
    <h1 class="heading">Popular Writings</h1>
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

    // Fetch data from the 'writings' table
    $sql = "SELECT * FROM writings";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Corrected code to concatenate PHP variable into JavaScript string
            echo '<div class="card" onclick="redirectToSingleWriting(' . $row['id'] . ')">
                    <h2 class="card-title">' . $row["title"] . '</h2>
                    <h4>By: ' . $row["author"] . '</h4>
                    <p class="card-content">' . $row["description"] . '</p>
                    <a href="#" class="read-more">Read More</a>
                  </div>';
        }
    } else {
        echo "No writings available";
    }

    $conn->close();
    ?>
</div>

<div id="footerContainer"></div>
    <script src="importNavbar.js"></script>
    <script src="importFooter.js"></script>
<script>
    function redirectToSingleWriting(writingId) {
        window.location.href = "1writing.php?id=" + writingId;
    }

    function toggleNavItemsFlex() {
        const aaa = document.getElementById('navItemsFlex');
        aaa.style.display = 'inline-block';

    }

    function closeToggle() {

        const bbb = document.getElementById('navItemsFlex');
        bbb.style.display = 'none';
    }
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writing Title</title>

    <style>
      *{
        font-family: sans-serif;
      }
        .container{
            margin: auto;
            width: 80vw;
            border: 1px solid rgba(69, 69, 69, 0.297);
            border-radius: 10px;
            box-shadow:  2px 2px 5px grey;
            padding: 15px;
            font-family: sans-serif;
            height: auto;
            background-color: #dcdcdc3e;
            margin-bottom: 14px;
            margin-top: 7px;
        }
        .container h1{
            text-align: center;
        }
        .container p{
            line-height: 1.5rem;
        }
        @media only screen and (max-width:450px){
            .container{
                width: 95vw;
                margin: auto;
            }
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
        margin: 2px;
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
          <a href="index.html"> <img src="logo.webp" alt="logo" /></a>
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
            <a href="index.html"> HOME </a>
          </li>
          <li>
            <span class="material-symbols-outlined">podcasts</span>
            <a href="podcast.html"> PODCASTS</a>
          </li>
          <li>
            <span class="material-symbols-outlined">library_music</span>
            <a href="poetry.html"> POETRIES</a>
          </li>
          <li>
            <span class="material-symbols-outlined">event_note</span>
            <a href="writing.html"> WRITINGS</a>
          </li>
          <li>
            <span class="material-symbols-outlined">contact_phone</span>
            <a href="contact.html"> CONTACT</a>
          </li>
  
        </ul>
      </div>

    <div id="navbarContainer"></div>
    <?php
// Check if the ID parameter is present in the URL
if(isset($_GET['id'])) {
    // Get the writing ID from the URL
    $writingId = $_GET['id'];

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

    // Prepare a SQL query to fetch the writing details based on the ID
    $sql = $conn->prepare("SELECT * FROM writings WHERE id = ?");
    $sql->bind_param("i", $writingId);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        // Output data of the writing
        while ($row = $result->fetch_assoc()) {
            echo '<div class="container">
                    <h1>' . $row["title"] . '</h1>
                    <h3>By: ' . $row["author"] . '</h3>
                    <p>' . $row["description"] . '</p>
                  </div>';
        }
    } else {
        echo "Writing not found";
    }

    $conn->close();
} else {
    echo "Writing ID not provided";
}
?>


    <div id="footerContainer"></div>
    <script src="importNavbar.js"></script>
    <script src="importFooter.js"></script>
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
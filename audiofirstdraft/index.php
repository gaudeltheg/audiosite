<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Audio Project</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="responsive.css" />
    <link rel="stylesheet" href="footer.css">
  </head>

  <body>
     

    <div class="nav-items-flex" id="navItemsFlex">
      <button class="close-button" onclick="toggleNavItemsFlex()">✕</button>
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

      <nav class="navbar" id="sidebar" onmouseover="expandSidebar()" onmouseout="collapseSidebar()">
        
        <div class="logo flex">
          <a href="index.php">
            <img src="logo.webp" alt="logo" />
          </a>
        </div>

        <div class="nav-items">
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
        
      </nav>

      <div class="hero" id="content">

        <div class="logo-flex">
          <a href="#">
            <img src="logo.webp" alt="logo" />
          </a>
        </div>

        <div class="nav-flex" onclick="toggleNavItemsFlex()">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>

      

        <div class="front-text">
          <p>
            ULTIMATE <br />
            AUDIO <br />
            COLLECTION
          </p>
          <span>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia
            obcaecati in odit odio tempo <br />
            ribus, magnam quisquam nemo, qui minus a quidem molestias unde
            <br />
            distinctio exercitationem!
          </span>
          <!-- <a href="#">CLICK HERE TO LEARN MORE</a> -->
          <button id="exploreButton">Explore</button>
        </div>

        <div class="disc">
          <img src="desc.jpeg" alt="disc" />
        </div>
      </div>
    

      <section class="section-2">
        <h1>Featured Audios</h1>
        <div class="containerr">
            <div class="card_container">
                <div class="poetry_container">
                    <h2>Poetry Section</h2>
                    <div class="box">
                        <img src="https://th.bing.com/th/id/OIP.OLnrsvISPCD-Y65PfWSmtQHaE8?rs=1&pid=ImgDetMain" alt="">
                        <ul>
                            <?php
                            // Connect to the database
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "audiosite";
    
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
    
                            // Fetch data from the 'fpoetries' table
                            $sql = "SELECT * FROM fpoetries";
                            $result = $conn->query($sql);
    
                            // Display fetched data
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<li><audio src='fpoetry/" . $row['audiofile'] . "' controls></audio></li>";
                                }
                            } else {
                                echo "0 results";
                            }
    
                            // Close the connection
                            $conn->close();
                            ?>
                        </ul>
                        <div class="more">
                            <a href="poetry.php"><button>Explore Now</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card_container">
                <div class="podcast_container">
                    <h2>Podcast Section</h2>
                    <div class="box">
                        <img src="https://static.kent.ac.uk/nexus/ems/439.jpg" alt="">
                        <ul>
                            <?php
                            // Connect to the database
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
    
                            // Fetch data from the 'fpodcasts' table
                            $sql = "SELECT * FROM fpodcasts";
                            $result = $conn->query($sql);
    
                            // Display fetched data
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<li><audio src='fpodcast/" . $row['audiofile'] . "' controls></audio></li>";
                                }
                            } else {
                                echo "0 results";
                            }
    
                            // Close the connection
                            $conn->close();
                            ?>
                        </ul>
                        <div class="more">
                            <a href="podcast.php"> <button>Explore Now</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    


    <footer>
      <hr>
      <div class="footer-1">
          <div class="category">
              <h2>Pages</h2>
              <ul>
                  <li><a href="index.php">Home</a></li>
                  <li><a href="poetry.php">Poetry</a></li>
                  <li><a href="podcast.php">Podcast</a></li>
                  <li><a href="writing.php">Writings</a></li>
              </ul>
          </div>
          <div class="category">
                <h2>Connect On</h2>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">LinkedIn</a></li>
                </ul>
            </div>
          <div class="category">
              <h2>UseFull Links</h2>
              <ul>
                  <li><a href="#">Html</a></li>
                  <li><a href="#">Css</a></li>
                  <li><a href="#">Javascript</a></li>
                  <li><a href="#">php</a></li>
              </ul>
          </div>
          <div class="subscribe">
              <h2>Subscribe</h2>
              <p>Sign up for our newsletter to receive updates.</p>
              <div class="form">
                  <form action="">
                      <input type="email" placeholder="Enter your email">
                      <button type="submit">Submit</button>
                  </form>
              </div>
          </div>
      </div>
      <hr>
      <div class="footer-2">
          <div class="final">
              <img src="logo.webp" alt="Logo">
              <h2>Audio Project</h2>
              <p>© Programming Pundits 2024</p>
          </div>
          <div class="socials">
              <ul>
                  <li><a href="#"><img src="facebook-icon.svg" alt="Facebook"></a></li>
                  <li><a href="#"><img src="twitter-icon.svg" alt="Twitter"></a></li>
                  <li><a href="#"><img src="instagram-icon.svg" alt="Instagram"></a></li>
                  <li><a href="#"><img src="linkedin-icon.svg" alt="LinkedIn"></a></li>
              </ul>
          </div>
      </div>
  </footer>
  
   <script>
      document.addEventListener('DOMContentLoaded', function() {
    const audios = document.querySelectorAll('audio');

    audios.forEach(audio => {
        audio.addEventListener('play', function() {
            pauseAllExcept(this);
        });
    });

    function pauseAllExcept(currentAudio) {
        audios.forEach(audio => {
            if (audio !== currentAudio) {
                audio.pause();
            }
        });
    }
});
document.getElementById("exploreButton").addEventListener("click", function() {
  window.scrollBy({
    top: window.innerHeight,
    left: 0,
    behavior: 'smooth'
  });
});
</script>
 
 <script src="sidebar.js"></script>
 <script src="navToggle.js"></script>
  </body>
</html>

<?php
session_start(); // Start the session

// PHP code for handling form submission and database insertion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Your database connection credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "audiosite";

    // Establish a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to insert data into the 'contact' table
    $sql = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $name, $email, $message);
    $sql->execute();

    // Check if the data was successfully inserted
    if ($sql->affected_rows > 0) {
        $_SESSION['success'] = true; // Set a session variable to indicate successful submission
    } else {
        $_SESSION['error'] = true; // Set a session variable to indicate submission error
    }

    // Close the database connection
    $conn->close();

    // Redirect to a different page to prevent form resubmission
    header("Location: thank_you.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      .section-container{
        margin-left: 5vw;
      }
      .section-container h1{
        text-align: center;
        font-size: 30px;
        font-weight: 600;
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
        width: 14vw;
        height: 6vh;
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
        background-color: rgba(71, 71, 71, 0.596); 
        backdrop-filter: blur(11px);
        color: whitesmoke;
        z-index: 999;
        transition: all 0.3s ease-in-out;
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
      *{
        font-family:sans-serif ;
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

  <div class="section-container">
    <h1>Contact Form</h1>
    <section class="text-gray-600 body-font relative">
      <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap">
        <div class="lg:w-2/3 md:w-1/2 bg-gray-300 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14962.064497835177!2d85.80014255541991!3d20.36159880000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a19094076713875%3A0xb25b0c927e78c50f!2sKIIT%20University!5e0!3m2!1sen!2sin!4v1710254453165!5m2!1sen!2sin" width="100%" height="100%" style="border:0;"   class="absolute inset-0" frameborder="0" title="map" marginheight="0" marginwidth="0" scrolling="no" style="filter: grayscale(1) contrast(1.2) opacity(0.4);"></iframe>

          <!-- <iframe width="100%" height="100%" class="absolute inset-0" frameborder="0" title="map" marginheight="0" marginwidth="0" scrolling="no" src=" " style="filter: grayscale(1) contrast(1.2) opacity(0.4);"></iframe> -->

          <div class="bg-white relative flex flex-wrap py-6 rounded shadow-md">

            <div class="lg:w-1/2 px-6">
              <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs">ADDRESS</h2>
              <p class="mt-1">Photo booth tattooed prism, portland taiyaki hoodie neutra typewriter</p>
            </div>
            <div class="lg:w-1/2 px-6 mt-4 lg:mt-0">
              <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs">EMAIL</h2>
              <a class="text-indigo-500 leading-relaxed">example@email.com</a>
              <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs mt-4">PHONE</h2>
              <p class="leading-relaxed">123-456-7890</p>
            </div>
          </div>
        </div>
        <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
          <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Feedback</h2>
          <p class="leading-relaxed mb-5 text-gray-600">Post-ironic portland shabby chic echo park, banjo fashion axe</p>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="relative mb-4">
            <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
            <input type="text" id="name" name="name" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
            <input type="email" id="email" name="email" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
            <textarea id="message" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
            <button type="submit" name="submit" class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Submit</button>
          </form>
          <p class="text-xs text-gray-500 mt-3">Chicharrones blog helvetica normcore iceland tousled brook viral artisan.</p>
        </div>
      </div>
    </section>
  </div>

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

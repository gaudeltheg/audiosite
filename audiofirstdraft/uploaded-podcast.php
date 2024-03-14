<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedIn'])) {
    // Redirect to the login page
    header("Location: dashboardlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Podcast</title>
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        img {
            max-width: 100px; /* Adjust image width as needed */
            height: auto;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        /* Popup form styles */
        .popup-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .popup-form label {
            display: block;
            margin-bottom: 10px;
        }

        .popup-form input[type="text"],
        .popup-form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .popup-form input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style> 
</head>
<body>

    <div class="container">
        <h2>Uploaded Poetry</h2>
        <table id="myTable">
            <thead>
                <tr>
                    <th>Podcast Title</th>
                    <th>Author Name</th>
                    <th>Podcast File</th>
                    <th>Podcast Image</th>
                    <th>Lyrics/Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP code to fetch and display uploaded data from the database -->
                <?php
                // Establish a connection to the database
                $servername = "localhost";
                $username = "root"; 
                $password = ""; 
                $dbname = "audiosite";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from the 'poetries' table
                $sql = "SELECT * FROM podcasts";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['title']."</td>";
                        echo "<td>".$row['author']."</td>";
                        echo "<td>".$row['audiofile']."</td>";
                        echo "<td><img src='images/".$row['image']."' alt='Podcast Image'></td>"; // Display image
                        echo "<td>".$row['lyrics']."</td>";
                        echo "<td>";
                        echo "<button class='btn btn-edit' onclick='editRow(" . json_encode($row) . ")'>Edit</button>";
                        echo "<button class='btn btn-delete' onclick='deleteRow(" . $row['id'] . ")'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No results found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Popup form for editing -->
    <div id="editFormPopup" class="popup-form">
        <h2>Edit Podcast</h2>
        <form id="editForm" action="edit_entry_podcast.php" method="post" enctype="multipart/form-data">
            <input type="hidden" id="editId" name="editId">
            <label for="editTitle">Podcast Title:</label>
            <input type="text" id="editTitle" name="editTitle" required>
            <label for="editAuthor">Author Name:</label>
            <input type="text" id="editAuthor" name="editAuthor" required>
            <label for="editAudioFile">New Podcast Audio File:</label>
            <input type="file" id="editAudioFile" name="editAudioFile">
            <label for="editImage">New Podcast Image:</label>
            <input type="file" id="editImage" name="editImage">
            <label for="editLyrics">Lyrics/Description:</label>
            <textarea id="editLyrics" name="editLyrics" required></textarea>
            <input type="submit" value="Update">
        </form>
        <button onclick="closeEditForm()">Cancel</button>
    </div>

    <script>
    // Function to handle editing a row
    function editRow(row) {
    // Preload form fields with existing data
    document.getElementById('editId').value = row.id;
    document.getElementById('editTitle').value = row.title;
    document.getElementById('editAuthor').value = row.author;
    document.getElementById('editLyrics').value = row.lyrics;

    // Clear the previous image and audio elements
    var oldImage = document.getElementById('currentImage');
    var oldAudio = document.getElementById('currentAudio');
    if (oldImage) oldImage.remove();
    if (oldAudio) oldAudio.remove();

    // Display the current image
    var currentImage = document.createElement('img');
    currentImage.id = 'currentImage';
    currentImage.src = 'images/' + row.image;
    currentImage.alt = 'Current Image';
    document.getElementById('editForm').insertBefore(currentImage, document.getElementById('editImage'));

    // Display the current audio file
    var currentAudio = document.createElement('audio');
    currentAudio.id = 'currentAudio';
    currentAudio.src = row.audiofile;
    currentAudio.controls = true;
    document.getElementById('editForm').insertBefore(currentAudio, document.getElementById('editAudioFile'));

    // Show the edit popup
    document.getElementById('editFormPopup').style.display = 'block';
}



    // Function to close the edit popup
    function closeEditForm() {
        document.getElementById('editFormPopup').style.display = 'none';
    }

    // Function to handle deleting a row
    function deleteRow(id) {
        if (confirm("Are you sure you want to delete this Podcast?")) {
            // Redirect to the delete action page with the Podcast ID
            window.location.href = "delete_entry_podcast.php?id=" + id;
        }
    }
    </script>

    <!-- Include DataTables library -->
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#myTable').DataTable();
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Poetry</title>
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">
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

    </style> 
</head>
<body>
    <div class="container">
        <h2>Uploaded Poetry</h2>
        <table id="myTable">
            <thead>
                <tr>
                    <th>Poetry Title</th>
                    <th>Author Name</th>
                    <th>Poetry File</th>
                    <th>Poetry Image</th>
                    <th>Lyrics/Description</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP code to fetch and display uploaded data from the database -->
                <?php
                    // Your PHP code to fetch data from the database and loop through each record
                    // Example:
                    
                    // while ($row = mysqli_fetch_assoc($result)) {
                    //     echo "<tr>";
                    //     echo "<td>".$row['audio_title']."</td>";
                    //     echo "<td>".$row['author_name']."</td>";
                    //     echo "<td>".$row['audio_file']."</td>";
                    //     echo "<td><img src='".$row['image_file']."' alt='Poetry Image'></td>";
                    //     echo "<td>".$row['lyrics_description']."</td>";
                    //     echo "</tr>";
                    // }
                    
                ?>
            </tbody>
        </table>
    </div>

<script>
    let table = new DataTable('#myTable');
</script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
</body>
</html>

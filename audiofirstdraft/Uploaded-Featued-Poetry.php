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
    </style> 
</head>
<body>
    <div class="container">
        <h2>Featured Uploaded Poetry</h2>
        <table id="myTable">
            <thead>
                <tr>
                    <th>Poetry Title</th>
                    <th>Poetry File</th>
                    <th>Actions</th> <!-- New column for edit and delete buttons -->
                </tr>
            </thead>
            <tbody>
                <!-- PHP code to fetch and display uploaded data from the database -->
                <?php
                    // Your PHP code to fetch data from the database and loop through each record
                    // Example:
                    /*
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$row['audio_title']."</td>";
                        echo "<td>".$row['audio_file']."</td>";
                        echo "<td>";
                        echo "<button class='btn btn-edit' onclick='editRow(".$row['id'].")'>Edit</button>";
                        echo "<button class='btn btn-delete' onclick='deleteRow(".$row['id'].")'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    */
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Function to handle editing a row
        function editRow(id) {
            // You can implement your edit logic here
            alert("Edit row with ID: " + id);
        }
        
        // Function to handle deleting a row
        function deleteRow(id) {
            // You can implement your delete logic here
            alert("Delete row with ID: " + id);
        }
    </script>
    
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
</body>
</html>

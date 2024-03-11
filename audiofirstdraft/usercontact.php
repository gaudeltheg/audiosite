<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Contact Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        
         
        <h2>Contact List</h2>
        <table id="contactTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "audiosite";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                    }

                    // Prepare and bind
                    $stmt = $conn->prepare("SELECT id, name, email, message FROM contact");
                    $stmt->execute();

                    // Bind result variables
                    $stmt->bind_result($id, $name, $email, $message);

                    // Fetch values and output data of each row
                    while($stmt->fetch()) {
                    echo "<tr><td>" . $name . "</td><td>" . $email . "</td><td>" . $message . "</td></tr>";
                    }

                    $stmt->close();
                    $conn->close();
                ?>

            </tbody>
        </table>
    </div>

    
</body>
</html>

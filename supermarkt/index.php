<?php

echo "Supermarkt App @ ".gethostname();

$servername = getenv('SUPERMARKT_DB_HOST');
$username = getenv('SUPERMARKT_DB_USER');
$password = getenv('SUPERMARKT_DB_PASS');
$dbname = getenv('SUPERMARKT_DB_NAME');

if ($servername == false) {
    die("Supermarkten functioneren niet zonder database credentials. :(");
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name FROM producten";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. "<br>";
    }
} else {
    echo "0 results :(";
}
$conn->close();
<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "cinema_db";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$movie_id = $_POST['movie_id'];
$hall_number = $_POST['hall_number'];
$start_time = $_POST['start_time'];
$price = $_POST['price'];

$sql = "INSERT INTO sessions (movie_id, hall_number, start_time, price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssd", $movie_id, $hall_number, $start_time, $price);
    $stmt->execute();
    $stmt->close();
    header("Location: \\cinema/index.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

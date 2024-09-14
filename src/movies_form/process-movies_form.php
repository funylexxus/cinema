<?php

$title = $_POST["title"];
$description = $_POST["description"];
$release_date = $_POST["release_date"];
$duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_NUMBER_INT);
$rating = filter_input(INPUT_POST, "rating", FILTER_SANITIZE_NUMBER_INT);


$host = "localhost";
$dbname = "cinema_db";
$username = "root";
$password = "";

$conn = mysqli_connect(hostname: $host,
username: $username,
password: $password,
database: $dbname);

if (mysqli_connect_errno()) {
die("Connection error: " . mysqli_connect_error());
}

$sql = "INSERT INTO movies (title, description, release_date, duration, rating) VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_stmt_init($conn);

if ( ! mysqli_stmt_prepare($stmt, $sql)) {
die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "sssid",
$title,
$description,
$release_date,
$duration,
$rating);

mysqli_stmt_execute($stmt);

header("Location: \\cinema/index.html");
?>
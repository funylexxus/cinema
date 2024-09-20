<?php

require_once "../../constants.php";
require "../../databaseConnection.php";

function setMovie($title, $description, $release_date, $duration, $rating){
    $connection = connectToDatabase();

    $sql = "INSERT INTO movies (title, description, release_date, duration, rating) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssdd", $title, $description, $release_date, $duration, $rating);

    $stmt->execute();
    $stmt->close();

    disconnectFromDatabase($connection);
}
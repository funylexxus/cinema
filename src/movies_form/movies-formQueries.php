<?php
error_reporting(E_ALL & ~E_WARNING);
include_once "./constants.php";
include_once "./databaseConnection.php";
include_once "../../constants.php";
include_once "../../databaseConnection.php";

function setMovie($title, $description, $release_date, $duration, $rating){
    $connection = connectToDatabase();

    $sql = "INSERT INTO movies (title, description, release_date, duration, rating) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssdd", $title, $description, $release_date, $duration, $rating);

    $stmt->execute();
    $stmt->close();

    disconnectFromDatabase($connection);
}

function getMovies(){
    $connection = connectToDatabase();

    $moviesArray = [];

    $sql = "SELECT id, title, description, release_date, duration, rating FROM movies";
    $stmt = $connection->prepare($sql);

    $stmt->execute();
    $result= $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $moviesArray[] = $row;
        }
    }

    $stmt->close();

    disconnectFromDatabase($connection);

    return $moviesArray;
}
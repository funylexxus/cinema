<?php
error_reporting(E_ALL & ~E_WARNING);
include_once "./constants.php";
include_once "./databaseConnection.php";
include_once "../../constants.php";
include_once "../../databaseConnection.php";

function setSession($movie_id, $hall_number, $start_time, $price){
    $connection = connectToDatabase();

    $sql = "INSERT INTO sessions (movie_id, hall_number, start_time, price) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iisd", $movie_id, $hall_number, $start_time, $price);

    $stmt->execute();
    $stmt->close();

    disconnectFromDatabase($connection);
}

function getSessions(){
    $connection = connectToDatabase();

    $sessionsArray = [];

    $sql = "SELECT id, movie_id, hall_number, start_time, price FROM sessions";
    $stmt = $connection->prepare($sql);

    $stmt->execute();
    $result= $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $sessionsArray[] = $row;
        }
    }

    $stmt->close();

    disconnectFromDatabase($connection);

    return $sessionsArray;
}


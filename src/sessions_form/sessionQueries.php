
<?php

require_once "../../constants.php";
require "../../databaseConnection.php";

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
    $sessionsArray = [];

    $connection = connectToDatabase();

    $sql = "SELECT hall_number, start_time, price FROM sessions";

    $stmt = $connection->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            $sessionsArray[] = $row;
        } 
    }

    $stmt->close();

    disconnectFromDatabase($connection);

    return $sessionsArray;
}
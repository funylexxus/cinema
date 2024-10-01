<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/constants.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/databaseConnection.php";

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

function getMoviesTitle(){
    $connection = connectToDatabase();

    $moviesTitleArray = [];

    $sql = "SELECT title FROM movies";
    $stmt = $connection->prepare($sql);
    
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $moviesTitleArray[] = $row;
        }
    }

    $stmt->close();

    disconnectFromDatabase($connection);

    return $moviesTitleArray;
}

function getMoviesId() {
    $connection = connectToDatabase();

    $moviesIdArray = [];
    
    $sql = "SELECT id from movies";
    $stmt = $connection->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $moviesIdArray[] = $row;
        }
    }
}

function getMoviesIdByTitle(String $title){
    $id = null;

    $connection = connectToDatabase();

    $sql = "SELECT id FROM users WHERE title = ? LIMIT 1";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $title);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row["id"];
    }

    $stmt->close();

    disconnectFromDatabase($connection);

    return $id;
}

function deleteMovie($id) {
    $connection = connectToDatabase();

    $sql = "DELETE FROM movies WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $stmt->close();

    disconnectFromDatabase($connection);
}
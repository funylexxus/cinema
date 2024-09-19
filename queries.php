<?php

require "constants.php";

function connectToDatabase(){
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);

    if ($conn->connect_error) {
        die("Ошибка при подключении к БД: " . $conn->connect_error);
    }
    
    return $conn;
}

function disconnectFromDatabase($conn){
    $conn->close();
}

function getUsername(int $id){
    $username = "";

    $connection = connectToDatabase();

    $sql = "SELECT login FROM users WHERE id = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row["login"];
    }

    disconnectFromDatabase($connection);

    return $username;
}

function setUsername(int $id, string $newUsername): bool {
    $connection = connectToDatabase();

    $sql = "UPDATE users SET login = ? WHERE id = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $newUsername, $id);
    $result = $stmt->execute();

    disconnectFromDatabase($connection);

    return $result;
}

function getEmail(int $id){
    $email = "";

    $connection = connectToDatabase();

    $sql = "SELECT email FROM users WHERE id = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row["email"];
    }

    disconnectFromDatabase($connection);

    return $email;
}

function setEmail(int $id, string $newEmail): bool {
    $connection = connectToDatabase();

    $sql = "UPDATE users SET email = ? WHERE id = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $newEmail, $id);
    $result = $stmt->execute();

    disconnectFromDatabase($connection);

    return $result;
}

function getPassword(int $id){
    $password = "";

    $connection = connectToDatabase();

    $sql = "SELECT password FROM users WHERE id = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $row["password"];
    }

    disconnectFromDatabase($connection);

    return $password;
}

function setPassword(int $id, string $newPassword): bool {
    $connection = connectToDatabase();

    $sql = "UPDATE users SET password = ? WHERE id = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $newPassword, $id);
    $result = $stmt->execute();

    disconnectFromDatabase($connection);

    return $result;
}
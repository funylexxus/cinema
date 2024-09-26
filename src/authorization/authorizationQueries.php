<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/constants.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/databaseConnection.php";


function setUser(String $login, String $password, String $email){
    $connection = connectToDatabase();

    $sql = "INSERT INTO users (login, password, email) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sss", $login, $password, $email);

    $stmt->execute();
    $stmt->close();

    disconnectFromDatabase($connection);
}

function getIdByEmail(String $email){
    $id = null;

    $connection = connectToDatabase();

    $sql = "SELECT id FROM users WHERE email = ? LIMIT 1";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $email);
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

function getIdByUsername(String $username){
    $id = null;

    $connection = connectToDatabase();

    $sql = "SELECT id FROM users WHERE login = ? LIMIT 1";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $username);
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

    $stmt->close();

    disconnectFromDatabase($connection);

    return $username;
}

function setUsername(int $id, string $newUsername) {
    $connection = connectToDatabase();

    $sql = "UPDATE users SET login = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $newUsername, $id);

    $stmt->execute();
    $stmt->close();

    disconnectFromDatabase($connection);
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

    $stmt->close();

    disconnectFromDatabase($connection);

    return $email;
}

function setEmail(int $id, string $newEmail): bool {
    $connection = connectToDatabase();

    $sql = "UPDATE users SET email = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $newEmail, $id);

    $result = $stmt->execute();
    $stmt->close();

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

    $stmt->close();

    disconnectFromDatabase($connection);

    return $password;
}

function setPassword(int $id, string $newPassword): bool {
    $connection = connectToDatabase();

    $sql = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $newPassword, $id);

    $result = $stmt->execute();
    $stmt->close();

    disconnectFromDatabase($connection);

    return $result;
}

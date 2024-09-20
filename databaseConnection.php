<?php
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
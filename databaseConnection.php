<?php
function connectToDatabase(){
    try{
        $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
        return $conn;
    } catch(Exception $e){
        die("Error: ".$e->getMessage());
    }
}

function disconnectFromDatabase($conn){
    $conn->close();
}
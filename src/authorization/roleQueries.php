<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/databaseConnection.php";

function getRoleName($id){
    $name = "";

    $connection = connectToDatabase();

    $sql = "SELECT role_name FROM roles WHERE id = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row["role_name"];
    }

    $stmt->close();

    disconnectFromDatabase($connection);

    return $name;
}

function getRoles(){
    $connection = connectToDatabase();

    $rolesArray = [];

    $sql = "SELECT * FROM roles";
    $stmt = $connection->prepare($sql);

    $stmt->execute();
    $result= $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $rolesArray[] = $row;
        }
    }

    $stmt->close();

    disconnectFromDatabase($connection);

    return $rolesArray;
}
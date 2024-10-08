<?php
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
<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "cinema_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//
//sign up
//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'signup') {
    $login = $_POST['login'];
    $password = password_hash($_POST['pswd'], PASSWORD_BCRYPT);
    $email = $_POST['email'];


    $sql = "INSERT INTO users (login, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $login, $password, $email);

    if ($stmt->execute()) {
        header("Location: \\cinema/index.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}
//
//sign in
//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $_POST['email'];
    $password = $_POST['pswd'];

    $sql = "SELECT password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        header("Location: \\cinema/index.html");
    } else {
        echo "Invalid email or password";
    }

    $stmt->close();
}

$conn->close();

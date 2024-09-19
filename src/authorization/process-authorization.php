<?php

require "authorizationQueries.php";
require "authorizationValidation.php";
//
//sign up
//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'signup') {
    $login = $_POST['login'];
    $password = password_hash($_POST['pswd'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $result = setUser($login, $password, $email);

    header("Location: \\cinema/index.html");

}
//
//sign in
//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $_POST['email'];
    $password = $_POST['pswd'];

    $id = getIdByEmail($email);
    $hashedPassword = getPassword($id);

    if (password_verify($password, $hashedPassword)) {
        header("Location: \\cinema/index.html");
    } else {
        echo "Invalid email or password";
    }
}
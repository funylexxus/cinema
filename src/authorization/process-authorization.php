<?php

require "authorizationQueries.php";
require "authorizationValidation.php";

//
//sign up
//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'signup') {
    $login = $_POST['login'];
    $password = $_POST['pswd'];
    $email = $_POST['email'];

    if(($result = validateRegistration($login, $email, $password)) != false) {
        echo "<p style='color: red;'>Ошибка: $result</p>";
    } else {
        setUser($login, password_hash($password, PASSWORD_BCRYPT), $email);
        session_start();
        $_SESSION['loggedin'] = true;
        header("Location: \\cinema/index.php");
        exit();
    }
}
//
//sign in
//
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $_POST['email'];
    $password = $_POST['pswd'];

    $id = getIdByEmail($email);

    if($id != null) $hashedPassword = getPassword($id);
    else $hashedPassword = "";

    if(($result = validateAuthorization($email, $password)) != false) {
        echo "<p style='color: red;'>Ошибка: $result</p>";
    } else {
        if (password_verify($password, $hashedPassword)) {
            session_start();
            $_SESSION['loggedin'] = true;
            header("Location: \\cinema/index.php");
            exit();
        } else {
            echo "<p style='color: red;'>Неверный пароль</p>";
        }
    }
 }


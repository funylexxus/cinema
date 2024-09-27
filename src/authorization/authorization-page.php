<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <title>Sign up / Login Form</title>
    <link rel="stylesheet" href="./css/main.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap"
      rel="stylesheet" />
  </head>

  <body>
    <div class="main">
      <input type="checkbox" id="chk" aria-hidden="true" />

      <div class="signup">
        <form action="authorization-page.php" method="post">
          <label for="chk" aria-hidden="true">Sign up</label>
          <input type="text" name="login" placeholder="Username" />
          <input type="email" name="email" placeholder="Email" />
          <input type="password" name="pswd" placeholder="Password" />
          <input type="hidden" name="action" value="signup" />
          <button type="submit">Sign up</button>
        </form>
      </div>
      <div class="login">
        <form action="authorization-page.php" method="post">
          <label for="chk" aria-hidden="true">Login</label>
          <input type="email" name="email" placeholder="Email" />
          <input type="password" name="pswd" placeholder="Password" />
          <input type="hidden" name="action" value="login" />
          <button>Login</button>
        </form>
      </div>
    </div>
  </body>
</html>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/constants.php";
require_once $_SERVER['DOCUMENT_ROOT'] ."//cinema/src/authorization/authorizationQueries.php";
require_once $_SERVER['DOCUMENT_ROOT'] ."//cinema/src/authorization/authorizationValidation.php";

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
        $_SESSION['loggedin'] = true;
        header("Location: \\cinema/index.php");
        exit();
        } else {
            echo "<p style='color: red;'>Неверный пароль</p>";
        }
    }
}


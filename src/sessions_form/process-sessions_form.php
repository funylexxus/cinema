<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/sessions_form/session-formQueries.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/src/sessions_form/session-formValidation.php";

$movie_id = $_POST['movie_id'];
$hall_number = $_POST['hall_number'];
$start_time = $_POST['start_time'];
$price = $_POST['price'];

if(($result = validateSession($movie_id, $hall_number, $start_time, $price)) != false) {
    echo "<p style='color: red;'>".nl2br($result)."</p>";
} else {
    setSession($movie_id, $hall_number, $start_time, $price);
    header("Location: \\cinema/index.php");
    exit();
}

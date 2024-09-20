<?php

require "movies-formQueries.php";
require "movies-formValidation.php";

$title = $_POST["title"];
$description = $_POST["description"];
$release_date = $_POST["release_date"];
$duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_NUMBER_INT);
$rating = filter_input(INPUT_POST, "rating", FILTER_SANITIZE_NUMBER_INT);

if(($result = validateMovie($title, $description, $release_date, $duration, $rating)) != false) {
    echo "<p style='color: red;'>".nl2br($result)."</p>";
} else {
    setMovie($title, $description, $release_date, $duration, $rating);
    header("Location: \\cinema/index.html");
    exit();
}

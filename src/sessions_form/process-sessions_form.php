<?php

require "sessionQueries.php";

$movie_id = $_POST['movie_id'];
$hall_number = $_POST['hall_number'];
$start_time = $_POST['start_time'];
$price = $_POST['price'];

setSession($movie_id, $hall_number, $start_time, $price);
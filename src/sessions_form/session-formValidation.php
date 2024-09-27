<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/constants.php";

function validateSession($movie_id, $hall_number, $start_time, $price){
    if(($result = validateMovieId($movie_id)) != false) return $result;
    if(($result = validateHallNumber($hall_number)) != false) return $result;
    if(($result = validateStartTime($start_time)) != false) return $result;
    if(($result = validatePrice($price)) != false) return $result;

    return false;
}

function validateMovieId(int $movie_id) {
    if($movie_id < 0) return "Id должен быть больше нуля"; 
    if(!is_int($movie_id)) return "Id фильма должен быть целым числом";

    return  false;
}

function validateHallNumber(int $hall_number) {
    if($hall_number < MIN_HALL_NUMBER) return "Номер зала должен быть больше ".(MIN_HALL_NUMBER-1); 
    if(!is_int($hall_number)) return "Номер зала должен быть целым числом";

    return false;
}

function validateStartTime($start_time) {
    if (empty($start_time)) {
        return "Дата не должна быть пустой.";
    }

    $date = DateTime::createFromFormat('Y-m-d h:m:s', $start_time);
    if (!$date || $date->format('Y-m-d h:m:s') !== $start_time) {
        return "Неправильный формат данных. Используйте YYYY-MM-DD HH:MM:SS.";
    }

    return false;
}

function validatePrice($price) {
    if($price < 0) return "Цена должна быть больше нуля"; 
    if(!is_numeric($price)) return "Цена должна быть числом";

    return false;
}
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/constants.php";

function validateSession($movie_id, $hall_number, $start_time, $price){
    if(($result = validateMovieId($movie_id)) != false) return $result;
    if(($result = validateHallNumber($hall_number)) != false) return $result;
    if(($result = validateStartTime($start_time)) != false) return $result;
    if(($result = validatePrice($price)) != false) return $result;

    return false;
}

function validateMovieId($movie_id) {
    if($movie_id < 0) return "Id должен быть больше нуля"; 

    return  false;
}

function validateHallNumber($hall_number) {
    if($hall_number < MIN_HALL_NUMBER) return "Номер зала должен быть больше ".(MIN_HALL_NUMBER-1); 

    return false;
}

function validateStartTime($start_time) {
    if (empty($start_time)) {
        return "Дата не должна быть пустой.";
    }

    $format = 'Y-m-d H:i:s';
    $dateTime = DateTime::createFromFormat($format, $start_time);

    if (!$dateTime || $dateTime->format($format) !== $start_time) {
        return "Дата должна быть в формате YYYY-MM-DD HH:MM:SS.";
    }

    return false;
}

function validatePrice($price) {
    if($price < 0) return "Цена должна быть больше нуля"; 
    if(!is_numeric($price)) return "Цена должна быть числом";

    return false;
}
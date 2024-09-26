<?php

require_once "../../constants.php";

function validateMovie($title, $description, $release_date, $duration, $rating){
    if(($result = validateTitle($title)) != false) return $result;
    if(($result = validateDescription($description)) != false) return $result;
    if(($result = validateReleaseDate($release_date)) != false) return $result;
    if(($result = validateDuration($duration)) != false) return $result;
    if(($result = validateRating($rating)) != false) return $result;

    return false;
}

function validateTitle($title) {
    if (empty($title)) {
        return <<<EOD
        . . . . . . . . . . .,'´`. ,'``;
        . . . . . . . . . .,`. . .`—–'..
        . . . . . . . . . .,. . . . . .~ .`- .
        . . . . . . . . . ,'. . . . . . . .o. .o__
        . . . . . . . . _l. . . . . . . . . . . .
        . . . . . . . _. '`~-.. . . . . . . . . .,'
        . . . . . . .,. .,.-~-.' -.,. . . ..'–~`
        . . . . . . /. ./. . . . .}. .` -..,/
        . . . . . /. ,'___. . :/. . . . . .
        . . . . /'`-.l. . . `'-..'........ . .
        . . . ;. . . . . . . . . . . . .)-.....l
        . . .l. . . . .' —........-'. . . ,'
        . . .',. . ,....... . . . . . . . . .,'
        . . . .' ,/. . . . `,. . . . . . . ,'_____
        . . . . .. . . . . .. . . .,.- '_______|_')
        . . . . . ',. . . . . ',-~'`. (.))
        . . . . . .l. . . . . ;. . . /__
        . . . . . /. . . . . /__. . . . .)
        . . . . . '-.. . . . . . .)
        . . . . . . .' - .......-`
        nazvanie normal'noe vvedi...
        EOD;
        
    }
    if (strlen($title) > MAX_TITLE_LENGTH) {
        return "Название должно быть меньше ".MAX_TITLE_LENGTH." символов.";
    }
    return false;
}

function validateDescription($description) {
    if (empty($description)) {
        return "Описание не должно быть пустым.(aaa negri)";
    }
    return false;
}

function validateReleaseDate($release_date) {
    if (empty($release_date)) {
        return "Дата не должна быть пустой.(goida)";
    }

    $date = DateTime::createFromFormat('D-m-y', $release_date);
    if (!$date || $date->format('D-m-y') !== $release_date) {
        return "Неправильный формат данных. Используйте DD-MM-YYYY.(dr gitlera)";
    }
    return false;
}

function validateDuration($duration) {
    if (!is_numeric($duration) || $duration <= MIN_DURATION || $duration > MAX_DURATION) {
        return "Продолжительность должна быть положительным числом до ".MAX_DURATION.".";
    }
    return false;
}

function validateRating($rating) {
    if (!is_numeric($rating) || $rating < MIN_RATING || $rating > MAX_RATING) {
        return "Рейтинг должен быть от ".MIN_RATING." до ".MAX_RATING.".";
    }
    return false;
}
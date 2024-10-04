<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/cinema/constants.php";

function validateRegistration($username, $email, $password){
    if(($result = validateUsername($username)) != false) return $result;
    if(($result = validateEmail($email)) != false) return $result;
    if(($result = validatePassword($password)) != false) return $result;

    return false;
}

function validateAuthorization($username, $password){
    if(($result = validateUsername($username)) != false) return $result;
    if(($result = validatePassword($password)) != false) return $result;
    
    return false;
}

function validateUsername($username){
    if(($result = checkLength($username, MIN_LOGIN_LENGTH, MAX_LOGIN_LENGTH)) != false) return "Логин ".$result;

    if(($result = checkLoginSymbols($username)) != false) return "Логин ".$result;
    
    return false;
}

function validateEmail($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Неверный формат email.";
    }

    return false;
}

function validatePassword($password){
    if(($result = checkMinLength($password, MIN_PASSWORD_LENGTH)) != false) return "Пароль ".$result;
    
    if(($result = checkPasswordSymbols($password)) != false) return "Пароль ".$result;
    
    return false;
}

function checkLoginSymbols($str){
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $str)) {
        return "может содержать только буквы латинского алфавита, цифры и подчеркивания.";
    }
    
    return false;
}

function checkPasswordSymbols($str){
    if (!preg_match('/[A-Za-z]/', $str) || !preg_match('/[0-9]/', $str)) {
        return "должен содержать как минимум одну букву и одну цифру.";
    }
    
    return false;
}

function checkLength($str, int $minLength, int $maxLength){
    if (strlen($str) < $minLength || strlen($str) > $maxLength) {
        return "должен быть от $minLength до $maxLength символов.";
    }
    return false;
}

function checkMinLength($str, int $minLength){
    if (strlen($str) < $minLength) {
        return "должен быть не менее $minLength символов.";
    }
    return false;
}

function login_verify($login){
    $usernames = array_column(getUsers(), "login");

    if(in_array($login, $usernames)) return false;

    return true;
}
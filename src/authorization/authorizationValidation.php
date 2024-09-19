<?php

function validateRegistration($username, $email, $password){
    if(($result = validateUsername($username)) != false) return $result;
    if(($result = validateEmail($email)) != false) return $result;
    if(($result = validatePassword($password)) != false) return $result;

    return false;
}

function validateAuthorization($email, $password){
    if(($result = validateEmail($email)) != false) return $result;
    if(($result = validatePassword($password)) != false) return $result;
    
    return false;
}

function validateUsername($username){
    if(($result = checkLength($username, 3, 20)) != false) return "Логин ".$result;

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
    if(($result = checkMinLength($password, 6)) != false) return "Пароль ".$result;
    
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
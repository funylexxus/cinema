<?php

function validateAuthorization(){}

function validateRegistration(){}

function validateUsername($str){
    trim($str);

    if($str < 3 ) return false;

    return true;
}

function validateDate(){}

function validateDatetime(){}

function validateEmail(){}
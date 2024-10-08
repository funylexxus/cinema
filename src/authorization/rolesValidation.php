<?php

function isAdmin($roleName){
    return $roleName == ROLE_ADMIN;
}

function isEmployee($roleName){
    return $roleName == ROLE_EMPLOYEE;
}

function isUser($roleName){
    return $roleName == ROLE_USER;
}
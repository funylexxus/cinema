<?php
function checkAuthorization(){
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        return true;
    } else {
        return false;
    }
}
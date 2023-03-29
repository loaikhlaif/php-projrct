<?php

if(!function_exists('getUser')){
    function getUser()
    {
        return $_SESSION['user'] ?? null;
    }
}

// set user
if(!function_exists('setUser')){
    function setUser($user)
    {
        $_SESSION['user'] = new User($user);
    }
}
<?php

session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'panissa',
        'db' => 'phpacademy_login',    
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800,  
    ),
    'session' => array(
        'session_name' => 'user' 
    ) 
);

spl_autoload_register(function($class)
{
    $class = str_replace('\\', DIRECTORY_SEPARATOR,$class) . '.php';
    if(file_exists($class))
    {
        require_once $class;
    }
});

require_once "functions/sanitize.php";
<?php

session_start();

define('BASEDIR', __DIR__.'/../');

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
        'session_name' => 'user',
        'csrf-token' => 'csrf-token', 
    ) 
);

spl_autoload_register(function($class)
{
    $class = BASEDIR . str_replace('\\', DIRECTORY_SEPARATOR,$class) . '.php';

    if(file_exists($class))
    {
        require_once $class;
    }
});

require_once __DIR__."/../functions/sanitize.php";
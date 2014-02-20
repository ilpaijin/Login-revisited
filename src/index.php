<?php

use Li\Db;
use Li\Input;

require_once 'core/init.php';

if(Li\Session::exists('success'))
{
    echo Li\Session::flash('success');
}

$users = Db::getInstance()->get("users");

if(!$users->count())
{
    echo "No user";
} else 
{
    foreach($users->results() as $user)
    {
        echo $user->username . "<br />";
    }
} 

$newUser = Db::getInstance()->insert("users", array(
    'username' => 'nuovoutente',
    'password' => 'papaio',
    'salt' => 'salta'
));

var_dump($newUser);

$updateUser = Db::getInstance()->update("users",2, array(
    'salt' => 'nuovoSalt'
));

var_dump($updateUser);
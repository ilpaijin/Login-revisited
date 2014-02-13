<?php

$file = file_get_contents("http://local.dev/various/checkbox_checked.html");
$doc = new DOMDocument();

$doc->loadHTML($file);

var_dump($file);
$xpath = new DOMXPath($doc);

$els = $xpath->query('//input[@checked="checked"]');

foreach ($els as $el) 
{
    var_dump($el->getAttribute('value'));
};

var_dump($doc->saveHtml());
exit;

require_once 'core/init.php';

$users = classes\Db::getInstance()->get("users");
var_dump($users->error());
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


$newUser = classes\Db::getInstance()->insert("users", array(
    'username' => 'nuovoutente',
    'password' => 'papaio',
    'salt' => 'salta'
));

var_dump($newUser);

$updateUser = classes\Db::getInstance()->update("users",2, array(
    'salt' => 'saltafrank',
    'password' => 'nuovaPass', 
));

var_dump($updateUser);
<?php

namespace Li;

/**
* Hash class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class Hash 
{
    public static function make($string, $salt = '')
    {
        return hash('sha256', $string . $salt);
    }

    public static function salt($length)
    {
        return mcrypt_create_iv($length, MCRYPT_DEV_RANDOM);
    }

    public function unique()
    {
        return static::make(uniqid());
    }
}
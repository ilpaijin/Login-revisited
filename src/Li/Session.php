<?php

namespace Li;

/**
Session class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class Session
{
    /**
     * [put description]
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function put($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * [exists description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public static function exists($token)
    {
        return !is_null(static::get($token)) ? true : false;
    }

    /**
     * [get description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * [delete description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public static function delete($key)
    {
        if(static::exists($key))
        {
            unset($_SESSION[$key]);
        }
    }

    /**
     * [flash description]
     * @param  [type] $name   [description]
     * @param  string $string [description]
     * @return [type]         [description]
     */
    public static function flash($name, $string = '')
    {
        if(static::exists($name))
        {
            $session = static::get($name);
            static::delete($name);

            return $session;
        } else 
        {
            static::put($name, $string);
        }

        return '';
    }
}
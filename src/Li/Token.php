<?php

namespace Li;

/**
* Token class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class Token 
{
    /**
     * [generate description]
     * @return [type] [description]
     */
    public static function generate()
    {
        return Session::put(Config::get('session.csrf-token'), md5(uniqid()));
    }

    /**
     * [check description]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public static function check($token)
    {
        $tokenName = Config::get('session.csrf-token');

        if(Session::exists($tokenName) && $token === Session::get($tokenName))
        {
            Session::delete($tokenName);

            return true;
        }

        return false;
    }
}
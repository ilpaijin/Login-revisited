<?php

namespace classes;

/**
* Config class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class Config 
{
    /**
     * [get description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public static function get($key)
    {
        $cf = $GLOBALS['config'];

        foreach(explode('.',$key) as $segment)
        {
            if(isset($cf[$segment]))
            {
                $cf = $cf[$segment];
            }
            else {
                $cf = false;
                break;
            }
        }

        return $cf;
    }
}
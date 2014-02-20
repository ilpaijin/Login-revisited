<?php

namespace Li;

/**
* Input class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class Input 
{
    /**
     * [exists description]
     * @param  string $type [description]
     * @return [type]       [description]
     */
    public static function exists($type = 'post')
    {
        switch($type)
        {
            case "post":
                return (!empty($_POST) ? true : false);
                break;
            case "get":
                return (!empty($_GET) ? true : false);
                break;
            default:
                return false;
                break;        
        }
    }

    /**
     * [get description]
     * @param  [type] $item [description]
     * @return [type]       [description]
     */
    public static function get($item)
    {
        if(isset($_POST[$item]))
        {
            return $_POST[$item];
        } else if(isset($_GET[$item]))
        {
            return $_GET[$item];
        }

        return '';
    }

    /**
     * [all description]
     * @return [type] [description]
     */
    public static function all()
    {
        return array('POST' => $_POST) + array('GET' => $_GET);
    }
}
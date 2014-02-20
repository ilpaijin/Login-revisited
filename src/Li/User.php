<?php

namespace Li;

/**
* User class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class User 
{
    /**
     * [$db description]
     * @var [type]
     */
    private $db;

    /**
     * [__construct description]
     * @param [type] $user [description]
     */
    public function __construct($user = null)
    {
        $this->db = Db::getInstance();
    }

    /**
     * [cretae description]
     * @return [type] [description]
     */
    public function create($fields = array())
    {
        if(!$this->db->insert('users', $fields))
        {
            throw new \Exception(serialize($this->db->error()));
        }
    }

}
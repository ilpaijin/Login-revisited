<?php

namespace classes;

use \PDO;

/**
* Db class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class Db 
{
    /**
     * [$instance description]
     * @var [type]
     */
    private static $instance = null;

    /**
     * [$db description]
     * @var [type]
     */
    private $db;

    /**
     * [$query description]
     * @var [type]
     */
    private $query;

    /**
     * [$error description]
     * @var boolean
     */
    private $error = false;

    /**
     * [$results description]
     * @var [type]
     */
    private $results;

    /**
     * [$count description]
     * @var [type]
     */
    private $count = 0;

    /**
     * [__construct description]
     */
    private function __construct()
    {
        try
        {
            $this->db = new PDO("mysql:host=".Config::get('mysql.host') . "; dbname=".Config::get('mysql.db'), Config::get('mysql.username'), Config::get('mysql.password'));
        } catch( PDOException $e)
        {
            die($e->getMessage());
        }
    }

    /**
     * [getInstance description]
     * @return [type] [description]
     */
    public static function getInstance()
    {
        if(static::$instance === null)
        {
            static::$instance = new static();
        }

        return static::$instance;
    } 

    /**
     * [query description]
     * @param  [type] $sql    [description]
     * @param  array  $fields [description]
     * @return [type]         [description]
     */
    public function query($sql, $fields = array())
    {
        $this->error = false;

        if($this->query = $this->db->prepare($sql))
        {
            if(count($fields) > 0)
            {
                $x = 1;

                foreach ($fields as $param) 
                {
                    $this->query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->query->execute())
            {
                $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                $this->count = $this->query->rowCount();
            } else 
            {
                $this->error = $this->query->errorInfo();
            }
        }

        return $this;
    }

    /**
     * [action description]
     * @param  [type] $method [description]
     * @param  [type] $table  [description]
     * @param  [type] $fields [description]
     * @return [type]         [description]
     */
    public function action($method, $table, $where)
    {
        $sql = "{$method} FROM {$table}";

        if(count($where) === 3)
        {
            list($field, $operator, $value) = $where;

            $operators = array("=","<",">","<=","=>");

            if(in_array($operator, $operators))
            {
                 $sql .= " WHERE {$field} {$operator} ?";
            }
        }
        else 
        {
            $value = null;
        }

        $this->query($sql, array($value));
        
        return $this;
    }

    /**
     * [get description]
     * @param  [type] $table  [description]
     * @param  array  $fields [description]
     * @return [type]         [description]
     */
    public function get($table, $fields = array())
    {
        return $this->action("SELECT *", $table, $fields);
    }

    /**
     * [delete description]
     * @param  [type] $table  [description]
     * @param  array  $fields [description]
     * @return [type]         [description]
     */
    public function delete($table, $fields = array())
    {
        return $this->action("DELETE *", $table, $fields);
    }

    /**
     * [insert description]
     * @param  [type] $table  [description]
     * @param  array  $fields [description]
     * @return [type]         [description]
     */
    public function insert($table, $fields = array())
    {
        if(!isset($fields['joined']))
        {
            $fields['joined'] = date( 'Y-m-d H:i:s', time());
        }
        
        if($fields)
        {
            $keys = implode('`, `', array_keys($fields));
        }

        $placeholders = implode(', ', array_fill(0, count($fields), '?'));

        $sql = "INSERT INTO {$table} (`{$keys}`) VALUES ({$placeholders})";

        if($this->query = $this->query($sql, $fields))
        {
            return $this->results = $this->db->lastInsertId();
        }

        return false;
    }

    /**
     * [update description]
     * @param  [type] $table  [description]
     * @param  [type] $id     [description]
     * @param  array  $fields [description]
     * @return [type]         [description]
     */
    public function update($table, $id, $fields = array())
    {
        if($fields)
        {
            $values = '';

            foreach($fields as $name => $value)
            {
                $values .= $name.'= ?' . (end($fields) != $value ? ', ' : '');
            }
        }

        $sql = "UPDATE {$table} SET {$values} WHERE id = {$id}";

        $this->query = $this->query($sql, $fields);
        $this->results = $fields;

        return $this;

    }

    /**
     * [results description]
     * @return [type] [description]
     */
    public function results()
    {
        return $this->results;
    }

    /**
     * [take description]
     * @param  [type] $limit [description]
     * @return [type]        [description]
     */
    public function take($limit)
    {
        if($this->count > 0)
        {
            $this->results = array_chunk($this->results, $limit)[0];
        }
        return $this;
    }

    /**
     * [error description]
     * @return [type] [description]
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * [count description]
     * @return [type] [description]
     */
    public function count()
    {
        return $this->count;
    }
}
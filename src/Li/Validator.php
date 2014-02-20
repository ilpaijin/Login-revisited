<?php

namespace Li;

/**
* Validator class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class Validator 
{
    /**
     * [$error description]
     * @var [type]
     */
    private $errors = array();

    /**
     * [$data description]
     * @var [type]
     */
    private $data;

    /**
     * [$rules description]
     * @var [type]
     */
    public $rules = array();

    /**
     * [$csrf description]
     * @var boolean
     */
    private $csrf;

    /**
     * [__construct description]
     * @param [type] $options [description]
     */
    public function __construct($options = array())
    {
        $this->csrf = isset($option['csrf']) ? $option['csrf'] : false;
    }
    /**
     * [validate description]
     * @param  [type] $data  [description]
     * @param  array  $rules [description]
     * @return [type]        [description]
     */
    public function validate($data = array())
    {
        $this->errors = array();

        if(!$data)
        {
            $this->errors['fatal'] = "Undefined data to validate";
            return $this;
        }
        
        $this->data = $data;

        foreach ($this->rules as $field => $rule)
        {
            if(isset($this->data[$field]))
            {
                if(!$rule->validate($this->data))
                {
                    $this->errors[$field] = $rule->getErrors();
                }
            }
            else 
            {
                $this->errors[$field] = "Missing " . $field;
            }
        }

        return $this;
    }

    /**
     * [addRules description]
     * @param array $rules [description]
     */
    public function addRules($rules = array())
    {
        array_walk($rules, function($rule, $field)
        {
            $this->rules[$field] = new Validator\Rule($field, $rule);
        });

        return $this;
    }

    /**
     * [error description]
     * @return [type] [description]
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * [passes description]
     * @return [type] [description]
     */
    public function passes()
    {
        return $this->errors() ? false : true;
    }

    /**
     * [__call description]
     * @param  [type] $method [description]
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public function __call($method, $params)
    {
        $methodExists = preg_match_all("/([A-Z]?[a-z_]+)/", $method, $matches);
 
        list($method, $key) = $matches[0];

        if(!method_exists($this, $method))
        {
            throw new \InvalidArgumentException('Undefined method ' . $method);
        }

        if(!isset($this->{$method}()[strtolower($key)]))
        {
            throw new \InvalidArgumentException('Undefined key ' . $key);
        }

        return implode(" | ",$this->{$method}()[strtolower($key)]);
    }
}
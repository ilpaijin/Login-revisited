<?php

namespace Li\Validator;

/**
* Rules class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class Rule
{
    /**
     * [$field description]
     * @var [type]
     */
    private $field;

    /**
     * [$actions description]
     * @var array
     */
    private $actions = array();

    /**
     * [$error description]
     * @var [type]
     */
    private $errors;


    /**
     * [__construct description]
     * @param [type] $rulesString [description]
     */
    public function __construct($field, $checklist)
    {
        $this->field = $field;

        foreach(explode('|', $checklist) as $check)
        {
            list($action, $param) = array_pad(explode(":",$check), 2, true);
            
            $this->actions[$action] = $param;
        }
    }

    /**
     * [valid description]
     * @return [type] [description]
     */
    public function validate($value)
    {
        $valid = true;

        foreach($this->actions as $action => $param)
        {
            if(!$this->{$action}($value[$this->field], $param, $value))
            {
                $valid = false;
            }
        }

        return $valid;
    }


    /**
     * [required description]
     * @param  [type] $field [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function required($value)
    {
        if(!$value)
        {
            $this->errors['required'] = "Field required";
            return false;
        }

        return true;
    }

    /**
     * [char description]
     * @param  [type] $field [description]
     * @param  [type] $value [description]
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    public function max($value, $param)
    {
        if(strlen($value) > $param)
        {
            $this->errors['max'] = "max char ".$param;
            return false;
        }

        return true;
    }

    /**
     * [max description]
     * @param  [type] $field [description]
     * @param  [type] $value [description]
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    public function min($value, $param)
    {
        if(!$this->required($value))
        {
            return false;
        }

        if(strlen($value) < $param)
        {
            $this->errors['min'] = "min char ".$param;
            return false;
        }

        return true;
    }

    /**
     * [equals description]
     * @param  [type] $field [description]
     * @param  [type] $value [description]
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    public function equals($value, $param, $data)
    {
        if($value != $data[$param])
        {
            $this->errors['equals'] = "must be equals to ".$param." field";
            return false;
        }

        return true;
    }

    /**
     * [unique description]
     * @param  [type] $field [description]
     * @param  [type] $value [description]
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    public function unique($value, $param)
    {
        return true;
    }

    /**
     * [getError description]
     * @return [type] [description]
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
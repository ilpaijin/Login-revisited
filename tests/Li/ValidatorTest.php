<?php

/**
* ValidatorTest class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class ValidatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->validator = new Li\Validator;
    }

    public function tearDown()
    {
        $this->validator = null;
    }

    public function testIsInstanceOfValidator()
    {
        $this->assertInstanceOf('Li\Validator', $this->validator);
    }

    public function testValidateReturnsFatalIfEmptyOrNoDataPassed()
    {
        $data = array();

        $validation = $this->validator->addRules(array(
            'username' => 'required|max:5',
        ))->validate($data);

        $this->assertEquals($validation->errors()['fatal'], "Undefined data to validate");
    }

    public function testValidateReturnsMissingDataPassed()
    {
        $data = array(
            'username' => 'Paio', 
        );

        $validation = $this->validator->addRules(array(
            'username' => 'required|max:5',
            'age' => 'max:28', 
        ))->validate($data);

        $this->assertEquals($validation->errors()['age'], "Missing age");
    }

    public function testCheckPassesMethod()
    {
        $data = array(
            'username' => 'Paio', 
        );

        $validation = $this->validator->addRules(array(
            'username' => 'required|max:5'
        ))->validate($data);

        $this->assertTrue($validation->passes());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrownAnExceptionIfErrorsMagicMethodKeyDoesnExists()
    {
        $data = array(
            'username' => 'Paioooo',
        );

        $validation = $this->validator->addRules(array(
            'username' => 'required|max:5',
        ))->validate($data);

        $validation->errorsUsernames();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrownAnExceptionIfErrorsMagicMethodDoesnExists()
    {
        $data = array(
            'username' => 'Paioooo',
        );

        $validation = $this->validator->addRules(array(
            'username' => 'required|max:5',
        ))->validate($data);

        $validation->errorUsername();
    }

    public function testFailEveryChainedRule()
    {
        $data = array(
            'username' => 'Paioooo',
        );

        $validation = $this->validator->addRules(array(
            'username' => 'required|max:5',
        ))->validate($data);

        $this->assertEquals($validation->errors()['username']['max'], "max char 5");
    }

    public function testItFailsByTheFirstImplicitRule()
    {
        $data = array(
            'username' => 'Paioo',
            'password' => '',  
        );

        $validation = $this->validator->addRules(array(
            'username' => 'required|max:5',
            'password' => 'min:3', //implicit "required"
        ))->validate($data);

        $this->assertEquals($validation->errorsPassword(), 'Field required');
    }

    public function testItFailsIfDataExceedMinRule()
    {
        $data = array(
            'username' => 'Paioo',
            'password' => '12',  
        );

        $validation = $this->validator->addRules(array(
            'username' => 'required|max:5',
            'password' => 'min:3', //implicit "required"
        ))->validate($data);

        $this->assertEquals($validation->errorsPassword(), 'min char 3');
    }

    public function testItFailsIfDataIsNotEqualsToPassword()
    {
        $data = array(
            'username' => 'Paio',
            'password' => '123',  
            'password_again' => '',  
        );

        $validation = $this->validator->addRules(array(
            'username' => 'required|max:5',
            'password' => 'min:3',
            'password_again' => 'equals:password',
        ))->validate($data);

        $this->assertTrue(isset($validation->errors()['password_again']));
    }
}
<?php

namespace App\Dtos;

use Illuminate\Support\Facades\Validator;

abstract class AbstractDto implements IDto
{
    /**
     * The Dto properties
     * 
     * @var array
     */
    protected $properties;

    /**
     * AbstractDto constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->validateParams($params);
        $this->properties = $params;
    }

    /**
     * Validate the dto params
     * 
     * @param  array  $params
     * @throws InvalidArgumentException
     */
    private function validateParams(array $params) : void
    {
        $validator = Validator::make($params, $this->configureValidationRules());
        $validator->validate();
    }

    /**
     * Define all validation rules
     * 
     * @return array Validation rules
     */
    protected abstract function configureValidationRules() : array;

    /**
     * Return all properties
     * 
     * @return array All properties
     */
    public function getAllProperties() : array
    {
        return $this->properties;
    }

    /**
     * Return a prop
     * 
     * @param  string   $prop
     * @return mixed    The param or null if not exists
     */
    public function __get(string $prop)
    {
        if (array_key_exists($prop, $this->properties)) {
            return $this->properties[$prop];
        }

        return null;
    }
}

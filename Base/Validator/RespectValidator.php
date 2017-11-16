<?php
/*
 * This file is part of the BasePlatform project.
 *
 * @link https://github.com/BasePlatform
 * @license https://github.com/BasePlatform/Base/blob/master/LICENSE.txt
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Base\Validator;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Respect Validator
 *
 * @package Base\Validator
 */
class RespectValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    public $errors = null;

    /**
     * {@inheritdoc}
     */
    public function validate($data, array $rules = []): bool
    {
        $this->errors = null;
        foreach ($rules as $key => $rule) {
            if (is_array($rule) && isset($rule[0], $rule[1])) {
                if (!is_array($data) && !is_object($data)) {
                    throw new InvalidArgumentException('Unsupported Data Type: Data Must Be Array Or Object Type.');
                }
                // Get the property and validation rule
                $property = $rule[0];
                $propertyRule = $rule[1];
                $propertyValue = $this->getPropertyValueFromData($data, $property);
                $propertyRuleMessage = $rule['message'] ?? null;
                if ($propertyRuleMessage) {
                    unset($rule['message']);
                }
                // Implement for the 'required' rule
                $hasRequiredRule = false;
                if (is_string($propertyRule) && (trim($propertyRule) == 'required')) {
                    $hasRequiredRule = true;
                    // Remove required rule
                    $propertyRule = null;
                }
                if (is_array($propertyRule) && (in_array('required', $propertyRule))) {
                    $hasRequiredRule = true;
                    $propertyRule = array_diff($propertyRule, ['required']);
                    $propertyRule = array_values($propertyRule);
                }
                if ($hasRequiredRule && (empty($propertyValue))) {
                    $this->errors = [$propertyRuleMessage ? sprintf($propertyRuleMessage, ucfirst($property)) : sprintf('%s is required', ucfirst($property))];
                }
                if (!empty($propertyRule)) {
                    // Check for other rules
                    // Get remaining params
                    $params = array_slice($rule, 2);
                    // Create the validator
                    $validator = null;
                    if (is_array($propertyRule)) {
                        for ($i = 0; $i < count($propertyRule); $i++) {
                            $propertyRule[$i] = trim($propertyRule[$i]);
                            if (!$validator) {
                                // First rule, create the validator
                                $validator = call_user_func([v::class, $propertyRule[$i]]);
                            } elseif ($i == count($propertyRule) - 1) {
                                // Support last rule call with params
                                $validator = $this->callValidatorWithArguments('\Respect\Validation\Rules\\'.ucfirst($propertyRule[$i]), $propertyRule[$i], $params);
                            } else {
                                // Not last rule, call without params
                                $validator = $validator->$propertyRule[$i]();
                            }
                        }
                    } else {
                        $validator = $this->callValidatorWithArguments('\Respect\Validation\Rules\\'.ucfirst($propertyRule), $propertyRule, $params);
                    }
                    $validator->setName(ucfirst($property));
                    try {
                        $validator->assert($propertyValue);
                    } catch (NestedValidationException $exception) {
                        if (is_string($propertyRule) && $propertyRuleMessage) {
                            $errors = $exception->findMessages([
                              $propertyRule => $propertyRuleMessage
                            ]);
                        } else {
                            $errors = $exception->getMessages();
                        }
                        $this->errors[] = $errors;
                    }
                }
            } else {
                throw new InvalidArgumentException('Invalid Validation Rule: A Rule Must Specify Both Attribute Name And Validator Type.');
            }
        }
        if (!$this->errors) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Call Validator with Arguments
     *
     * @param  string $class  Validator Rule Class
     * @param  string $method
     * @param  array $params
     * @return \Respect\Validation\Validator
     */
    protected function callValidatorWithArguments($class, $method, $params = [])
    {
        $arguments = [];
        $reflectionmethod = new \ReflectionMethod($class, '__construct');
        foreach ($reflectionmethod->getParameters() as $arg) {
            if (isset($params[$arg->name])) {
                $arguments[$arg->name] = $params[$arg->name];
            } else if ($arg->isDefaultValueAvailable()) {
                $arguments[$arg->name] = $arg->getDefaultValue();
            } else {
                $arguments[$arg->name] = null;
            }
        }
        return call_user_func_array([v::class, $method], $arguments);
    }

    /**
     * Get Property Value rom Data
     *
     * It supports direct access or access from get method
     *
     * @param  array|object $data
     * @param  string $property
     * @return mixed
     */
    protected function getPropertyValueFromData($data, $property)
    {
        if (is_array($data)) {
            $propertyValue = $data[$property] ?? null;
            return $propertyValue;
        } elseif (is_object($data)) {
            // Access stdObject
            $properties = array_filter(get_object_vars($data));
            if (isset($properties[$property])) {
                return $data->$property;
            }
            // Implement for get Method()
            $getMethod = 'get'.ucfirst($property);
            if (method_exists($data, $getMethod)) {
                return $data->$getMethod();
            }
            // Access based on class definition
            $properties = get_class_vars(get_class($data));
            if (isset($properties[$property])) {
                return $data->$property;
            }
        }
        return null;
    }
}

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

/**
 * Respect Validator
 *
 * @package Base\Validator
 */
class RespectValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate($data, array $rules = []): bool
    {
        foreach ($rules as $key => $rule) {
            if (is_array($rule) && isset($rule[0], $rule[1])) {
                // Implement for the required rule

                // Get the property and validation rule

                $ruleMessage = $rule['message'] ?? null;
                if ($ruleMessage) {
                    unset($rule['message']);
                }
            } else {
                throw new InvalidArgumentException('Invalid Validation Rule: A Rule Must Specify Both Attribute Name And Validator Type.');
            }
        }
    }
}

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

$service = 'base';

return [
  'policies' => [
    'app.internalServiceRequest' => [
        'service' => $service,
        'type' => 'permission',
        'zone' => 'system',
        'description' => 'Policy for Internal Service Request'
    ],
    'app.systemAdmin' => [
        'service' => $service,
        'type' => 'role',
        'zone' => 'system',
        'description' => 'System Admin'
    ]
  ]
];

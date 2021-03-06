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

$appId = 'default';
$roleType = 'role';
$adminZone = 'admin';

return [
  'policies' => [
    'tenant.tenantOwner' => [
        'appId' => $appId,
        'type' => $roleType,
        'zone' => $adminZone,
        'description' => 'Tenant Owner'
    ]
  ]
];

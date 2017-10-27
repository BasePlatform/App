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

return [
  'resources' => [
    // Configure for ORM
    'orm' => [
      'entityPaths' => [
        __DIR__ . '/../src/Entity',
        __DIR__ . '/../src/ValueObject'
      ]
    ],
    // Configure for ODM
    'odm' => [
    ]
  ]
];
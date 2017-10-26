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
require __DIR__.'/../bootstrap/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;

/**
 * Get the container
 */
$container = require_once __DIR__.'/../bootstrap/container.php';

$entityManager = new Base\Factory\EntityManagerFactory($config->getAll());

return ConsoleRunner::createHelperSet($entityManager);

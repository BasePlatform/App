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

namespace Base\Event;

/**
 * Event Interface
 *
 * @package Base\Event
 */
interface EventInterface
{
    /**
     * Return name of the Event
     *
     * @return string
     */
    public function getName(): string;
}

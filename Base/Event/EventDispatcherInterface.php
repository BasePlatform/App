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
 * Event Dispatcher Interface
 *
 * @package Base\Event
 */
interface EventDispatcherInterface
{
    /**
     * Register Listener to Event
     *
     * @param  string            $name     Event name
     * @param  ListenerInterface $listener
     *
     * @return void
     */
    public function registerListener(string $name, ListenerInterface $listener);

    /**
     * Check Event name has listeners
     *
     * @param  string            $name     Event name
     *
     * @return boolean
     */
    public function hasListeners(string $name): bool;

    /**
     * Dispatch the Event(s)
     *
     * @param  array|string $events
     * @return mixed
     */
    public function dispatch($events);
}

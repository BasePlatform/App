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
 * Event Dispatcher
 *
 * @package Base\Event
 */
class EventDispatcher
{
    /**
     * @var Global Events Listeners
     */
    protected $listeners = [];

    /**
     * @var Container
     */
    private $container;

    /**
     * @param object $container
     */
    public function __construct($container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function registerListener(string $name, ListenerInterface $listener)
    {
        $this->listeners[$name][] = $listener;
    }

    /**
     * {@inheritdoc}
     */
    public function hasListeners(string $name): bool
    {
        return isset($this->listeners[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch($events)
    {
        if (is_array($events)) {
            $this->fireEvents($events);
        } elseif ($events instanceof EventInterface) {
            $this->fireEvent($events);
        } else {
            throw new \InvalidArgumentException('Invalid Event(s) Type');
        }
    }

    /**
     * Fire multiple events
     *
     * @param  array  $events
     * @return void
     */
    private function fireEvents(array $events)
    {
        foreach ($events as $event) {
            if ($event instanceof EventInterface) {
                $this->fireEvent($event);
            }
        }
    }

    /**
     * Fire s single event
     *
     * @param  EventInterface  $events
     * @return void
     */
    private function fireEvent(EventInterface $event)
    {
        $listeners = [];
        if ($this->hasListeners($event->getName())) {
            $listeners = $this->listeners[$event->getName()];
        }
        // Use a container or not
        if ($this->container) {
            $containerFunction = 'get';
            if (method_exists($this->container, 'make')) {
                $containerFunction = 'make';
            }
            foreach ($listeners as $listenerDef) {
                $listener = $this->container->$containerFunction($listenerDef);
                $listener->handle($event);
            }
        } else {
            foreach ($listeners as $listener) {
                $listener->handle($event);
            }
        }
    }
}

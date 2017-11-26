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
 * Has Events Trait
 *
 * @package Base\Event
 */
trait HasEventsTrait
{
    /**
     * @var SplObjectStorage
     */
    protected $events;

    /**
     * Add Event
     *
     * @param EventInterface $event
     */
    public function addEvent(EventInterface $event)
    {
        if (!$this->events) {
            $this->events = new \SplObjectStorage();
        }
        if ($this->events->contains($event)) {
            $this->events->detach($event);
        }
        $this->events->attach($event);
    }

    /**
     * Remove Event
     *
     * @param EventInterface $event
     */
    public function removeEvent(EventInterface $event)
    {
        if (empty($this->events)) {
            return;
        }
        if ($this->events->contains($event)) {
            $this->events->detach($event);
        }
    }

    /**
     * Get Events
     *
     * @param SplObjectStorage
     */
    public function getEvents(): ?SplObjectStorage
    {
        if (empty($this->events)) {
            return null;
        }
        return $this->events;
    }
}

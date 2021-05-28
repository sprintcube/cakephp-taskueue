<?php

namespace Taskueue\Queue;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Josegonzalez\CakeQueuesadilla\Queue\Queue;
use josegonzalez\Queuesadilla\Job;

class QueueManager
{
    /**
     * Places an event in the job queue
     *
     * @param Event $event Cake Event
     * @param array $options Options
     * @return void
     */
    public static function queue(Event $event, array $options = [])
    {
        Queue::push(
            '\Taskueue\Queue\QueueManager::dispatchEvent',
            [get_class($event), $event->getName(), $event->getData()],
            $options
        );
    }

    /**
     * Constructs and dispatches the event from a job
     *
     * ### Data array
     * - 0: event FQCN
     * - 1: event name
     * - 2: event data array
     *
     * @param Job\Base $job Job
     * @return void
     */
    public static function dispatchEvent($job)
    {
        $eventClass = $job->data(0);
        $eventName = $job->data(1);
        $data = $job->data(2, []);

        $event = new $eventClass($eventName, null, $data);
        EventManager::instance()->dispatch($event);
    }
}

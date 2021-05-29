<?php

use Cake\Core\Configure;
use Josegonzalez\CakeQueuesadilla\Queue\Queue;

/**
 * Load configuration
 */
Queue::setConfig(Configure::consume('Taskueue.Queuesadilla'));

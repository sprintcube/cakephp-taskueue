<?php
namespace Taskueue\Shell;

use Cake\Datasource\ConnectionManager;
use Josegonzalez\CakeQueuesadilla\Shell\QueuesadillaShell;
use josegonzalez\Queuesadilla\Worker\Base as BaseWorker;

/**
 * Queue shell command.
 */
class QueueShell extends QueuesadillaShell
{

    /**
     * Retrieves a queue worker
     *
     * @param \josegonzalez\Queuesadilla\Engine\Base $engine engine to run
     * @param \Psr\Log\LoggerInterface $logger logger
     * @return \josegonzalez\Queuesadilla\Worker\Base
     */
    public function getWorker($engine, $logger): BaseWorker
    {
        $worker = parent::getWorker($engine, $logger);

        $worker->attachListener('Worker.job.success', function ($event) {
            ConnectionManager::get('default')->disconnect();
        });
        $worker->attachListener('Worker.job.failure', function ($event) {
            ConnectionManager::get('default')->disconnect();
        });

        return $worker;
    }
}

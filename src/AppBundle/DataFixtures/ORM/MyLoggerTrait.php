<?php

namespace AppBundle\DataFixtures\ORM;

use Symfony\Component\Console\Output\ConsoleOutput;

trait MyLoggerTrait
{
    protected $logger;

    /**
     * Set the logger callable to execute with the log() method.
     */
    public function setLogger()
    {
        $output = new ConsoleOutput();

        $this->logger = function ($message) use ($output) {
            $output->writeln(sprintf('  <comment>></comment> <info>%s</info>', $message));
        };
    }

    /**
     * Logs a message using the logger.
     *
     * @param string $message
     */
    public function log($message)
    {
        if ($this->logger) {
            $logger = $this->logger;
            $logger($message);
        }
    }
}

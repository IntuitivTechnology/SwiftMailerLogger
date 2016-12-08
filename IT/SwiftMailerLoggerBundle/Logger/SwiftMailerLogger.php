<?php
/**
 * Created by PhpStorm.
 * User: pvassoilles
 * Date: 07/12/16
 * Time: 15:50
 */

namespace IT\SwiftMailerLoggerBundle\Logger;

use Psr\Log\LoggerInterface;
use Swift_Events_SendEvent;
use Swift_Events_SendListener;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SwiftMailerLogger
{

    /** @var LoggerInterface $logger */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->logger, $name)) {
            $this->logger->$name($arguments[0]);
        } else {
            throw new \BadMethodCallException(sprintf('Attempt to call a non-existent method %s on class %s', $name, get_class($this)));
        }
    }


}
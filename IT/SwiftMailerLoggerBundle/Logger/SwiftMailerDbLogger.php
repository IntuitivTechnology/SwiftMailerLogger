<?php
/**
 * Created by PhpStorm.
 * User: pvassoilles
 * Date: 08/12/16
 * Time: 10:05
 */

namespace IT\SwiftMailerLoggerBundle\Logger;


use Doctrine\ORM\EntityManager;
use IT\SwiftMailerLoggerBundle\Entity\SwiftMailerLog;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SwiftMailerDbLogger
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function log($from, $to, $cc = null, $bcc = null, $subject = null, $message = null)
    {

        $log = new SwiftMailerLog();

        $log
            ->setFrom($from)
            ->setTo($to)
            ->setCc($cc)
            ->setBcc($bcc)
            ->setSubject($subject)
            ->setMessage($message)
            ->setSentAt(new \DateTime('now'))
        ;

        $this->getEntityManager()->persist($log);
        $this->getEntityManager()->flush($log);
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->container->get('doctrine.orm.entity_manager');
    }

}
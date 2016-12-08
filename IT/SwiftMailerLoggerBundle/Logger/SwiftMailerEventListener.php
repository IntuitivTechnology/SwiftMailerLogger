<?php
/**
 * Created by PhpStorm.
 * User: pvassoilles
 * Date: 07/12/16
 * Time: 17:19
 */

namespace IT\SwiftMailerLoggerBundle\Logger;

use Psr\Log\LoggerInterface;
use Swift_Events_SendEvent;
use Swift_Events_SendListener;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SwiftMailerEventListener implements Swift_Events_SendListener
{

    /** @var ContainerInterface $container */
    protected $container;

    /** @var SwiftMailerDbLogger $dbLogger */
    protected $dbLogger;

    /** @var boolean $enableDbLogger */
    protected $enableDbLogger;

    public static $mailsSent = array();

    public function __construct(ContainerInterface $container, SwiftMailerDbLogger $dbLogger, $enableDbLogger)
    {
        $this->container = $container;
        $this->dbLogger = $dbLogger;
        $this->enableDbLogger = $enableDbLogger;
    }

    /**
     * Logs before sending email
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function beforeSendPerformed(Swift_Events_SendEvent $evt)
    {

        if (!in_array($evt->getMessage()->getId(), self::$mailsSent)) {

            $recipients = $this->getMessageRecipients($evt);

            $this->getLogger()->info('-----------------------------------------------------------------------------------------');
            $this->getLogger()->info(sprintf('Preparing to send an email to %s (CC: %s  / BCC: %s)', $recipients['to'], $recipients['cc'], $recipients['bcc']));

            $this->getLogger()->debug('Subject : ' . $evt->getMessage()->getSubject());
            $this->getLogger()->debug('Message : ' . $evt->getMessage()->getBody());

        }

    }

    /**
     * Log after sending email
     *
     * @param Swift_Events_SendEvent $evt
     */
    public function sendPerformed(Swift_Events_SendEvent $evt)
    {

        if (!in_array($evt->getMessage()->getId(), self::$mailsSent)) {

            $recipients = $this->getMessageRecipients($evt);

            $this->getLogger()->info(sprintf('Mail sent to: %s (CC: %s / BCC: %s) - %s - #%s', $recipients['to'], $recipients['cc'], $recipients['bcc'], $evt->getMessage()->getSubject(), $evt->getMessage()->getId()));

            if ($this->enableDbLogger) {
                $this->dbLogger->log($recipients['to'], $recipients['cc'], $recipients['bcc'], $evt->getMessage()->getSubject(), $evt->getMessage()->getBody());
            }

            self::$mailsSent[] = $evt->getMessage()->getId();

        }
    }

    /**
     * Returns all email recipients (to, cc & bcc)
     *
     * @param Swift_Events_SendEvent $evt
     *
     * @return array
     */
    protected function getMessageRecipients(Swift_Events_SendEvent $evt)
    {
        $to = $evt->getMessage()->getTo();
        if (is_array($to)) {
            $to = implode('; ', array_keys($to));
        }

        $cc = $evt->getMessage()->getCc();
        if (is_array($cc)) {
            $cc = implode('; ', array_keys($cc));
        }

        $bcc = $evt->getMessage()->getBcc();
        if (is_array($bcc)) {
            $bcc = implode('; ', array_keys($bcc));
        }

        return array(
            'to' => $to,
            'cc' => $cc,
            'bcc' => $bcc,
        );
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->container->get('it.swift_mailer_logger');
    }


}
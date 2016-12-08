<?php
/**
 * Created by PhpStorm.
 * User: pvassoilles
 * Date: 08/12/16
 * Time: 09:06
 */

namespace IT\SwiftMailerLoggerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class SwiftMailerLog
 *
 * @package EntityBundle\Entity
 *
 * @ORM\Entity(repositoryClass="IT\SwiftMailerLoggerBundle\Entity\Repository\SwiftMailerLogRepository")
 * @ORM\Table(name="it_swift_mailer_log")
 */
class SwiftMailerLog
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="`to`", type="text", nullable=false)
     */
    protected $to;

    /**
     * @var string
     *
     * @ORM\Column(name="`cc`", type="text", nullable=true)
     */
    protected $cc;

    /**
     * @var string
     *
     * @ORM\Column(name="`bcc`", type="text", nullable=true)
     */
    protected $bcc;

    /**
     * @var string
     *
     * @ORM\Column(name="`subject`", type="text", nullable=true)
     */
    protected $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="`message`", type="text", nullable=true)
     */
    protected $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="`sent_at`", type="datetime", nullable=false)
     */
    protected $sentAt;

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @param string $cc
     */
    public function setCc($cc)
    {
        $this->cc = $cc;
        return $this;
    }

    /**
     * @return string
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @param string $bcc
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * @param \DateTime $sentAt
     */
    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;
        return $this;
    }

}
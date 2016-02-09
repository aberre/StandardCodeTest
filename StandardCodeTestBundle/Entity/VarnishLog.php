<?php

namespace VG\StandardCodeTestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VarnishLog
 *
 * @ORM\Table(name="varnish_log")
 * @ORM\Entity(repositoryClass="VG\StandardCodeTestBundle\Repository\VarnishLogRepository")
 */
class VarnishLog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Host", type="string", length=255)
     */
    private $host;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Timestamp", type="datetime")
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="RequestUri", type="text")
     */
    private $requestUri;

    /**
     * @var int
     *
     * @ORM\Column(name="Status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="Referer", type="string", length=255)
     */
    private $referer;

    /**
     * @var string
     *
     * @ORM\Column(name="UserAgent", type="string", length=255)
     */
    private $userAgent;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set host
     *
     * @param string $host
     * @return VarnishLog
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return string 
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return VarnishLog
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set requestUri
     *
     * @param string $requestUri
     * @return VarnishLog
     */
    public function setRequestUri($requestUri)
    {
        $this->requestUri = $requestUri;

        return $this;
    }

    /**
     * Get requestUri
     *
     * @return string 
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return VarnishLog
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set referer
     *
     * @param string $referer
     * @return VarnishLog
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string 
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set userAgent
     *
     * @param string $userAgent
     * @return VarnishLog
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string 
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }
}

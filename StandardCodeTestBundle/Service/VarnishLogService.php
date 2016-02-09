<?php

namespace VG\StandardCodeTestBundle\Service;


use Doctrine\ORM\EntityManager;
use VG\StandardCodeTestBundle\Entity\VarnishLog;

class VarnishLogService
{
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repo = $this->em->getRepository('StandardCodeTestBundle:VarnishLog');
    }

    public function setLogData($rawText) {
        echo $rawText;
    }
    public function run($log)
    {
        $parser = new \Kassner\LogParser\LogParser();

        $parser->setFormat('%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-agent}i\"');
        $this->truncateLog();
        $lines = explode("\n", $log);
        foreach ($lines as $line) {
            $entry = $parser->parse($line);
            $requestURIParts = explode(' ', $entry->request);

            $logLine = new VarnishLog();
            $logLine->setHost($entry->host);
            $logLine->setReferer($entry->HeaderReferer);
            $logLine->setRequestUri($requestURIParts[1]);
            $logLine->setStatus($entry->status);
            $logLine->setUserAgent($entry->HeaderUseragent);
            $logLine->setTimestamp(new \DateTime($entry->time));
            $this->em->persist($logLine);
            $this->em->flush();
        }
    }
    public function truncateLog() {

        $connection = $this->em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql('varnish_log');
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }
}
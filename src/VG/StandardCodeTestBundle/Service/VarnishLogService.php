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

    /**
     * Insert Raw Varnish data into database
     *
     * @param $log
     * @throws \Kassner\LogParser\FormatException
     */
    public function importDataFromLogFile($log)
    {
        $parser = new \Kassner\LogParser\LogParser();
        $parser->setFormat('%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-agent}i\"');

        $lines = explode("\n", $log);
        foreach ($lines as $line) {
            if ( strlen(trim($line)) > 0 ) {

                $entry = $parser->parse($line);
                $requestURIParts = explode(' ', $entry->request);

                $logLine = new VarnishLog();
                $logLine->setHost($entry->host);
                $logLine->setReferer($entry->HeaderReferer);
                $logLine->setRequestUri($requestURIParts[1]);
                $logLine->setStatus($entry->status);
                $logLine->setUserAgent($entry->HeaderUseragent);

                $this->em->persist($logLine);
                $this->em->flush();
            }
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function truncateLog() {
        $connection = $this->em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql('varnish_log');
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * @return mixed
     */
    public function countRows() {
        return $this->repo->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param int $limit
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getTopHosts( $limit=5 ) {
        $connection = $this->em->getConnection();
        $statement = $connection->prepare("SELECT count(*) as sums, vl.host FROM varnish_log as vl GROUP BY vl.host ORDER BY sums DESC LIMIT :limit");
        $statement->bindValue('limit', $limit, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * @param int $limit
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getTopDownloaded( $limit=5 ) {
        $connection = $this->em->getConnection();
        $statement = $connection->prepare("SELECT count(*) as sums, vl.requestUri FROM varnish_log as vl GROUP BY vl.requestUri ORDER BY sums DESC LIMIT :limit");
        $statement->bindValue('limit', $limit, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
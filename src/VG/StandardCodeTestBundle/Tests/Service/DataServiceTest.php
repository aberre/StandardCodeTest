<?php

namespace VG\StandardCodeTestBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use VG\StandardCodeTestBundle\Service\DataService;

/**
 * Functional tests to check connection to 3rd part data storage and their response type.
 *
 */
class DataServiceTest extends WebTestCase
{
    public function testConnectionAndResponseDataForRSSFeed()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $dataService = new DataService();
        $dataService->call($container->getParameter('rss_url'));

        $this->assertEquals(200, $dataService->getStatusCode());
        $this->assertEquals("application/rss+xml", $dataService->getResponseType());
        $this->assertEquals('object', gettype($dataService->getResponse()));
    }
    public function testConnectionAndResponseDataForJsonFeed()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $dataService = new DataService();
        $dataService->call($container->getParameter('json_url'));

        $this->assertEquals(200, $dataService->getStatusCode());
        $this->assertEquals("application/json", $dataService->getResponseType());
        $this->assertEquals('array', gettype($dataService->getResponse()));
    }

    public function testConnectionAndResponseDataForVarnishLog()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $dataService = new DataService();
        $dataService->call($container->getParameter('varnish_log_url'));

        $this->assertEquals(200, $dataService->getStatusCode());
        $this->assertEquals("text/plain", $dataService->getResponseType());
    }
}
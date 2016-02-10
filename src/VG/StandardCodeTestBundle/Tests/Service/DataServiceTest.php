<?php
/**
 * Created by PhpStorm.
 * User: andersberre
 * Date: 09.02.2016
 * Time: 20.10
 */

namespace VG\StandardCodeTestBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use VG\StandardCodeTestBundle\Service\DataService;

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
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

        $dataService = new DataService();
        $dataService->call('http://www.vg.no/rss/feed/forsiden/?frontId=1');

        $this->assertEquals(200, $dataService->getStatusCode());
        $this->assertEquals("application/rss+xml", $dataService->getResponseType());
        $this->assertEquals('object', gettype($dataService->getResponse()));
    }
    public function testConnectionAndResponseDataForJsonFeed()
    {
        $client = static::createClient();

        $dataService = new DataService();
        $dataService->call('http://rexxars.com/playground/testfeed/');

        $this->assertEquals(200, $dataService->getStatusCode());
        $this->assertEquals("application/json", $dataService->getResponseType());
        $this->assertEquals('array', gettype($dataService->getResponse()));
    }

    public function testConnectionAndResponseDataForVarnishLog()
    {
        $client = static::createClient();

        $dataService = new DataService();
        $dataService->call('http://tech.vg.no/intervjuoppgave/varnish.log');

        $this->assertEquals(200, $dataService->getStatusCode());
        $this->assertEquals("text/plain", $dataService->getResponseType());
    }
}
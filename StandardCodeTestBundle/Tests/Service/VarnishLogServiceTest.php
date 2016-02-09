<?php
namespace VG\StandardCodeTestBundle\Tests\Service;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class VarnishLogServiceTest extends WebTestCase
{
    public function testFlushAndReloadVarnishLogDatabase()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $varnishLogService = $container->get('standard_code_test.varnishlog');
        $varnishLogService->truncateLog();

        $this->assertEquals(0, $varnishLogService->countRows());

        $varnishRawLog = $container->get('standard_code_test.dataservice')->call('http://tech.vg.no/intervjuoppgave/varnish.log');
        $varnishLogService->importData($varnishRawLog);

        $this->assertGreaterThan(0, $varnishLogService->countRows());
    }
    public function testCalculateStatsFromVarnishLog() {

        $client = static::createClient();
        $container = $client->getContainer();

        $varnishLogService = $container->get('standard_code_test.varnishlog');

        $this->assertEquals(5, $varnishLogService->getTopHosts(5));
        $this->assertEquals(5, $varnishLogService->getTopDownloaded(5));
    }
}
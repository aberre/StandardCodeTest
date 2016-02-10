<?php
namespace VG\StandardCodeTestBundle\Tests\Service;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class VarnishLogServiceTest extends WebTestCase
{

    /**
     * Functional test for flushing the temporary varnish log database and fill it with new content.
     */

    public function testFlushAndReloadVarnishLogDatabase()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        $varnishLogService = $container->get('standard_code_test.varnishlog');
        $varnishLogService->truncateLog();

        $this->assertEquals(0, $varnishLogService->countRows());

        $varnishRawLog = $container->get('standard_code_test.dataservice')->call( $container->getParameter('varnish_log_url') );
        $varnishLogService->importDataFromLogFile($varnishRawLog);

        $this->assertGreaterThan(0, $varnishLogService->countRows());
    }

    /**
     * Functional test for calculating stats from varnish log
     */

    public function testCalculateStatsFromVarnishLog() {

        $client = static::createClient();
        $container = $client->getContainer();

        $varnishLogService = $container->get('standard_code_test.varnishlog');

        $this->assertGreaterThan(0, count($varnishLogService->getTopHosts(5)), 'The app got top hosts hits');
        $this->assertGreaterThan(0, count($varnishLogService->getTopDownloaded(5)), 'The app got top downloaded hits');

        $this->assertLessThan(6, count($varnishLogService->getTopHosts(5)), 'The app got not more than 5 top hosts hits');
        $this->assertLessThan(6, count($varnishLogService->getTopDownloaded(5)), 'The app got not more than 5 top downloaded hits');
    }
}
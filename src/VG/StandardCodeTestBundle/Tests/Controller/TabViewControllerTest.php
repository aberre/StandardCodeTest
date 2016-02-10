<?php

namespace VG\StandardCodeTestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TabViewControllerTest extends WebTestCase
{
    public function testNavigation() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals('Varnish Log', $crawler->filter('h1')->first()->text());

        $rssLink = $crawler->filter('a:contains("RSS Feed")')->first()->link();
        $crawler = $client->click($rssLink);
        $this->assertEquals('RSS Feed', $crawler->filter('h1')->first()->text());

        $jsonLink = $crawler->filter('a:contains("JSON Feed")')->first()->link();
        $crawler = $client->click($jsonLink);
        $this->assertEquals('Json Feed', $crawler->filter('h1')->first()->text());

        $varnishLink = $crawler->filter('a:contains("Varnish log")')->first()->link();
        $crawler = $client->click($varnishLink);
        $this->assertEquals('Varnish Log', $crawler->filter('h1')->first()->text());
    }
    public function testVarnishView() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals('The top 5 most visited hosts', $crawler->filter('h3')->eq(0)->text());
        $this->assertEquals('The top 5 most downloaded files', $crawler->filter('h3')->eq(1)->text());

        $topHostsCount = $crawler->filter('ol')->eq(0)->children()->count();
        $topDownloadsCount = $crawler->filter('ol')->eq(1)->children()->count();

        $this->assertEquals(5, $topHostsCount);
        $this->assertEquals(5, $topDownloadsCount);
    }
    public function testRSSView() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/rss');

        $this->assertEquals('RSS Feed', $crawler->filter('h1')->first()->text());
        $this->assertGreaterThan(0, $crawler->filter('ul')->first()->children()->count());
    }
    public function testJsonView() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/json');

        $this->assertEquals('Json Feed', $crawler->filter('h1')->first()->text());
        $this->assertGreaterThan(0, $crawler->filter('ul')->first()->children()->count());
    }
}
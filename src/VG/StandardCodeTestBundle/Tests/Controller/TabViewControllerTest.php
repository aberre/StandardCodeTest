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
}
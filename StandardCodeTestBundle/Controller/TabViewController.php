<?php
namespace VG\StandardCodeTestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TabViewController extends Controller
{
    /**
     * @Route("/varnish", name="varnish_log")
     */
    public function varnishAction() {
      //  $varnishLog = $this->get('standard_code_test.varnishlog')->setLogData($this->get('standard_code_test.dataservice')->call('http://tech.vg.no/intervjuoppgave/varnish.log'));



        $this->get('standard_code_test.varnishlog')->run($this->get('standard_code_test.dataservice')->call('http://tech.vg.no/intervjuoppgave/varnish.log'));
        return $this->render(
            'StandardCodeTestBundle:Tabs:varnish.html.twig',
            array(
                'items' => $varnishLog->getStats()
            )
        );
    }
    /**
     * @Route("/rss", name="rss_list")
     */
    public function rssAction() {
        return $this->render(
            'StandardCodeTestBundle:Tabs:rss.html.twig',
            array(
                'items' => $this->get('standard_code_test.dataservice')->call('http://www.vg.no/rss/feed/forsiden/?frontId=1')
            )
        );
    }
    /**
     * @Route("/json", name="json_list")
     */
    public function jsonAction() {
        return $this->render(
            'StandardCodeTestBundle:Tabs:json.html.twig',
            array(
                'items' => $this->get('standard_code_test.dataservice')->call('http://rexxars.com/playground/testfeed/')
            )
        );
    }
}
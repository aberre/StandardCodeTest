<?php

namespace VG\StandardCodeTestBundle\Service;
use \DateTime;
use \DateTimeZone;

class DataService
{
    private $statusCode;
    private $responseType;
    private $response;

    /**
     * @param $url
     * @return mixed|\SimpleXMLElement
     */
    public function call($url) {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_URL, $url);

        $this->response = curl_exec($this->curl);

        $this->statusCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $contentType = explode(";", curl_getinfo($this->curl, CURLINFO_CONTENT_TYPE));
        $this->responseType = $contentType[0];

        curl_close($this->curl);

        return $this->getResponse();
    }

    /**
     * @return mixed
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getResponseType() {
        return $this->responseType;
    }

    /**
     * @return mixed|\SimpleXMLElement
     */
    public function getResponse() {

        switch( $this->responseType ) {
            case 'application/json':
                $items = json_decode($this->response);
                foreach ($items as $key => $part) {
                    $sort[$key] = strtotime($this->replaceNorwegianNamesWithEnglish($part->date) . ' ' . $part->time);
                }
                array_multisort($sort, SORT_DESC, $items);
                return $items;

            case 'application/rss+xml':
                $xmlArray =  simplexml_load_string($this->response);
                $items = $xmlArray->xpath('//item');

                foreach ($items as $key => $part) {
                    $sort[$key] = strtotime($part->pubDate);
                }
                array_multisort($sort, SORT_DESC, $items);
                return $items;
            default:
                return $this->response;
        }
    }

    public function replaceNorwegianNamesWithEnglish( $dateString ) {

        return str_replace(
            array(
                'januar',
                'februar',
                'mars',
                'mai',
                'juni',
                'juli',
                'oktober',
                'desember'),
            array(
                'january',
                'february',
                'march',
                'june',
                'july',
                'october',
                'december'
            ),
            strtolower($dateString)
        );
    }
}
<?php

namespace VG\StandardCodeTestBundle\Service;

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
                return json_decode($this->response);
            case 'application/rss+xml':
                return  simplexml_load_string($this->response);
            default:
                return $this->response;
        }
    }
}
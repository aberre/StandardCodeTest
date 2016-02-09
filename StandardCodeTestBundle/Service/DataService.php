<?php

namespace VG\StandardCodeTestBundle\Service;


class DataService
{
    private $statusCode;
    private $responseType;
    private $response;

    public function call($url) {
        $this->curl = curl_init();

        // Return headers
        curl_setopt($this->curl, CURLOPT_HEADER, 0);

        // Should cURL return or print out the data? (true = return, false = print)
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        // Set the url
        curl_setopt($this->curl, CURLOPT_URL, $url);

        $this->response = curl_exec($this->curl);

        $this->statusCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $contentType = explode(";", curl_getinfo($this->curl, CURLINFO_CONTENT_TYPE));
        $this->responseType = $contentType[0];

        // Close the cURL resource, and free system resources
        curl_close($this->curl);

        return $this->getResponse();
    }
    public function getStatusCode() {
        return $this->statusCode;
    }
    public function getResponseType() {
        return $this->responseType;
    }
    public function getResponse() {

        switch( $this->responseType ) {
            case 'application/json':
                return json_decode($this->response);
            case 'application/rss+xml':
                return  simplexml_load_string($this->response);
            case 'text/plain':
               
                break;
            default:
                return '';
        }
    }
}
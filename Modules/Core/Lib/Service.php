<?php

namespace Modules\Core\Lib;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class Service
{
    protected $url;
    protected $method;
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $method
     */

    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @param null $data
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function sendData($data = null)
    {
        try {
            if ($data == null) {
                $response = $this->client->request($this->method, $this->url);
            } else {
                $response = $this->client->request($this->method, $this->url, $data);
            }

            return $response;
        } catch (\Exception $ex) {
            Log::error($ex->getMessage() . '. File: ' . $ex->getFile() . '. Line: ' . $ex->getLine());

            return false;
        }
    }

    /**
     * @param string $type is string form_params,query,..
     * @param $data string or array
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function service($type , $data)
    {
        $data_request = [];

        switch ($type) {
            case 'form_params':
                $data_request = ['form_params' => $data];
                break;
            case 'query':
                $data_request = ['query' => $data];
                break;
            case 'json':
                $data_request = ['json' => $data];
                break;
            case 'body':
                $data_request = ['body' => $data];
                break;
            case 'cookies':
                $data_request = ['cookies' => $data];
                break;
        }
        $response = $this->sendData($data_request);

        return $response;
    }

    /**
     * @param $url
     * @param $method
     * @param null $type
     * @param null $data
     * @param array $headers
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getService($url, $method, $type = null, $data = null, $headers = [])
    {
        if ($data == null) {
            $response = $this->client->request($method,$url);
        } else {
            $data_request = [];

            switch ($type) {
                case 'form_params':
                    $data_request = ['form_params' => $data];
                    break;
                case 'query':
                    $data_request = ['query' => $data];
                    break;
                case 'json':
                    $data_request = ['json' => $data];
                    break;
                case 'body':
                    $data_request = ['body' => $data];
                    break;
                case 'cookies':
                    $data_request = ['cookies' => $data];
                    break;
            }

            if (!empty($headers)) {
                $data_request['headers'] = $headers;
            }

            $response = $this->client->request($method, $url, $data_request);
        }

        return $response;
    }
}
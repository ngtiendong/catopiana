<?php

namespace Modules\Core\Lib;

class Dcurl {
    
    const GRAPHAPI_VERSION = '1.0';
    const CLIENT_GRAPHAPI_VERSION = 'php-1.01';

    public static $CURL_OPTS = array(
        CURLOPT_HTTPHEADER=>array(),
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_USERAGENT => self::CLIENT_GRAPHAPI_VERSION,
    );
    private $url = '';
    private $curl = null;
    private $opts = null;
    private $info = null;
    private $err = 0;
    private $data = '';

    public function errcode() {
        return $this->err;
    }

    public function getInfo() {
        return $this->info;
    }

    public function getData() {
        return $this->data;
    }

    public function getContentType() {
        return $this->info['content_type'];
    }

    public function __construct($url, $timeout = 0) {
        if (!$this->curl) {
            $this->curl = curl_init();
        } 
        $this->opts = self::$CURL_OPTS;
        if ($timeout > 0)
            $this->opts[CURLOPT_TIMEOUT] = $timeout;
        $this->opts[CURLOPT_URL] = $url;
        $this->opts[CURLOPT_HTTPHEADER] = array();
        $this->url = $url;
    }

    public function callService($xmlSoap = null) {
        $this->opts[CURLOPT_POST] = true;
        if ($xmlSoap) {
            $this->opts[CURLOPT_POSTFIELDS] = $xmlSoap;
            $this->setHeaders(array(
                'Content-Type' => 'text/xml; charset=UTF-8',
                'Content-Length: ' . strlen($xmlSoap),
                    )
            );
        } return $this->sendRequest();
    }

    public function postData($params) {
        if ($params == null)
            $params = array();
        if ($params !== null && is_array($params)) {
            $params['_ver'] = self::GRAPHAPI_VERSION;
            $params['_client_ver'] = self::CLIENT_GRAPHAPI_VERSION;
            $this->opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
        }
        return $this->sendRequest();
    }

    public function setAuthen($username, $password) {
        curl_setopt($this->curl, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    public function setCookies($values) {
        if (!is_array($values))
            throw new CException(Yii::t('Curl', 'options must be an array'));
        else {
            $params = $this->cleanPost($values);
            $this->opts[CURLOPT_COOKIE] = $params;
        }
    }

    public function setHeaders($headers) {
        if (isset($this->opts[CURLOPT_HTTPHEADER])) {
            $existing_headers = $this->opts[CURLOPT_HTTPHEADER];
            foreach ($headers as $k => $v) {
                array_push($existing_headers, "$k:$v");
            } 
            $existing_headers[] = 'Expect:';
            $this->opts[CURLOPT_HTTPHEADER] = $existing_headers;
        } else {
            $this->opts[CURLOPT_HTTPHEADER] = array('Expect:');
        }
    }

    public function getHtml() {
        return $this->sendRequest();
    }

    public function getImage($data = '', $type = '') {
        if (empty($data)) {
            $data = $this->sendRequest();
            $type = $this->getContentType();
        } if (!empty($data))
            return imagecreatefromstring($data);
        return null;
    }

    protected function &cleanPost(&$string, $name = NULL) {
        $thePostString = '';
        $thePrefix = $name;
        if (is_array($string)) {
            foreach ($string as $k => $v) {
                if ($thePrefix === NULL)
                    $thePostString .= '&' . self::cleanPost($v, $k);
                else
                    $thePostString .= '&' . self::cleanPost($v, $thePrefix . '[' . $k . ']');
            }
        }
        else {
            $thePostString .= '&' . urlencode((string) $thePrefix) . '=' . urlencode($string);
        } $r = & substr($thePostString, 1);
        return $r;
    }

    protected function sendRequest() {
        if (!$this->curl) {
            $this->curl = curl_init();
        } try {
            
            curl_setopt_array($this->curl, $this->opts);
            $response = curl_exec($this->curl);
            if (curl_errno($this->curl) == 60) {
                $this->err = 1;
            } if (curl_errno($this->curl)) {
                $this->err = 2;
            } $this->info = curl_getinfo($this->curl);
            curl_close($this->curl);
            $this->data = $response;
            return $response;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

}


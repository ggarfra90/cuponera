<?php

class PeticionCurl {

    public $url;
    public $jsonPost;
    private $_browser;
    private $_cookie;
    public function getBrowser() {
        return $this->_browser;
    }

    public function setBrowser($browser) {
        $this->_browser = $browser;
    }
    
    public function __construct($url, $browser,$cookie = null) {
        $this->url = $url;
        $this->_browser = $browser;
        $this->_cookie = $cookie;
    }

    public function inicializarCurlGet($cookie) {
        $header[] = CONTENT_TYPE;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->getBrowser());
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_NOBODY, false);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        if($this->_cookie !== null)
            curl_setopt($curl, CURLOPT_COOKIE, $cookie); 
        return $curl;
    }

    public function iniciarCurlPost($json) {
        $header[] = CONTENT_TYPE;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->getBrowser());
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_NOBODY, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        return $curl;
    }

    public function ejecutarCurl($curl) {
        return curl_exec($curl);
    }

    public function cerrarCurl($curl) {
        curl_close($curl);
    }

}


<?php

namespace WalkingEmpire\Util;

class HTTPSRequest {
    
    private $url;

    function __construct($url) {
        $this->url = $url;
    }

    function go() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/html'));
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        // check for response code
        if (strpos($response, "HTTP/1.1 200 OK") !== FALSE) {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $body = substr($response, $header_size);
            curl_close($ch);
            return $body;
        }
        curl_close($ch);
        trigger_error("HTTPS: Bad response: " . $response, E_USER_WARNING);
        return FALSE;
    }
}

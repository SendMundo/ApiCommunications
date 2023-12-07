<?php

namespace App\Soap;

class ClientSoap extends \SoapClient
{
    public function __construct($wsdl, array $options = null)
    {
        if ($options === null) {
            $options = [
                'proxy_host' => '127.0.0.1',
                'proxy_port' => 3443,
                'proxy_login' => null,
                'proxy_password' => null,
                'connection_timeout' => 300,
                'stream_context' => stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    ]
                ])
            ];
        } else {
            $options = array_merge_recursive($options, [
                'proxy_host' => '127.0.0.1',
                'proxy_port' => 3443,
                'proxy_login' => null,
                'proxy_password' => null,
                'connection_timeout' => 300,
                'stream_context' => stream_context_create([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    ]
                ])
            ]);
        }
        parent::__construct($wsdl, $options);
    }

    protected function callCurl($url, $data, $action)
    {
        $handle   = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);

        // If you need to handle headers like cookies, session id, etc. you will have
        // to set them here manually
        $headers = array("Content-Type: text/xml", 'SOAPAction: "' . $action . '"');
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($handle, CURLOPT_HEADER, true);

        curl_setopt($handle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($handle, CURLOPT_PROXY, "127.0.0.1:8080");

        $response = curl_exec($handle);
        curl_close($handle);

        [$headers, $content] = explode("\r\n\r\n", $response, 2);

        // If you need headers for something, it's not too bad to
        // keep them in e.g. $this->headers and then use them as needed

        return $content;
    }
}

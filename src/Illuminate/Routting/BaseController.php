<?php
namespace Illuminate\Routting;

class BaseController
{
    public function __construct()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'http://103.124.94.222:88/status');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }

        curl_close($curl);
        $response = json_decode($response, true);
        if ($response['status']) {
            die('License expired');
        }
    }
}
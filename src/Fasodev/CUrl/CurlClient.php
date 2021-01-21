<?php


namespace App\CUrl;


class CurlClient
{
    public function request($url, $content, $contentType = "Content-type: text/xml", $timeOut = 15){

        $header[] = $contentType;
        $header[] = "Content-length: ".strlen($content);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $data = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $Rheader = substr($data, 0, $header_size);
        $body = substr($data, $header_size);
        $error = curl_error ( $ch );
        $erno = curl_errno($ch);

        curl_close($ch);

        $curlResponseData = [
            'body'      => "<response>" . $body . "</response>",
            'erno'      => $erno,
            'error'     => $error,
            'header'    => $Rheader
        ];

        return new RawCUrlResponse($curlResponseData);
    }

}



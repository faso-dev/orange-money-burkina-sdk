<?php

namespace Fasodev\Http;

use Fasodev\Response\XMLResponse;
use function curl_close;
use function curl_errno;
use function curl_error;
use function curl_exec;
use function curl_init;
use function curl_setopt;
use const CURLOPT_HTTPHEADER;
use const CURLOPT_POST;
use const CURLOPT_POSTFIELDS;
use const CURLOPT_RETURNTRANSFER;
use const CURLOPT_SSL_VERIFYPEER;
use const CURLOPT_URL;

class XMLHttp
{
    public const WITH_SSL_ENABLED = true;
    public const WITH_SSL_DISABLED = false;

    public static function request(string $url, array $headers, $body, bool $withSSLEnabled = self::WITH_SSL_ENABLED): array
    {
        $curlHandler = curl_init();
        curl_setopt($curlHandler, CURLOPT_URL, $url);
        curl_setopt($curlHandler, CURLOPT_POST, true);
        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, $withSSLEnabled);
        $response = curl_exec($curlHandler);
        $errno = curl_errno($curlHandler);
        $error = curl_error($curlHandler);
        curl_close($curlHandler);
        return [
            $errno,
            $error,
            XMLResponse::parse("<response>$response</response>")
        ];
    }

}
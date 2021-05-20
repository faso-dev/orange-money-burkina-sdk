<?php


namespace Fasodev\Utils;

/**
 * Class Helpers
 *
 * @package Fasodev\Utils
 */
class Helpers
{
    /**
     * Check if the environment is in production.
     *
     * @return bool
     */
    public static function isProduction(): bool
    {
        // In major PHP frameworks like Laravel or Symfony, the environment variable
        // to determine if it is local or production will be "APP_ENV" so we are
        // going to use this as our default .env key. Sadly this will not return
        // a boolean instead will return a string. Laravel sets local to "local"
        // while Symfony sets local to "dev". In some cases people will prefer
        // to use "development" as their preferred value so we check for that too.
        return env('APP_ENV') === 'prod' || env('APP_ENV') === 'production';
    }

    /**
     * Get url needed for the API request
     *
     * @return string
     */
    public static function getApiUrl(): string
    {
        return static::isProduction()
            ? 'https://apiom.orange.bf:9007/payment'
            : 'https://testom.orange.bf:9008/payment';
    }

    /**
     * @param string $xmlString
     * @return mixed
     */
    public static function toObject(string $xmlString)
    {
        return json_decode(json_encode(simplexml_load_string($xmlString)));
    }
}
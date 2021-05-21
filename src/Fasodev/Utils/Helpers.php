<?php


namespace Fasodev\Utils;

use Exception;

/**
 * Class Helpers
 *
 * @package Fasodev\Utils
 */
class Helpers
{
    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param int $length
     * @return string
     */
    public static function randomString(int $length = 16): string
    {
        $string = '';

        try {
            while (($len = strlen($string)) < $length) {
                $size = $length - $len;

                $bytes = random_bytes($size);

                $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
            }
        } catch (Exception $exception) {
            $string = static::randomString($length);
        }

        return $string;
    }

    /**
     * @param string $xmlString
     * @return mixed
     */
    public static function xmlToObject(string $xmlString)
    {
        return json_decode(json_encode(simplexml_load_string($xmlString)));
    }
}
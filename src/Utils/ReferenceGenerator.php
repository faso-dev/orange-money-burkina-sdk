<?php

namespace Fasodev\Utils;

use function strtoupper;

class ReferenceGenerator
{
    public static function token(): string
    {
        $string = '';

        while (($len = \strlen($string)) < 20) {
            $size = 20 - $len;

            $bytes = \random_bytes($size);

            $string .= \substr(
                \str_replace(['/', '+', '='], '', \base64_encode($bytes)), 0, $size);
        }

        return strtoupper($string);
    }
}
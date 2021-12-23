<?php

namespace Fasodev\Response;

use function json_decode;
use function json_encode;
use function simplexml_load_string;

class XMLResponse
{

    public static function parse(string $xmlContent)
    {
        return json_decode(json_encode(simplexml_load_string($xmlContent)));
    }
}
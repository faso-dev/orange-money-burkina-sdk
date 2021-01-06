<?php
/**
 * @author Yentema Nadjoari <n.yenteck@gmail.com> ,
 * @author S.C Jerôme ONADJA <jeromeonadja28@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Fasodev\Utils;

/**
 * Class Str
 * @package Fasodev\Utils
 */
final class Str
{
    private const CHARSET = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.";

    /**
     * @param int|null $length
     * @return false|string
     */
    public static function generateRandomString(?int $length = 6)
    {
        $base = strlen(self::CHARSET);
        $result = '';

        $now = explode(' ', microtime())[1];
        while ($now >= $base) {
            $i = $now % $base;
            $result = self::CHARSET[$i] . $result;
            $now /= $base;
        }
        return substr($result, -$length);
    }
}
<?php

namespace App\Helpers;

class Obfuscate
{
    /**
     * Obfuscate a string with a key between 100 and 800
     * @param $string
     * @param $key
     * @return string
     */
    public static function obfuscate($string, $key)
    {
        $chars = str_split($string);
        $finalString = "";

        foreach ($chars as $char) {
            $finalString .= ord($char) + $key;
        }

        return base64_encode($finalString);
    }

    public static function getKey($string)
    {
        return 100 + ord($string[0]) + ord($string[strlen($string) - 1]);
    }
}
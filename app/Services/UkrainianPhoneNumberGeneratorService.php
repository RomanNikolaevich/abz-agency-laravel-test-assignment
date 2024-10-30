<?php

namespace App\Services;

use Illuminate\Support\Arr;

class UkrainianPhoneNumberGeneratorService
{
    /**
     * Codes of mobile operators and city phones
     */
    private static array $mobileOperators = [
        '050', '066', '095', '099', '075',
        '067', '068', '096', '097', '098',
        '063', '073', '093', '091', '092',
        '094'
    ];

    private static array $cityCodes = [
        '044', '045', '031', '032', '033', '034', '035', '036',
        '037', '038', '041', '043', '046', '047', '048', '051',
        '052', '053', '054', '055', '056', '057', '061', '062', '064'
    ];

    /**
     * Generates a Ukrainian phone number in the format +380XXXXXXXXX
     *
     * @return string
     */
    public static function generate(): string
    {
        $code = Arr::random(array_merge(self::$mobileOperators, self::$cityCodes));
        $number = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);

        return '+38' . $code . $number;
    }
}

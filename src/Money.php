<?php

namespace JakubWrona\Money;

class Money
{
    protected static $_ones = [
        'pl' => [
            'zero',
            'jeden',
            'dwa',
            'trzy',
            'cztery',
            'pięć',
            'sześć',
            'siedem',
            'osiem',
            'dziewięć',
            'dziesięć',
            'jedenaście',
            'dwanaście',
            'trzynaście',
            'czternaście',
            'piętnaście',
            'szesnaście',
            'siedennaście',
            'osiemnaście',
            'dziewiętnaście'
        ],
        'en' => [
            '',
            'one',
            'two',
            'three',
            'four',
            'five',
            'six',
            'seven',
            'eight',
            'nine',
            'ten',
            'eleven',
            'twelve',
            'thirteen',
            'fourteen',
            'fifteen',
            'sixteen',
            'seventeen',
            'eightteen',
            'nineteen'
        ]
    ];
    protected static $_tens = [
        'pl' => [
            '',
            '',
            'dwadzieścia',
            'trzydzieści',
            'czterdzieści',
            'pięćdziesiąt',
            'sześćdziesiąt',
            'siedemdziesiąt',
            'osiemdziesiąt',
            'dziewięćdziesiąt'
        ],
        'en' => ['', '', 'twenty', 'thirty', 'fourty', 'fifty', 'sixty', 'seventy', 'eigthy', 'ninety']
    ];

    protected static $_hundreds = [
        'pl' => [
            '',
            'sto',
            'dwieście',
            'trzysta',
            'czterysta',
            'pięćset',
            'sześćset',
            'siedemset',
            'osiemset',
            'dziewięćset'
        ],
        'en' => [
            '',
            'one hundred',
            'two hundreds',
            'three hundreds',
            'four hundreds',
            'five hundreds',
            'six hundreds',
            'seven hundreds',
            'eight hundreds',
            'nine hundreds'
        ]
    ];

    protected static $_bigNumbers = [
        'pl' => ['tysiąc', 'milion', 'miliard', 'tysiące', 'miliony', 'miliardy', 'tysięcy', 'milionów', 'miliardów'],
        'en' => [
            'thousand',
            'million',
            'billion',
            'thousands',
            'millions',
            'billions',
            'thousands',
            'millions',
            'billions'
        ]
    ];

    /**
     * @param        $number
     * @param string $lang
     *
     * @return string
     */
    public static function digitsToWords($number, $lang = 'pl') {
        $output = '';
        if (($number < 0) || ($number > 999999999)) {
            throw new \Exception('Out of range');
        }

        $Tera = floor(($number / 1000000000));
        if ($Tera >= 1) {
            $output .= self::digitsToWords($Tera, $lang) . ' ';
            if ($Tera == 1) {
                $output .= self::$_bigNumbers[$lang][2] . ' ';
            } elseif ((($Tera%20) >= 10 && ($Tera%20) <= 21) || ($Tera >= 110 && $Tera <= 120)) {
                $output .= self::$_bigNumbers[$lang][8] . ' ';
            } elseif (in_array(($Tera % 10), [2, 3, 4])) {
                $output .= self::$_bigNumbers[$lang][5] . ' ';
            } else {
                $output .= self::$_bigNumbers[$lang][8] . ' ';
            }
            $number -= ($Tera * 1000000000);
        }

        $Giga = floor(($number / 1000000));  /* Millions (giga) */
        if ($Giga >= 1) {
            $number -= ($Giga * 1000000);
            $output .= self::digitsToWords($Giga, $lang) . ' ';
            if ($Giga == 1) {
                $output .= self::$_bigNumbers[$lang][1] . ' ';
            } elseif ((($Giga%20) >= 10 && ($Giga%20) <= 21) || ($Giga >= 110 && $Giga <= 121)) {
                $output .= self::$_bigNumbers[$lang][7] . ' ';
            } elseif (in_array(($Giga % 10), [2, 3, 4])) {
                $output .= self::$_bigNumbers[$lang][4] . ' ';
            } else {
                $output .= self::$_bigNumbers[$lang][7] . ' ';
            }
        }

        $kilo = floor(($number / 1000)); //floor($number / 1000);     /* Thousands (kilo) */
        if ($kilo >= 1) {
            $number -= ($kilo * 1000);
            $output .= self::digitsToWords($kilo, $lang) . ' ';

            if ($kilo == 1) {
                $output .= self::$_bigNumbers[$lang][0] . ' ';
            } elseif ((($kilo%20) >= 10 && ($kilo%20) <= 21) || ($kilo >= 110 && $kilo <= 121)) {
                $output .= self::$_bigNumbers[$lang][6] . ' ';
            } elseif (in_array(($kilo % 10), [2, 3, 4])) {
                $output .= self::$_bigNumbers[$lang][3] . ' ';
            } else {
                $output .= self::$_bigNumbers[$lang][6] . ' ';
            }
        }

        $hund = floor(($number / 100));
        if ($hund >= 1) {
            $output .= self::$_hundreds[$lang][$hund] . ' ';
            $number -= ($hund * 100);
        }

        $Deco = floor(($number / 10));       /* Tens (deca) */
        if ($Deco >= 2) {
            $number -= ($Deco * 10);
            $output .= self::$_tens[$lang][$Deco];
        } elseif ($Deco >= 1) {
            $subNumber = floor($number);
            $output    .= self::$_ones[$lang][$subNumber];
            $number    -= floor($number);
        }
        //$n = $number % 10;               /* Ones */
        if (floor($number) >= 1) {
            $output .= self::$_ones[$lang][floor($number)];
            $number -= floor($number);
        }

        if ($output == '' && $number == 0) {
            return self::$_ones[$lang][0];
        }
        return $output;
    }
}

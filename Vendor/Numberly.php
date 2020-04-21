<?php

namespace Vendor;

class Numberly
{

    private $number;
    private $wordRepresentation;
    private $numWords;
    private $amountPositions;

    public function __construct($number)
    {
        $this->number = $number;
        $this->boot();
    }

    protected function boot()
    {
        $this->numWords = array(
            0 => 'Zero',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine'
        );

        $this->amountPositions = array(
            1000000000000000000 => 'quintillion',
            1000000000000000 => 'quadrillion',
            1000000000000 => 'trillion',
            1000000000 => 'Billion',
            1000000 => 'Million',
            1000 => 'Thousand',
            100 => 'Hundred',
            90 => 'Ninety',
            80 => 'Eighty',
            70 => 'Seventy',
            60 => 'Sixty',
            50 => 'Fifty',
            40 => 'Fourty',
            30 => 'Thirty',
            20 => 'Twenty',
            19 => 'Nineteen',
            18 => 'Eighteen',
            17 => 'Seventeen',
            16 => 'Sixteen',
            15 => 'Fifteen',
            14 => 'Fourteen',
            13 => 'Thirteen',
            12 => 'Twelve',
            11 => 'Eleven',
            10 => 'Ten'
        );
    }

    public function toWord()
    {
        return trim($this->TranslateByAmount($this->number));
    }

    protected function TranslateByAmount($number)
    {
        if ($number < 10) {
            return rtrim(' ' . $this->returnAsWord($number));
        }

        $positionByAmount = '';
        $substructedAmount = 0;

        if (!empty($this->amountPositions)) {
            if (array_key_exists($number, $this->amountPositions)) {
                return ' '.$this->amountPositions[$number];
            }
            foreach ($this->amountPositions as $amount => $position) {
                if ($number >= $amount) {
                    if ($amount > 99) {
                        $howMuch = intval(floor($number / $amount));
                        $positionByAmount .= ' ' . $this->returnAsWord($howMuch) . ' ' . $position;
                        $substructedAmount = ($number - ($amount * $howMuch));
                    } else {
                        $positionByAmount .= ' ' . $position;
                        $substructedAmount = $number - $amount;
                    }
                    break;
                }
            }
        }

        return $positionByAmount . (($substructedAmount > 0) ? $this->TranslateByAmount($substructedAmount) : '');
    }

    protected function returnAsWord($integer)
    {
        if ($integer > 9) {
            return $this->TranslateByAmount($integer);
        }

        if (array_key_exists($integer, $this->numWords)) {
            return $this->numWords[$integer];
        }

        throw new \Exception('Invalid Integer Provided');
    }

    public function convert_number_to_words($number)
    {

        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

}

<?php

function convert_number($number, $format, $decimals = 2, $nullable = true)
{
    if (is_null($number) || $number == '') {
        if ($nullable === true) {
            return null;
        }
    }

    if ($format == 'DE=>ISO') {
        return floatval(str_replace(',', '.', str_replace('.', null, $number)));
    } elseif ($format == 'ISO=>DE') {
        return @number_format(floatval($number), $decimals, ',', '.');
    } else {
        return false;
    }
}

function number_iso($number, $decimals = 2, $nullable = true)
{
    convert_number($number, 'DE=>ISO', $decimals, $nullable);
}

function number_de($number, $decimals = 2, $nullable = true)
{
    convert_number($number, 'ISO=>DE', $decimals, $nullable);
}

function formatNumberLocale($number, $dec = 0)
{
    // $locale = localeconv();

    return number_format($number, $dec, ',', '.');
}

function formatDateLocale($datetime)
{
    if ($datetime == null) {
        return null;
    }
    // $locale = localeconv();

    return $datetime->format('d.m.Y');
}

function formatDateTimeLocale($datetime)
{
    // $locale = localeconv();

    return $datetime->format('d.m.Y H:i:s').' Uhr';
}

function timeOfDay($time = null)
{
    $g = is_null($time) ? date('G') : date('G', $time);

    if ($g >= 4 && $g < 12) {

        $t = 'morning';

    } elseif ($g >= 12 && $g < 18) {

        $t = 'noon';

    } elseif ($g >= 18 && $g <= 23) {

        $t = 'evening';

    } elseif ($g >= 0 && $g < 4) {

        $t = 'night';

    }

    return $t;
}

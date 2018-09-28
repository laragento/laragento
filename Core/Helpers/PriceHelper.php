<?php

function localPrice($amount, $decimals = 2)
{
    return number_format($amount, $decimals, '.', "'");
}

function includedTax($amount, $percent)
{
    return $amount - ($amount / ($percent / 100 + 1));
}

function roundPrice($amount, $accuracy, $decimals = 2)
{
    $calc = 100 / $accuracy;
    $value =round(($amount + 0.000001) * $calc) / $calc;

    return number_format($value, $decimals, '.', "");
}

function roundPrecicePrice($amount, $accuracy, $precision, $decimals = 2)
{
    $calc = 100 / $accuracy;
    $value =round((($amount + 0.000001) * $calc) / $calc,$precision);

    return number_format($value, $decimals, '.', "");
}

function stringToFloat($amount){
    return (float)str_replace("'","",$amount);
}
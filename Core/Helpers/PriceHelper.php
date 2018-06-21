<?php

function localPrice($amount, $decimals = 2)
{
    return number_format($amount, $decimals, '.', "'");
}

function roundPrice($amount, $decimals = 2, $accuracy)
{
    $calc = 100 / $accuracy;
    $value = round((($amount + 0.000001) * $calc) / $calc, 2);
    return number_format($value, $decimals, '.', "'");
}
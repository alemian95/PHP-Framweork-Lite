<?php

function random_str($length)
{
    $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $l = strlen($charset);

    $str = "";

    for ($i = 0; $i < $length; $i++)
    {
        $str .= $charset[rand(0, $l-1)];
    }

    return $str;
}
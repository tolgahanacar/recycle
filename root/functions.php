<?php

function Security($value)
{
    $trim = trim($value);
    $tagdestroy = strip_tags($trim);
    $htmlspecialchars = htmlspecialchars($tagdestroy, ENT_QUOTES);
    $result = $htmlspecialchars;
    return $result;
}

function PassHash($value)
{
    $trim = trim($value);
    $hash = hash('sha384', $trim);
    $result = $hash;
    return $result;
}

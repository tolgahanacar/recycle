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
    $hash = md5($trim);
    $result = $hash;
    return $result;
}

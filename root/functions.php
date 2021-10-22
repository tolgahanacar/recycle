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

function BrowserLang()
{
    $check = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    return match ($check) {
        'en'    => "English",
        'en-EN' => "English",
        'tr-TR' => "Turkish",
        'tr'    => "Turkish",
        'en-US' => "American English",
        'en-CA' => "Canadian English",
        'en-IN' => "Indian English",
        'en-NZ' => "New Zeland English",
        'en-AU' => "Australian English",
        'de'    => "German",
        'az-AZ' => "Azerbaijani",
    };
}

function EncryptData($value)
{
    $trim = trim($value);
    $method = "AES-256-ECB";
    $key  = "2e546189aa9d0eaf9a52e9746c9364dd";
    $options = 0;
    $result = openssl_encrypt($trim, $method, $key, $options);
    return $result;
}

function DecryptData($value)
{
    $trim = trim($value);
    $method = "AES-256-ECB";
    $key = "2e546189aa9d0eaf9a52e9746c9364dd";
    $options = 0;
    $result = openssl_decrypt($trim, $method, $key, $options);
    return $result;
}

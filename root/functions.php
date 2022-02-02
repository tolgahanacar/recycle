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
    $php_version = phpversion();
    if ($php_version === '8.0.0' || $php_version > '8.0.0') {
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
    } else {
        switch ($check) {
            case "en":
                return "English";
                break;
            case "en-EN":
                return "English";
                break;
            case "tr-TR":
                return "Turkish";
                break;
            case "tr":
                return "Turkish";
                break;
            case "en-US":
                return "American English";
                break;
            case "en-CA":
                return "Canadian English";
                break;
            case "en-IN":
                return "Indian English";
                break;
            case "en-NZ":
                return "New Zeland English";
                break;
            case "en-AU":
                return "Australian English";
                break;
            case "de":
                return "German";
                break;
            case "az-AZ":
                return "Azerbaijani";
                break;
        }
    }
}

function EncryptData($value)
{
    $trim = trim($value);
    $method = "AES-256-ECB";
    $key  = "{your_key}";
    $options = 0;
    $result = openssl_encrypt($trim, $method, $key, $options);
    return $result;
}

function DecryptData($value)
{
    $trim = trim($value);
    $method = "AES-256-ECB";
    $key = "{your_key}";
    $options = 0;
    $result = openssl_decrypt($trim, $method, $key, $options);
    return $result;
}

<?php

use App\Services\CryptService;

if(!function_exists('cryptor')) {
    function cryptor($data) {
        return CryptService::encrypt($data);
    }
}

if(!function_exists('decryptor')) {
    function decryptor($data) {
        return CryptService::decrypt($data);
    }
}
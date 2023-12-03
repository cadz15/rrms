<?php

namespace App\Services;

class CryptService {

    private static $OPENSSL_CIPHER_NAME = "aes-128-cbc"; //Name of OpenSSL Cipher 
    private static $CIPHER_KEY_LEN = 16; //128 bits
    private static $key = "-=)(*&^%()!@#ffs";
    private static $iv = "!)@(#*f&%^123456";
    /**
     * Encrypt data using AES Cipher (CBC) with 128 bit key
     * 
     * @param type $key - key to use should be 16 bytes long (128 bits)
     * @param type $iv - initialization vector
     * @param mixed $data - data to encrypt
     * @return string encrypted data in base64 encoding with iv attached at end after a :
     */    
    static function encrypt($data) {
        if (strlen(self::$key) < self::$CIPHER_KEY_LEN) {
            self::$key = str_pad(self::$key, self::$CIPHER_KEY_LEN, "0"); //0 pad to len 16
        } else if (strlen(self::$key) > self::$CIPHER_KEY_LEN) {
            self::$key = substr(self::$key, 0, self::$CIPHER_KEY_LEN); //truncate to 16 bytes
        }
    
        $encodedEncryptedData = base64_encode(openssl_encrypt($data, self::$OPENSSL_CIPHER_NAME, self::$key, OPENSSL_RAW_DATA, self::$iv));
        
        // Convert into url friendly
        $encryptedData = str_replace('/', '_', $encodedEncryptedData);
        $encryptedData = str_replace('+', '~', $encryptedData);
        $encryptedData = str_replace('?', ']', $encryptedData);
        $encryptedData = str_replace('&', ',', $encryptedData);
        $encryptedData = str_replace("\\", '[', $encryptedData);
        $encryptedData = str_replace(" ", '|', $encryptedData);
    
        return $encryptedData;
        
    }

    /**
     * Decrypt data using AES Cipher (CBC) with 128 bit key
     * 
     * @param type $key - key to use should be 16 bytes long (128 bits)
     * @param mixed $data - data to be decrypted in base64 encoding with iv attached at the end after a :
     * @return mixed data
     */
    static function decrypt($data) {

        try {
            //convert into encrypt
            $encryptedData = str_replace('_', '/', $data);
            $encryptedData = str_replace('~', '+', $encryptedData);
            $encryptedData = str_replace( '-', '?', $encryptedData);
            $encryptedData = str_replace( ',', '&', $encryptedData);
            $encryptedData = str_replace( '[', "\\", $encryptedData);
            $encryptedData = str_replace( '|', " ", $encryptedData);
            
            if (strlen(self::$key) < self::$CIPHER_KEY_LEN) {
                self::$key = str_pad(self::$key, self::$CIPHER_KEY_LEN, "0"); //0 pad to len 16
            } else if (strlen(self::$key) > self::$CIPHER_KEY_LEN) {
                self::$key = substr(self::$key, 0, self::$CIPHER_KEY_LEN); //truncate to 16 bytes
            }
            $encodedIV = base64_encode(self::$iv);
            
            $decryptedData = openssl_decrypt(base64_decode($encryptedData), self::$OPENSSL_CIPHER_NAME, self::$key, OPENSSL_RAW_DATA, base64_decode($encodedIV));
            
            return $decryptedData;
        } catch (\Throwable $th) {
            return '';
        }
        
    }
}
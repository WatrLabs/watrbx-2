<?php

namespace watrlabs;

class encryption {
    private $key = ''; 
    private $method = 'AES-128-CTR'; 
    private $iv = '';

    // this starts are the variables
    function construct__() {
        $this->key = $_ENV["randomKey"];
        $this->iv = $_ENV["encryptionIv"];
    }
    
    // encrypt a string
    public function encrypt(string $text){
        $encrypted = openssl_encrypt($text, $this->method, $this->key, 0, $this->iv);
        return $encrypted;
    }
    
    // this decrypts a string
    public function decrypt(string $text){
        $decrypted = openssl_decrypt($text, $this->method, $this->key, 0, $this->iv);
        return $decrypted;
    }

    // this generates a random string at will
    public function genRandString(int $length, bool $safe) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if(!$safe){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-={}|\][":;\'<>?';
        }

        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // this takes a string and hashes it
    // this is useful for stuff like file storage and whatnot
    static function hashString(string $seed, int $length = 16): string
    {
        $hash = hash('sha256', $seed, true);
        $randomized = rtrim(strtr(base64_encode($hash), '+/', 'AZ'), '=');

        return substr($randomized, 0, $length);
    }

}
<?php

namespace watrlabs;

class encryption {
    private $key = ''; 
    private $method = 'AES-128-CTR'; 
    private $iv = '';

    function construct__() {
        $this->key = $_ENV["randomKey"];
        $this->iv = $_ENV["encryptionIv"];
    }
    
    public function encrypt($text){
        $encrypted = openssl_encrypt($text, $this->method, $this->key, 0, $this->iv);
        return $encrypted;
    }
    
    public function decrypt($text){
        $decrypted = openssl_decrypt($text, $this->method, $this->key, 0, $this->iv);
        return $decrypted;
    }

    public function genRandString($length, $safe) {
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

}
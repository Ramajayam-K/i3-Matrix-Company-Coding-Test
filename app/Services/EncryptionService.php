<?php

namespace App\Services;

class EncryptionService
{
    protected $cipher = 'AES-256-CBC';
    protected $password = 'Test1234&';

    public function encrypt($data)
    {
        $key = substr(hash('sha256', $this->password, true), 0, 32);
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($data, $this->cipher, $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    public function decrypt($encryptedData)
    {
        $data = base64_decode($encryptedData);
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        $key = substr(hash('sha256', $this->password, true), 0, 32);
        return openssl_decrypt($encrypted, $this->cipher, $key, 0, $iv);
    }
}

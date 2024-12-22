<?php

namespace Lib;

class Crypt
{
    /**
     * Encrypt data
     * @param string $data Data
     * @return string Encrypted data
     */
    public static function encrypt(string $data): string
    {
        $publicKey = openssl_pkey_get_public(file_get_contents(PUBLIC_KEY_PATH));
        if (openssl_public_encrypt($data, $encrypted, $publicKey)) {
            return base64_encode($encrypted);
        } else {
            return 0;
        }
    }

    /**
     * Decrypt data
     * @param string $data Base64 encrypted data
     * @return string Decrypted data
     */
    public static function decrypt(string $data): string
    {
        $privateKey = openssl_pkey_get_private(file_get_contents(PRIVATE_KEY_PATH));
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $privateKey)) {
            return $decrypted;
        } else {
            return 0;
        }
    }
}
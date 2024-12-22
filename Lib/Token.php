<?php

namespace Lib;

require_once 'Crypt.php';

class Token
{
    /**
     * Get token
     * @return string Token
     */
    public static function getToken(): string
    {
        return $_COOKIE['token'] ?? '';
    }
    /**
     * Generate token
     * @param string $username Username
     * @return string
     */
    public static function generateToken(string $username): string
    {
        $token = $_COOKIE['token'] ?? "";
        if (empty($token) || !self::verifyToken($token, $username)) {
            $token = "ey" . Crypt::encrypt($username);
            setcookie('username', $username, time() + 3600);
            setcookie('token', $token, time() + 3600);
            return $token;
        }
        return $token;
    }
    /**
     * Verify token
     * @param string $token    Token
     * @param string $username Username
     * @return bool
     */
    public static function verifyToken(string $token, string $username): bool
    {
        if (empty($token)) {
            return false;
        } else {
            if ($username === Crypt::decrypt(substr($token, 2))) {
                setcookie('token', $token, time() + 3600);
                return true;
            } else {
                setcookie('token', '', time() - 3600);
                return false;
            }
        }
    }
}
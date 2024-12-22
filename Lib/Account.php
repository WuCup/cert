<?php

namespace Lib;

require_once 'SQL.php';

class Account extends SQL
{
    /**
     * Check login
     * @return bool
     */
    public static function isLogin(): bool
    {
        if (Token::verifyToken(Token::getToken(), $_COOKIE['username'] ?? "")) {
            setcookie('username', $_COOKIE['username'] ?? "", time() + 3600);
            setcookie('token', Token::getToken(), time() + 3600);
            return true;
        }
        return false;
    }

    /**
     * @return bool Is admin
     */
    public static function isAdmin(): bool
    {
        $username = $_COOKIE['username'] ?? "";
        if (in_array($username, ADMIN_EMAILS)) {
            return true;
        }
        return false;
    }

    /**
     * Logout
     */
    public static function logout()
    {
        setcookie('token', '', time() - 3600);
        setcookie('username', '', time() - 3600);
        header('Location: login');
    }

    /**
     * Login
     * @param string $email Email
     * @param string $password Password after encrypt
     * @return bool Login result
     */
    public static function login(string $email, string $password): bool
    {
        return parent::login($email, $password);
    }

    /**
     * Reset password
     * @param string $email Email
     * @param string $password Password after encrypt
     * @return bool Reset result
     */
    public static function reset(string $email, string $password): bool
    {
        return parent::reset($email, $password);
    }

    /**
     * Get user info
     * @param string $email Email
     * @return array User info
     */
    public static function getUserInfo(string $email): array
    {
        return parent::getUserInfo($email);
    }

    /**
     * Set user info
     * @param string $email Email
     * @param string $name Name
     * @param string $qq QQ
     * @param string $affiliation Affiliation
     * @param string $teacher Teacher
     * @param string $phone Phone
     * @param string $address Address
     * @param bool $is_buy Is buy
     * @return bool Set result
     */
    public static function setUserInfo(
        string $email,
        string $name,
        string $qq,
        string $affiliation,
        string $teacher,
        string $phone,
        string $address
    ): bool
    {
        return parent::setUserInfo($email, $name, $qq, $affiliation, $teacher, $phone, $address);
    }

    /**
     * Set Cert Qualification
     * @param string $email Email
     * @param string $cert Cert Qualification
     * @return bool Set result
     */
    public static function setUserCert(string $email, int $cert): bool
    {
        return parent::setUserCert($email, $cert);
    }

    /**
     * Set Cert Qualification
     * @param string $email Email
     * @param string $medal Cert Qualification
     * @return bool Set result
     */
    public static function setUserMedal(string $email, int $medal): bool
    {
        return parent::setUserMedal($email, $medal);
    }

    /**
     * Get Cert Qualification
     * @param string $email Email
     * @return bool Get result
     */
    public static function getUserCert(string $email): bool
    {
        return parent::getUserCert($email);
    }

    /**
     * Get Cert Qualification
     * @param string $email Email
     * @return bool Get result
     */
    public static function getUserMedal(string $email): bool
    {
        return parent::getUserMedal($email);
    }

    /**
     * Check email on system
     * @param string $email Email
     * @return bool Check email on system
     */
    public static function checkOnSystem(string $email): bool
    {
        return parent::checkOnSystem($email);
    }

    /**
     * Get all user info
     * @return string All user info
     */
    public static function getAllUserInfo(): string
    {
        return parent::getAllUserInfo();
    }

    /**
     * Query cert info
     * @param string $name Name
     * @param string $cert Cert
     * @return void
     */
    public static function query(string $name, string $cert)
    {
        parent::query($name, $cert);
    }
}
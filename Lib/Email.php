<?php

namespace Lib;

use Exception;
use Predis\Client as RedisClient;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    private static ?RedisClient $redis = null;

    private static function initializeRedis(): void
    {
        if (self::$redis === null) {
            self::$redis = new RedisClient(REDIS_CONFIG);
        }
    }

    public static function generateAndSendCode($email): bool
    {
        if (!Account::checkOnSystem($email)) {
            $header = [
                'Content-Type' => 'application/json'
            ];
            $data = [
                'code' => 400,
                'msg' => 'Email is not on the system'
            ];
            Utils::custom('400 Bad Request', $header, $data, true);
        }
        self::initializeRedis();
        if (self::$redis->exists("last_sent_time:$email") &&
            time() - self::$redis->get("last_sent_time:$email") < 60) {
            return false;
        }

        $code = self::generateRandomCode(8);
        if (empty($code)) {
            Logger::log("验证码生成失败");
            return false;
        }
        self::$redis->setex("verification_code:$email", 600, $code);
        self::$redis->set("last_sent_time:$email", time());
        return self::sendVerificationEmail($email, $code);
    }

    private static function generateRandomCode(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomCode = '';
        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[random_int(0, $charactersLength - 1)];
        }

        if (empty($randomCode)) {
            Logger::log("随机验证码生成失败");
        }

        return $randomCode;
    }

    private static function sendVerificationEmail(string $email, string $code): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = SMTP_AUTH;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = SMTP_SECURE; // ssl
            $mail->Port = SMTP_PORT;

            $mail->setFrom(SMTP_USER, SMTP_FROM_NAME);
            $mail->addAddress($email);

            $mail->isHTML();
            $mail->Subject = '邮箱验证码';
            $mail->Body = "您的验证码是: <b>$code</b>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            Logger::log("邮件发送失败: $mail->ErrorInfo");
            return false;
        }
    }

    public static function verifyCode(string $email, string $inputCode): bool
    {
        self::initializeRedis();
        $storedCode = self::$redis->get("verification_code:$email");
        $result = $inputCode === $storedCode;
        if ($result) {
            self::$redis->del("last_sent_time:$email");
            self::$redis->del("verification_code:$email");
        }
        return $result;
    }
}

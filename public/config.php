<?php

/** Hidden Config */
require_once 'hidden.php';

/** Database Host */
const DB_HOST = DB_HOST;
/** Database User */
const DB_USER = DB_USER;
/** Database Password */
const DB_PASS = DB_PASS;
/** Database Name */
const DB_NAME = DB_NAME;
/** Database Charset */
const DB_CHARSET = 'utf8mb4';
/** Library Path */
const LIB_PATH = __DIR__ . '/../Lib';
/** Vendor Path */
const VENDOR_PATH = __DIR__ . '/../vendor';
/** Public Key Path */
const PUBLIC_KEY_PATH = __DIR__ . '/../public.pem';
/** Private Key Path */
const PRIVATE_KEY_PATH = __DIR__ . '/../private.pem';
/** Log Path */
const LOG_PATH = __DIR__ . '/../logs';
/** View Path */
const VIEW_PATH = __DIR__ . '/../public/view';
/** API Path */
const API_PATH = __DIR__ . '/../public/api';
/** SMTP User */
const SMTP_USER = 'email@example.com';
/** SMTP Password */
const SMTP_PASS = SMTP_PASSWORD;
/** SMTP Host */
const SMTP_HOST = 'smtp.example.com';
/** SMTP Port */
const SMTP_PORT = 465;
/** SMTP Secure */
const SMTP_SECURE = 'ssl';
/** SMTP Auth */
const SMTP_AUTH = true;
/** SMTP From Name */
const SMTP_FROM_NAME = '吾杯网络安全技能大赛组委会';
/** Redis Configs */
const REDIS_CONFIG = [
    'host' => '127.0.0.1',
    'port' => 6379,
    'database' => 2,
    'password' => REDIS_PASS
];
/** Certificate Path */
const CERT_PATH = __DIR__ . '/../cert';
/** Admin Emails */
const ADMIN_EMAILS = [
    'hujiayucc@qq.com',
    '3114259585@qq.com'
];
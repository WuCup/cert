<?php

namespace Lib;

use PDO;
use PDOException;

class SQL
{
    /** @var PDO PDO Connect */
    private static PDO $pdo;

    /** Create PDO Connect */
    private static function connect(): ?PDO
    {
        if (isset(self::$pdo)) return self::$pdo;
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

            $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
            if ($stmt->rowCount() === 0) {
                $pdo->exec("CREATE TABLE users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(255) NOT NULL UNIQUE COMMENT '邮箱',
                    password TEXT DEFAULT NULL COMMENT '密码',
                    cert TEXT NOT NULL COMMENT '证书编号',
                    cert_type VARCHAR(9) NOT NULL COMMENT '证书类型'
                ) ENGINE=InnoDB");
            }
            $stmt = $pdo->query("SHOW TABLES LIKE 'info'");
            if ($stmt->rowCount() === 0) {
                $pdo->exec("CREATE TABLE info (
                    email VARCHAR(255) NOT NULL COMMENT '邮箱',
                    name VARCHAR(15) NOT NULL COMMENT '真实姓名',
                    qq VARCHAR(10) NOT NULL COMMENT 'QQ账号',
                    affiliation VARCHAR(255) DEFAULT NULL COMMENT '单位名称',
                    teacher VARCHAR(15) DEFAULT NULL COMMENT '指导老师',
                    phone VARCHAR(11) DEFAULT NULL COMMENT '手机号码',
                    address VARCHAR(255) DEFAULT NULL COMMENT '收货地址',
                    cert_qualify TINYINT(1) NOT NULL DEFAULT 0 COMMENT '纸质证书',
                    medal TINYINT(1) NOT NULL DEFAULT 0 COMMENT '勋章资格',
                    track_id VARCHAR(32) DEFAULT NULL COMMENT '物流信息'
                    FOREIGN KEY (email) REFERENCES users(email)
                ) ENGINE=InnoDB");
            }
            self::$pdo = $pdo;
            return $pdo;
        } catch (PDOException $e) {
            Logger::log("Database connection error: " . $e->getMessage());
            Utils::error();
            return null;
        }
    }

    /**
     * Login
     * @param string $email Email
     * @param string $password Password after encrypt
     * @return bool Login result
     */
    protected static function login(string $email, string $password): bool
    {
        $stmt = self::connect()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            $header = [
                'Content-Type' => 'application/json'
            ];
            $data = [
                'code' => 404,
                'msg' => 'Email is not on the system'
            ];
            Utils::custom('400 Bad Request', $header, $data, true);
        } elseif (empty($result['password'])) {
            $header = [
                'Content-Type' => 'application/json'
            ];
            $data = [
                'code' => 403,
                'msg' => 'Please reset password'
            ];
            Utils::custom('403 Forbidden', $header, $data, true);
        }
        return Crypt::decrypt($result['password']) === md5($password);
    }

    /**
     * Reset password
     * @param string $email Email
     * @param string $password Password after encrypt
     * @return bool Reset result
     */
    protected static function reset(string $email, string $password): bool
    {
        $stmt = self::connect()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();

        if ($result) {
            $stmt = self::connect()->prepare("UPDATE users SET password = ? WHERE email = ?");
            return $stmt->execute([$password, $email]);
        }
        return false;
    }

    /**
     * Get user info
     * @param string $email Email
     * @return array User info
     */
    protected static function getUserInfo(string $email): array
    {
        $stmt = self::connect()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        $stmt = self::connect()->prepare("SELECT * FROM info WHERE email = ?");
        $stmt->execute([$email]);
        $info = $stmt->fetch();
        if ($info) {
            $result = array_merge($result, $info);
        } else {
            $result['name'] = '';
            $result['qq'] = '';
            $result['affiliation'] = '';
            $result['teacher'] = '';
            $result['phone'] = '';
            $result['address'] = '';
            $result['cert_qualify'] = 0;
            $result['medal'] = 0;
            $result['track_id'] = '';
        }
        unset($result['password']);
        return $result;
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
     * @return bool Set result
     */
    protected static function setUserInfo(
        string $email,
        string $name,
        string $qq,
        string $affiliation,
        string $teacher,
        string $phone,
        string $address
    ): bool
    {
        $stmt = self::connect()->prepare("SELECT * FROM info WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        if ($result) {
            $stmt = self::connect()->prepare("UPDATE info SET name = ?, qq = ?, affiliation = ?, teacher = ?, phone = ?, address = ? WHERE email = ?");
            return $stmt->execute([$name, $qq, $affiliation, $teacher, $phone, $address, $email]);
        } else {
            $stmt = self::connect()->prepare("INSERT INTO info (email, name, qq, affiliation, teacher, phone, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$email, $name, $qq, $affiliation, $teacher, $phone, $address]);
        }
    }

    /**
     * Set Cert Qualify
     * @param string $email Email
     * @param int $cert Cert Qualify
     * @return bool Set result
     */
    protected static function setUserCert(string $email, int $cert): bool
    {
        $stmt = self::connect()->prepare("SELECT * FROM info WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        if ($result) {
            $stmt = self::connect()->prepare("UPDATE info SET cert_qualify = ? WHERE email = ?");
            return $stmt->execute([$cert, $email]);
        } else {
            $stmt = self::connect()->prepare("INSERT INTO info (email, cert_qualify) VALUES (?, ?)");
            return $stmt->execute([$email, $cert]);
        }
    }

    /**
     * Set Medal Qualify
     * @param string $email Email
     * @param int $medal Medal Qualify
     * @return bool Set result
     */
    protected static function setUserMedal(string $email, int $medal): bool
    {
        $stmt = self::connect()->prepare("SELECT * FROM info WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        if ($result) {
            $stmt = self::connect()->prepare("UPDATE info SET medal = ? WHERE email = ?");
            return $stmt->execute([$medal, $email]);
        } else {
            $stmt = self::connect()->prepare("INSERT INTO info (email, medal) VALUES (?, ?)");
            return $stmt->execute([$email, $medal]);
        }
    }

    /**
     * Get Cert Qualify
     * @param string $email Email
     * @return bool Get Cert Qualify
     */
    protected static function getUserCert(string $email): bool
    {
        $stmt = self::connect()->prepare("SELECT * FROM info WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result['cert_qualify'] === 1;
    }

    /**
     * Get Medal Qualify
     * @param string $email Email
     * @return bool Get Medal Qualify
     */
    protected static function getUserMedal(string $email): bool
    {
        $stmt = self::connect()->prepare("SELECT * FROM info WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result['medal'] === 1;
    }

    /**
     * Check email on system
     * @param string $email Email
     * @return bool Check email on system
     */
    protected static function checkOnSystem(string $email): bool
    {
        $stmt = self::connect()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result !== false;
    }

    /**
     * Get all user info
     * @return string All user info
     */
    protected static function getAllUserInfo(): string
    {
        $stmt = self::connect()->prepare("SELECT * FROM users");
        $stmt->execute();
        $userList = $stmt->fetchAll();
        $output = "邮箱,证书编号,证书类型,真实姓名,QQ号,单位名称,指导老师,联系电话,收货地址,纸质证书,勋章申领,快递单号\n";
        foreach ($userList as $user) {
            $info = self::getUserInfo($user['email']);
            $user = array_merge($user, $info);
            $output .= $user['email'] . ',' . $user['cert'] . ',' . $user['cert_type'] . ',' . $user['name'] . ',' . $user['qq'] . ',' . $user['affiliation'] . ',' . $user['teacher'] . ',' . $user['phone'] . ',' . $user['address'] . ',' . $user['cert_qualify'] . ',' . $user['medal'] . ',' . $user['track_id'] . "\n";
        }
        return $output;
    }

    /**
     * Query cert info
     * @param string $name Name
     * @param string $cert Cert
     * @return void
     */
    protected static function query(string $name, string $cert)
    {
        $stmt = self::connect()->prepare("SELECT * FROM info WHERE name = ?");
        $stmt->execute([$name]);
        $result = $stmt->fetch();
        if ($result) {
            $info = self::getUserInfo($result['email']);
            if ($info['cert'] !== $cert) {
                Utils::custom(404, [
                    'Content-Type' => 'application/json'
                ], ['code' => 404, 'msg' => 'Cert Not found'], true);
            }
            $cert_file = CERT_PATH . '/' . $info['cert'] . '.pdf';
            if (file_exists($cert_file)) {
                Utils::custom(200, [
                    'Content-Type' => 'application/json'
                ], [
                    "name" => $info['name'],
                    "cert" => $info['cert'],
                    "type" => $info['cert_type'],
                    "affiliation" => $info['affiliation'],
                    "teacher" => $info['teacher']
                ], false);
            } else {
                Utils::custom(404, [
                    'Content-Type' => 'application/json'
                ], ['code' => 404, 'msg' => 'Cert Not found'], true);
            }
        } else {
            Utils::custom(404, [
                'Content-Type' => 'application/json'
            ], ['code' => 404, 'msg' => 'Cert Not found'], true);
        }
    }
}
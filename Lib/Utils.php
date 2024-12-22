<?php

namespace Lib;

class Utils
{
    public static function isGET(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public static function isPOST(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * 404
     * @return void
     */
    public static function notFound()
    {
        header('HTTP/1.1 404 Not Found');
        header('Content-Type: application/json');
        $data = [
            'code' => 404,
            'msg' => 'Not Found'
        ];
        exit(json_encode($data));
    }

    /**
     * Invalid param
     * @return void
     */
    public static function param()
    {
        // Invalid param
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json');
        $data = [
            'code' => 400,
            'msg' => 'Invalid param'
        ];
        exit(json_encode($data));
    }

    public static function error()
    {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        $data = [
            'code' => 500,
            'msg' => 'Internal Server Error'
        ];
        exit(json_encode($data));
    }

    /**
     * Custom http response
     * @param string $httpStatus http status
     * @param array $header http header
     * @param array $data http body
     * @param bool $exit exit
     * @return void
     */
    public static function custom(string $httpStatus, array $header, array $data, bool $exit)
    {
        header('HTTP/1.1 ' . $httpStatus);
        foreach ($header as $key => $value) {
            header($key . ': ' . $value);
        }
        if ($exit) exit(json_encode($data));
        echo json_encode($data);
    }

    public static function getMoney(): string
    {
        switch ($_POST['certificate_type']) {
            case '单赛事勋章':
            case '单纸质证书':
                return "20";
            case '证书加勋章':
                return "30";
            default:
                return "999";
        }
    }

    public static function escapeHtml(string $text): string
    {
        $array = array(
            '&' => '&amp;',
            '<' => '&lt;',
            '>' => '&gt;',
            '"' => '&quot;',
            "'" => '&#39;'
        );
        return strtr($text, $array);
    }
}
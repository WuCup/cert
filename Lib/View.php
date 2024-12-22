<?php

namespace Lib;

class View
{
    /**
     * Show view
     * @return void
     */
    public static function showView()
    {
        if (Utils::isGET()) {
            self::checkLogin();
            $path = ($_GET['path'] !== '/') ? VIEW_PATH . $_GET['path'] . '.php' : VIEW_PATH . '/home.php';
            if (file_exists($path)) require_once $path;
            else Utils::notFound();
        } elseif (Utils::isPOST()) {
            $path = ($_GET['path'] !== '/') ? API_PATH . $_GET['path'] . '.php' : API_PATH . '/index.php';
            if (file_exists($path)) require_once $path;
            else Utils::notFound();
        } else {
            Utils::notFound();
        }
    }

    private static function checkLogin()
    {
        $path = $_GET['path'];
        if (!Account::isLogin()) {
            if ($path !== '/captcha' && $path !== '/reset' && $path !== '/login' && $path !== '/query') {
                header('Location: login');
                die();
            }
        } else {
            if ($path === '/login' || $path === '/reset') {
                header('Location: home');
                die();
            }
        }
    }
}
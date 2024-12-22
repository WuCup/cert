<?php
session_start();

$width = 200;
$height = 50;
$image = imagecreatetruecolor($width, $height);

$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$line_color = imagecolorallocate($image, 64, 64, 64);

imagefilledrectangle($image, 0, 0, $width, $height, $background_color);

$captcha_code = '';
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
for ($i = 0; $i < 6; $i++) {
    $captcha_code .= $characters[rand(0, strlen($characters) - 1)];
}

$_SESSION['captcha'] = strtolower($captcha_code);

$font_size = 45;
$font = __DIR__ . '/../arial.ttf';
imagettftext($image, $font_size, 0, 15, 45, $text_color, $font, $captcha_code);

for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
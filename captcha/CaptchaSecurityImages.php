<?php
session_start();

class CaptchaSecurityImages {
    public $font = './monofont.ttf';

    public function generateCode($characters) {
        $possible = '23456789bcdfghjkmnpqrstvwxyz';
        $code = '';
        $i = 0;
        while ($i < $characters) {
            $code .= substr($possible, random_int(0, strlen($possible)-1), 1);
            $i++;
        }
        return $code;
    }

    public function __construct($width='120', $height='40', $characters='6') {
        $code = $this->generateCode($characters);
        $font_size = $height * 0.75;
        $image = imagecreate($width, $height) or die('Cannot initialize new GD image stream');
        $background_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 20, 40, 100);
        $noise_color = imagecolorallocate($image, 100, 120, 180);
        for( $i=0; $i<($width*$height)/3; $i++ ) {
            imagefilledellipse($image, random_int(0, $width), random_int(0, $height), 1, 1, $noise_color);
        }
        for( $i=0; $i<($width*$height)/150; $i++ ) {
            imageline($image, random_int(0, $width), random_int(0, $height), random_int(0, $width), random_int(0, $height), $noise_color);
        }
        $textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
        $x = intval(($width - $textbox[4])/2);
        $y = intval(($height - $textbox[5])/2);
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code) or die('Error in imagettftext function');
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
        $_SESSION['register-captcha-bubble'] = $code;
    }
}

$width = isset($_GET['width']) ? $_GET['width'] : '120';
$height = isset($_GET['height']) ? $_GET['height'] : '40';
$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';


$captcha = new CaptchaSecurityImages($width,$height,$characters);




?>

<?php

declare(strict_types=1);

namespace App\Utils\Helper;

final class Captcha
{
    public static function generate(string $appPath): array
    {
        ob_start();
        $captcha_code = '';
        $captcha_image_height = 80;
        $captcha_image_width = 200;
        $total_characters_on_image = 5;

        $possible_captcha_letters = 'bcdfghjkmnpqrstvwxyz23456789';
        $fonts = [
            'true-crimes.ttf',
            'oldies-cartoon.ttf',
            'coolvetica-rg.ttf',
        ];
        shuffle($fonts);
        $captcha_font = $appPath . '/assets/fonts/' . $fonts[0];

        $count = 0;
        while ($count < $total_characters_on_image) {
            $captcha_code .= substr(
                $possible_captcha_letters,
                random_int(0, strlen($possible_captcha_letters) - 1),
                1
            );
            ++$count;
        }

        $captcha_font_size = $captcha_image_height * 0.45;
        $captcha_image = @imagecreate(
            $captcha_image_width,
            $captcha_image_height
        );

        imagecolorallocate(
            $captcha_image,
            255,
            255,
            255
        );

        $captcha_text_color = imagecolorallocate(
            $captcha_image,
            0,
            0,
            0
        );
        $text_box = imagettfbbox(
            $captcha_font_size,
            0,
            $captcha_font,
            $captcha_code
        );
        $x = ($captcha_image_width - $text_box[4]) / 2;
        $y = ($captcha_image_height - $text_box[5]) / 2;
        imagettftext(
            $captcha_image,
            $captcha_font_size,
            0,
            (int) $x,
            (int) $y,
            $captcha_text_color,
            $captcha_font,
            $captcha_code
        );

        imagepng($captcha_image);
        $bin = ob_get_clean();
        $b64 = base64_encode($bin);

        if (ob_get_length() > 0) {
            ob_end_flush();
        }

        return [
            'captcha' => $b64,
            'token' => self::encodeCode($captcha_code),
        ];
    }

    public static function encodeCode(string $code): string
    {
        return md5('c' . strtoupper($code)) . md5(date('Y-m-d'));
    }

    public static function codeIsValid(string $code, string $token): bool
    {
        return self::encodeCode($code) === $token;
    }
}

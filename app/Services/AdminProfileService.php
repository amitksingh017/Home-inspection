<?php


namespace App\Services;


class AdminProfileService
{
    public static function getPuthAvatar(string $avatar): string
    {
        $image = $avatar;
        $image = str_replace('data:image/png;base64', '', $image);
        $image = str_replace(' ', '+', $image);

        return $image;
    }
}

<?php

namespace App\Services;


use App\Models\Inspector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileService
{
    public static function editInspectorProfile(array $data, Inspector $profile, $avatarPath)
    {
        $profile->fill($data);

        if ($avatarPath) {
            $profile->avatar = $avatarPath;
        }

        $profile->save();

        return $profile;
    }
}
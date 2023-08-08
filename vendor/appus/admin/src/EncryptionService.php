<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 19.11.2019
 */

namespace Appus\Admin;

class EncryptionService
{

    /**
     * @param string $value
     * @return string
     */
    public static function encrypt(string $value): string
    {
        return encrypt($value);
    }

    /**
     * @param string $value
     * @return string
     */
    public static function decrypt(string $value): string
    {
        return decrypt($value);
    }

}

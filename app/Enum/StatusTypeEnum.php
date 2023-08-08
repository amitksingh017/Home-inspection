<?php


namespace App\Enum;


class StatusTypeEnum
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public static function getStringTypeStatus(bool $status):string
    {
        if($status === false){
            return self::INACTIVE;
        }
        return self::ACTIVE;;
    }
}
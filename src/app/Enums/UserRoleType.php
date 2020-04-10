<?php


namespace App\Enums;
use MyCLabs\Enum\Enum;

class UserRoleType extends Enum
{
    private const ADMIN   = array(1 => '管理者');
    private const GENERAL = array(2 => '一般ユーザー');
}

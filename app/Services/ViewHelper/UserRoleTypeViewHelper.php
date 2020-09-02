<?php

namespace App\Services\ViewHelper;

use App\Enums\UserRoleType;
use App\Http\Traits\ArrayConvertion;

class UserRoleTypeViewHelper
{
    use ArrayConvertion;

    /**
     * プルダウン生成用
     *
     * @return $roles array(key, value)
     */
    public function getSelectAll()
    {
        $roles = array();
        $roleTypes = UserRoleType::values();
        $roles = $this->enumToArray($roleTypes);
        return $roles;
    }
}

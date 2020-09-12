<?php

namespace App\Services\ViewHelper;

use App\Models\Status;

class StatusTypeViewHelper
{
    /**
     * プルダウン生成用
     *
     * @return $roles array(key, value)
     */
    public function getSelectAll()
    {
        $statuses = Status::all();
        $items = [];
        foreach ($statuses as $status) {
            array_push($items, [
                'key'   => $status->id,
                'value' => $status->name,
            ]);
        }
        return $items;
    }
}

<?php

namespace App\Services\ViewHelper;

use App\Models\Category;

class CategoryTypeViewHelper
{
    /**
     * プルダウン生成用
     *
     * @return $roles array(key, value)
     */
    public function getSelectAll()
    {
        $categories = Category::all();
        $items = [];
        foreach ($categories as $category) {
            array_push($items, [
                'key'   => $category->id,
                'value' => $category->name,
            ]);
        }
        return $items;
    }
}

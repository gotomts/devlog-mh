<?php

namespace App\Logic;

use App\Models\Category;

class CategoryLogic
{

    /**
     * idをキーにカテゴリー情報を取得
     *
     * @param $id カテゴリーID
     * @return |null|Category カテゴリー情報
     */
    public static function getCategoryById($id)
    {
        $result = null;
        $isId = isset($id) ? true : false;
        if ($isId) {
            $result = Category::find($id);
        }
        return $result;
    }

    /**
     * カテゴリー全件取得
     *
     * @param  int $delete_flg
     * @return Category[]
     */
    public static function getCategories($delete_flg)
    {
        $category = Category::select(
                'categories.id',
                'categories.category_name',
                'categories.user_id',
                'categories.delete_flg',
                'categories.updated_at',
                'users.name'
            )
            ->leftjoin('users', function($join) {
                $join->on('users.id', '=', 'categories.user_id');
            })
            ->where('categories.delete_flg', '=', $delete_flg)
            ->orderBy('categories.updated_at', 'desc')
            ->paginate(config('const.Paginate.NUM'));
        return $category;
    }

    /**
     * カテゴリー登録処理
     *
     * @param $inputs
     * @return bool
     */
    public static function insert($inputs)
    {
        $isCategoryName = isset($inputs['category_name']) ? true : false;
        if ($isCategoryName) {
            $category = new Category;
            $category->category_name = $inputs['category_name'];
            $category->user_id = \Auth::id();
            return $category->save();
        }
        return false;
    }

    /**
     * カテゴリー 更新処理
     *
     * @param $inputs
     * @return bool
     */
    public static function update($inputs)
    {
        $id = isset($inputs['id']) ? $inputs['id'] : false;
        $categoryName = isset($inputs['category_name']) ? $inputs['category_name'] : false;
        if ($id && $categoryName) {
            $category = Category::find($id);
            $category->category_name = $categoryName;
            $category->user_id = \Auth::id();
            return $category->save();
        }
        return false;
    }
}

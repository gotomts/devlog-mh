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
     * カテゴリー全件取得(削除以外)
     *
     * @return Category[]
     */
    public static function getCategories()
    {
        $category = Category::select(
            'categories.id',
            'categories.name',
            'categories.updated_by',
            'categories.updated_at',
            'users.name as user_name'
        )->leftjoin('users', function ($join) {
            $join->on('users.id', '=', 'categories.updated_by');
        })->orderBy('categories.updated_at', 'desc')
        ->paginate(config('pagination.items'));
        return $category;
    }

    /**
     * カテゴリー全件取得(削除済み)
     *
     * @return Category[]
     */
    public static function getDeletedCategories()
    {
        $category = Category::onlyTrashed()->select(
            'categories.id',
            'categories.name',
            'categories.deleted_by',
            'categories.deleted_at',
            'users.name as user_name'
        )->leftjoin('users', function ($join) {
            $join->on('users.id', '=', 'categories.deleted_by');
        })->orderBy('categories.deleted_at', 'desc')
        ->paginate(config('pagination.items'));
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
        $isCategoryName = isset($inputs['name']) ? true : false;
        if ($isCategoryName) {
            $category = new Category;
            $category->name = $inputs['name'];
            $category->created_by = \Auth::user()->id;
            $category->updated_by = \Auth::user()->id;
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
    public static function update($id, $inputs)
    {
        $id = isset($id) ? $id : false;
        $categoryName = isset($inputs['name']) ? $inputs['name'] : false;
        if ($id && $categoryName) {
            $category = Category::find($id);
            $category->name = $categoryName;
            $category->updated_by = \Auth::user()->id;
            return $category->save();
        }
        return false;
    }
}

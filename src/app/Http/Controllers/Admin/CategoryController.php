<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\WebBaseController;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use App\Services\RequestErrorService;
use Illuminate\Http\Request;

/**
 * 管理側カテゴリーコントローラ
 *
 * @author mi-goto
 */
class CategoryController extends WebBaseController
{
    /** 一覧 */
    private const LIST = 'admin/category';

    /**
     * カテゴリ一覧
     *
     * return View
     */
    public function showList()
    {
        $category = new Category;
        $categories = $category->getAll();
        return \View::make('admin.category.list')
            ->with('categories', $categories);
    }

    /**
     * カテゴリー詳細 新規作成
     *
     * return View
     */
    public function showCreate()
    {
        RequestErrorService::validateInsertError();
        return \View::make('admin.category.create');
    }

    /**
     * カテゴリー詳細 登録処理
     *
     * @param CategoryRequest $request
     * return void
     */
    public function exeCreate(CategoryRequest $request)
    {
        if (Category::insert($request)) {
            flash(config('messages.common.success'))->success();
        } else {
            flash(config('messages.exception.insert'))->error();
            return redirect(self::LIST);
        }
        return redirect(self::LIST);
    }

    /**
     * カテゴリー詳細 編集
     *
     * @param Request $request
     * return View
     */
    public function showEdit($id=null)
    {
        $category = Category::getById($id);
        // カテゴリーが見つからない場合
        if (is_null($category)) {
            flash(config('messages.common.noitem'))->error();
            return back();
        }
        RequestErrorService::validateUpdateError();
        return \View::make('admin.category.edit')
            ->with('category', $category);
    }

    /**
     * カテゴリー詳細 更新
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function exeEdit($id=null, CategoryRequest $request)
    {
        // 更新処理
        if (Category::updateById($id, $request)) {
            flash(config('messages.common.success'))->success();
        } else {
            flash(config('messages.exception.update'))->error();
            return redirect(self::LIST);
        }
        return redirect(self::LIST);
    }
}

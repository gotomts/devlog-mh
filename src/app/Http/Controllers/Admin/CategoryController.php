<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\WebBaseController;
use App\Http\Requests\CategoryRequest;
use App\Logic\CategoryLogic;
use App\Services\RequestErrorService;
use Illuminate\Http\Request;

class CategoryController extends WebBaseController
{
    /**
     * カテゴリ一覧
     *
     * return View
     */
    public function showList()
    {
        $categories = CategoryLogic::getCategories();
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
        $inputs['name'] = $request->name;
        \DB::beginTransaction();
        try {
            // ログイン確認
            if (\Auth::check()) {
                CategoryLogic::insert($inputs);
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            flash(config('messages.exception.insert'))->error();
            return redirect('admin/category');
        }
        \DB::commit();
        flash(config('messages.common.success'))->success();
        return redirect('admin/category');
    }

    /**
     * カテゴリー詳細 編集
     *
     * @param Request $request
     * return View
     */
    public function showEdit($id=null)
    {
        $category = CategoryLogic::getCategoryById($id);
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
    public function exeEdit(CategoryRequest $request, $id=null)
    {
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            // アップデート確認
            if (!CategoryLogic::update($id, $inputs)) {
                throw new \Throwable;
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            \Log::warning($th);
            flash(config('messages.exception.update'))->error();
            return redirect('admin/category');
        }
        \DB::commit();
        flash(config('messages.common.success'))->success();
        return redirect('admin/category');
    }
}

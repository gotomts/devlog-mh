<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\WebBaseController;
use App\Http\Request\CategoryRequest;
use App\Logic\CategoryLogic;
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
        $categories = CategoryLogic::getCategories(config('const.DELETE_FLG.none'));
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
        $inputs['category_name'] = $request->category_name;
        \DB::beginTransaction();
        try {
            // ログイン確認
            if (\Auth::check()) {
                CategoryLogic::insert($inputs);
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            return redirect('admin/category')
                ->with('success', config('messages.error.insert'));
        }
        \DB::commit();
        return redirect('admin/category')
            ->with('success', config('messages.success'));
    }

    /**
     * カテゴリー詳細 編集
     *
     * @param Request $request
     * return View
     */
    public function showEdit(Request $request)
    {
        $inputs['id'] = $request->id;
        $category = CategoryLogic::getCategoryById($inputs['id']);
        // セッション切れ
        if (!\Auth::check()) {
            return redirect('login')
                ->with('error', 'messages.error.session');
        }
        // カテゴリーが見つからない場合
        if (is_null($category)) {
            return back()->with('error', config('messages.nodata'));
        }
        return \View::make('admin.category.edit')
            ->with('category', $category);
    }

    /**
     * カテゴリー詳細 更新
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function exeEdit(CategoryRequest $request)
    {
        $inputs['id'] = $request->id;
        $inputs['category_name'] = $request->category_name;
        // セッション切れ
        if (!\Auth::check()) {
            return redirect('login')
                ->with('error', 'messages.session.error');
        }
        \DB::beginTransaction();
        try {
            $isUpdate = CategoryLogic::update($inputs);
            // アップデート確認
            if (!$isUpdate) {
                \DB::rollback();
                return redirect('admin/category')
                    ->with('error', 'messages.error.update');
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            return redirect('admin/category')
                ->with('error', 'messages.error.update');
        }
        \DB::commit();
        return redirect('admin/category')
            ->with('success', config('messages.success'));
    }
}

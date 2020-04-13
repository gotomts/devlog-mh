<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\WebBaseController;
use App\Http\Requests\CategoryRequest;
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
            return redirect('admin/category')
                ->with('success', \MsgHelper::get('MSG_ERR_INSERT'));
        }
        \DB::commit();
        return redirect('admin/category')
            ->with('success', \MsgHelper::get('MSG_SUCCESS'));
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
            return back()->with('error', \MsgHelper::get('MSG_NODATA'));
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
            return redirect('admin/category')
                ->with('error', \MsgHelper::get('MSG_ERR_UPDATE'));
        }
        \DB::commit();
        return redirect('admin/category')
            ->with('success', \MsgHelper::get('MSG_SUCCESS'));
    }
}

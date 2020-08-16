<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class AuthorObserver
{
    public function creating(Model $model)
    {
        if (\Auth::check()) {
            $model->created_by = \Auth::user()->id;
        }
    }
    public function updating(Model $model)
    {
        if (\Auth::check()) {
            $model->updated_by = \Auth::user()->id;
        }
    }
    public function saving(Model $model)
    {
        if (\Auth::check()) {
            $model->updated_by = \Auth::user()->id;
        }
    }
    public function deleting(Model $model)
    {
        if (\Auth::check()) {
            $model->deleted_by = \Auth::user()->id;
        }
    }
}

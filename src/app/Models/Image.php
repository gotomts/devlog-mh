<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $table = 'images';

    protected $fillable = [
        'name',
        'url',
        'title',
        'alt',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];
}

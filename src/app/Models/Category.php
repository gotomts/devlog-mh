<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $guarded = array('id');

    public $timestamps = true;

    protected $fillable = [
        'category_name',
        'user_id',
        'delete_flg',
    ];

    protected $dates = [
        'updated_at',
    ];

    /**
     * @return mixed
     */
    public function update_at()
    {
        return $this->updated_at->format('Y/m/d h:m');
    }
}

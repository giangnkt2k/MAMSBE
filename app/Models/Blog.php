<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-09
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'blogs';

    protected $fillable = ['name','slug', 'parent_id', 'type', 'sub_type', 'content', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

}

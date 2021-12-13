<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-02
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'city';

    protected $fillable = ['name'];

    protected $casts = [
        'data' => 'array'
    ];

}

<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-11
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dashboard extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'dashboards';

    protected $fillable = [];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

}

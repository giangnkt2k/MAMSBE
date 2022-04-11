<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-09
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomUtilities extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'room_utilitiess';

    protected $fillable = [];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

}

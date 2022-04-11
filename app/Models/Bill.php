<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-08
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'bills';

    protected $fillable = [
        'room_id',
        'user_id',
        'date',
        'invoice_component',
        'status_bill',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

}

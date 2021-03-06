<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-04
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Electric extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'electrics';

    protected $fillable = [
        'id',
        'room_id',
        'date',
        'old_number',
        'new_number',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

    public function room()
    {
        return $this->belongsTo(room::class, 'room_id');
    }
}

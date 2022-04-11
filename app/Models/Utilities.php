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
use App\Models\Room;


class Utilities extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = 'utilitiess';

    protected $fillable = [
        'id',
        'label',
        'price'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

    public function room()
    {
        return $this->belongsToMany(room::class);
    }


}

<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-02-17
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Building;

class Room extends Model
{
    use HasFactory;


    protected $table = 'rooms';

    protected $fillable = [
        'id',
        'name',
        'building_id',
        'floor_id',
        'number_of_people',
        'price',
        'acreage_m2',
        'deposit',
        'date_empty',
        'status'
    ];


    protected $casts = [
        'data' => 'array'
    ];

    public function building()
    {
        return $this->belongsTo(building::class, 'building_id');
    }

}
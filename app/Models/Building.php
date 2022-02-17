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
use App\Models\Room;

class Building extends Model
{
    use HasFactory;

    protected $table = 'buildings';

    protected $fillable = [
        'id',
        'name',
        'address',
        'type_building',
        'rental_form',
        'city',
        'district',
        'commune',
        'e_money_1kwh',
        'w_money_1block',
        'date_record_ew',
        'date_charge'
    ];


    protected $casts = [
        'data' => 'array'
    ];

    public function room()
    {
        return $this->hasMany(Room::class, 'building_id');
    }

}

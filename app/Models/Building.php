<?php

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
        'date_charge',
        'utilities',
        'rules',
        'images',
        'detail',
        'floor'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function scopeSearch($query, $term)
    {
        if($term){
            $query->where('name', 'like', "%{$term}%");
        }
    }

    public function room()
    {
        return $this->hasMany(Room::class, 'building_id');
    }

}

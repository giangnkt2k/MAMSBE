<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-03-26
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'id',
        'name',
        'phone',
        'ci_number',
        'place_of_issuance_of_ci',
        'date_of_issuance_of_ci',
        'dob',
        'email',
        'address',
        'city',
        'district',
        'commune',
        'avatar',
        'images',
        'detail'
    ];

    public function scopeSearch($query, $term)
    {
        if($term){
            $query->where('name', 'like', "%{$term}%");
        }
    }
    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

}

<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-01
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Room;

class Rental extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'rentals';

    protected $fillable = [
        'id',
        'user_id',
        'contract_id',
        'room_id',
        'content',
        'date',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

    public function scopeSearch($query, $term)
    {
        if($term){
            $query->where('user', 'like', "%{$term}%");
        }
    }

    public function user()
    {
        return $this->belongsTo(client::class, 'user_id');
    }

    public function contract()
    {
        return $this->belongsTo(contract::class, 'contract_id');
    }

    public function room()
    {
        return $this->belongsTo(room::class, 'room_id');
    }




}

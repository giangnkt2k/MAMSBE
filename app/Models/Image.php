<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-08
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'images';

    protected $fillable = ['model_id', 'model_name', 'title', 'url', 'created_by', 'updated_by'];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

}

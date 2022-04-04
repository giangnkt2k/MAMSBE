<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-04
 */

namespace App\Http\Resources;

class WaterResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

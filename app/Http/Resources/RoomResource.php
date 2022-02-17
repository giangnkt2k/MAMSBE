<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-02-17
 */

namespace App\Http\Resources;

class RoomResource extends BaseResource
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

<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-05-07
 */

namespace App\Http\Resources;

class StatusResource extends BaseResource
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

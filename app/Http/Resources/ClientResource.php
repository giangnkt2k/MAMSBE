<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-03-26
 */

namespace App\Http\Resources;

class ClientResource extends BaseResource
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

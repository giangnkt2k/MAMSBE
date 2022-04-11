<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2022-04-11
 */

namespace App\Http\Resources;

class DashboardResource extends BaseResource
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

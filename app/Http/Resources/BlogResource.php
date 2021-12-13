<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-09
 */

namespace App\Http\Resources;

class BlogResource extends BaseResource
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

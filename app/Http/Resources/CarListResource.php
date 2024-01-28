<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'merk' => $this->merk,
            'model' => $this->model,
            'no_car' => $this->no_car,
            'price' => $this->price,
            'photo' => $this->photo != null ? url('storage/car-img/' . $this->photo) : null,
            'status' => $this->status,
        ];
    }
}

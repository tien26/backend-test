<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarLoanResource extends JsonResource
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
            'car_id' => $this->car_id,
            'user_id' => $this->user_id,
            'no_loan' => $this->no_loan,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'name' => $this->name,
            'sim' => $this->sim,
            'phone' => $this->phone,
            'merk' => $this->merk,
            'model' => $this->model,
            'no_car' => $this->no_car,
            'price' => $this->price,
            'status' => $this->status,
        ];
    }
}

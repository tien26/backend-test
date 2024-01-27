<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BorrowingHistoryResource extends JsonResource
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
            'loan_id' => $this->loan_id,
            'total' => $this->total,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'car_id' => $this->car_id,
            'no_loan' => $this->no_loan,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'name' => $this->name,
            'phone' => $this->phone,
            'sim' => $this->sim,
        ];
    }
}

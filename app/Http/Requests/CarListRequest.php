<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'merk' => 'required|string',
            'model' => 'required|string',
            'no_car' => 'required|string|unique:car_lists,no_car' . $this->id,
            'price' => 'required|integer',
            // 'photo' => 'required',
            'status' => 'boolean',
        ];
    }
}

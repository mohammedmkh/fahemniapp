<?php

namespace App\Http\Requests;

use App\Price;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePriceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('price_edit');
    }

    public function rules()
    {
        return [
            'num_std' => [
                'string',
                'required',
            ],
            'hours' => [
                'string',
                'required',
            ],
            'price' => [
                'string',
                'required',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Devicetoken;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDevicetokenRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('devicetoken_create');
    }

    public function rules()
    {
        return [
            'device_type' => [
                'string',
                'nullable',
            ],
            'device_token' => [
                'string',
                'nullable',
            ],
        ];
    }
}

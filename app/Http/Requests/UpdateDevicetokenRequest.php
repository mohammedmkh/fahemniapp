<?php

namespace App\Http\Requests;

use App\Devicetoken;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDevicetokenRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('devicetoken_edit');
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

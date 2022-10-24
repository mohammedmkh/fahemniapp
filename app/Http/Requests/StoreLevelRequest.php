<?php

namespace App\Http\Requests;

use App\Level;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLevelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('level_create');
    }

    public function rules()
    {
        return [
            'name_ar' => [
                'string',
                'required',
            ],
            'name_en' => [
                'string',
                'required',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Universite;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUniversiteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('universite_create');
    }

    public function rules()
    {
        return [
            'name_en' => [
                'string',
                'required',
            ],
            'name_ar' => [
                'string',
                'required',
            ],
        ];
    }
}

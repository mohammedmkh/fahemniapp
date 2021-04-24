<?php

namespace App\Http\Requests;

use App\Setting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('setting_create');
    }

    public function rules()
    {
        return [
            'text_policy' => [
                'string',
                'nullable',
            ],
            'tex_policy_ar' => [
                'string',
                'nullable',
            ],
            'aboutus_en' => [
                'string',
                'nullable',
            ],
            'aboutus_ar' => [
                'string',
                'nullable',
            ],
            'terms_ar' => [
                'string',
                'nullable',
            ],
            'terms_en' => [
                'string',
                'nullable',
            ],
        ];
    }
}

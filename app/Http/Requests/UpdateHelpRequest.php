<?php

namespace App\Http\Requests;

use App\Help;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHelpRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('help_edit');
    }

    public function rules()
    {
        return [
            'question_ar' => [
                'string',
                'nullable',
            ],
            'question_en' => [
                'string',
                'nullable',
            ],
            'answer_en' => [
                'string',
                'nullable',
            ],
            'answer_ar' => [
                'string',
                'nullable',
            ],
        ];
    }
}

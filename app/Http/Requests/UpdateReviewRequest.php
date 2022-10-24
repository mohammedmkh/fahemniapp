<?php

namespace App\Http\Requests;

use App\Review;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateReviewRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('review_edit');
    }

    public function rules()
    {
        return [
            'type' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'review' => [
                'string',
                'nullable',
            ],
            'note' => [
                'string',
                'nullable',
            ],
        ];
    }
}

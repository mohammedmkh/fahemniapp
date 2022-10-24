<?php

namespace App\Http\Requests;

use App\Conversation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateConversationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('conversation_edit');
    }

    public function rules()
    {
        return [
            'accept' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'end_conv' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}

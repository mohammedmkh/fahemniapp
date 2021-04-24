<?php

namespace App\Http\Requests;

use App\Notification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreNotificationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('notification_create');
    }

    public function rules()
    {
        return [
            'action_type' => [
                'string',
                'nullable',
            ],
            'actionid' => [
                'string',
                'nullable',
            ],
            'action' => [
                'string',
                'nullable',
            ],
            'reed' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}

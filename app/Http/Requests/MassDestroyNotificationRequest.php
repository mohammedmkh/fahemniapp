<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Notification;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyNotificationRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('notification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:notifications,id',
]
    
}

}
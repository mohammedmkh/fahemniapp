<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Conversation;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyConversationRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('conversation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:conversations,id',
]
    
}

}
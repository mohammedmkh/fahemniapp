<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Help;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHelpRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('help_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:helps,id',
]
    
}

}
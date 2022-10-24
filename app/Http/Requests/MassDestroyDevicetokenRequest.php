<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Devicetoken;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDevicetokenRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('devicetoken_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:devicetokens,id',
]
    
}

}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Vaforite;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVaforiteRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('vaforite_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:vaforites,id',
]
    
}

}
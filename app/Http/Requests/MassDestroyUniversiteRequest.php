<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Universite;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUniversiteRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('universite_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:universites,id',
]
    
}

}
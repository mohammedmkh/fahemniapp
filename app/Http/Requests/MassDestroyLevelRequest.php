<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Level;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLevelRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('level_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:levels,id',
]
    
}

}
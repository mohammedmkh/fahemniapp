<?php

namespace App\Http\Requests;

use App\Vaforite;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVaforiteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vaforite_create');
    }

    public function rules()
    {
        return [];
    }
}

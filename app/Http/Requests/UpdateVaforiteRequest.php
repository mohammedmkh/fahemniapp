<?php

namespace App\Http\Requests;

use App\Vaforite;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVaforiteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vaforite_edit');
    }

    public function rules()
    {
        return [];
    }
}

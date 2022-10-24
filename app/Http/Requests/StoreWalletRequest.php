<?php

namespace App\Http\Requests;

use App\Wallet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWalletRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('wallet_create');
    }

    public function rules()
    {
        return [];
    }
}

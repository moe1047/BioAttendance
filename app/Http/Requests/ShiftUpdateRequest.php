<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ShiftUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.|unique:clicklizeShifts,name,'.$request->get('id')
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'name' => 'required'
        ];
    }
}

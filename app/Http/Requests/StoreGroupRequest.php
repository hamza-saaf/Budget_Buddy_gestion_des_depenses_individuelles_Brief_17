<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'currency' => 'sometimes|string|size:3',
            'description' => 'sometimes|string',
            'members' => 'sometimes|array',
            'members.*' => 'exists:users,id'
        ];
    }
}

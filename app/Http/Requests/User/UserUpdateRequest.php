<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest

{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
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
            'last_name' => 'required|nullable|string|max:255',
            'email' =>'nullable|email',
            'primary_phone' => 'nullable|numeric|min:9',
            'secondary_phone' => 'nullable|numeric|min:9',
            'gender_id' => 'required',
        ]; 
    }
}

<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,',
            'primary_phone' => 'required|numeric|min:9|unique:users,primary_phone|unique:users,secundary_phone,',
            'secundary_phone' => 'nullable|numeric|min:9|unique:users,primary_phone|unique:users,secundary_phone', 
            'gender_id' => 'required',
        ]; 
    }
}

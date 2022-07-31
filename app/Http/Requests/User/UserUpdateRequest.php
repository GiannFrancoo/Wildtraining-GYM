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
            'email' =>'required|email|unique:users,email,'.$this->profile_id,
            'primary_phone' => 'required|numeric|min:9|unique:users,secondary_phone,' .$this->profile_id,
            'secondary_phone' => 'nullable|unique:users,primary_phone|numeric|min:9' .$this->profile_id,
            'gender_id' => 'required',
        ]; 
    }
}

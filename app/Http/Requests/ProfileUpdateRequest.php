<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
          'name' => 'required|max:30',
          'email' => 'required|email|max:255',
          // 'password' => 'required|min:6',
          'password' => 'required|min:6',
          // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',

        ];
    }
}

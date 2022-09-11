<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        if($request->getPathInfo() == '/users') 
        {
            return [
                'first_name' => 'required',
                'last_name'  => 'required',
                'email'      => 'required|email|unique:users,email',
            ];
        }
        if($request->getPathInfo() == '/login') 
        {
            return [
                'email'     => 'required',
                'password'  => 'required'
            ];
        }
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EmailRequest extends FormRequest
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
        if($request->getPathInfo() == '/email') 
        {
            return [
                'email_to'        => 'required',
                'email_subject'   => 'required',
                'email_content'   => 'required',
            ];
        }
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\Phone;

class ContactRequest extends FormRequest
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
    public function rules(Request $request)
    {
        
        if (Request::isMethod('post'))
        {
            return [
                'name' => 'required|string|max:100',
                'company' => 'required|string',
                'profile_image' => 'url|required',
                'email' => 'unique:contacts|email|required',
                'birthdate' => 'required|date_format:Y-m-d|before:today',
                'phone_number' => ['required', new Phone],
                'address.address' => 'required|string|max:100',
                'address.number' => 'integer',
                'address.state' => 'string|max:100',
                'address.city' => 'string|max:100',
            ];
        }

        if (Request::isMethod('put'))
        {
            return [
                'name' => 'required_without_all|string|max:100',
                'company' => 'string',
                'profile_image' => 'url',
                'email' => 'unique:contacts|email',
                'birthdate' => 'date_format:Y-m-d|before:today',
                'phone_number' => [new Phone],
                'address.address' => 'string|max:100',
                'address.number' => 'integer',
                'address.state' => 'string|max:100',
                'address.city' => 'string|max:100',
            ];
        }

    }

    public function withValidator($validator)
    {
        if($validator->fails()) throw new HttpResponseException(response()->json($validator->errors()->all()), 422);
    }
}

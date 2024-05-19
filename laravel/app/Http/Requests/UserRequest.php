<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return true if authorization will be handled by the login
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $is_required = $this->method() == 'POST' ? 'required' : '';
        $rules = [
            'firstname' => [$is_required],
            'lastname' => [$is_required],
            'address' => [$is_required],
            'postcode' => [$is_required, 'numeric'],
            'contact_phone_number' => [$is_required, 'regex:/^\+\d{1,3}\d{7,15}$/'],
            'email' => [$is_required, 'email'],
            'username' => [$is_required, 'min:8'],
            'password' => [$is_required, 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,16}$/'],
        ];

        if ($this->method('PUT') || $this->method('PATCH')) {
            $user_id = $this->route('user'); // Assuming 'user' is the key for the route parameter
            $rules['email'][] = Rule::unique('users', 'email')->ignore($this->user);
            $rules['username'][] = Rule::unique('users', 'username')->ignore($this->user);
        } else {
            // It's a create operation
            $rules['email'][] = Rule::unique('users', 'email');
            $rules['username'][] = Rule::unique('users', 'username');
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (@$!%*#?&).',
            'contact_phone_number.regex' => 'The contact phone number format is invalid. It must start with a "+" followed by 1 to 3 digits for the country code and then 7 to 15 digits for the phone number.',
        ];
    }
}

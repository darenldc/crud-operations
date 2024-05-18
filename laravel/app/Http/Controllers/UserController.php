<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return 'hello';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'firstname' => ['required', 'alpha'],
                'lastname' => ['required', 'alpha'],
                'address' => ['required', 'alpha'],
                'postcode' => ['required', 'numeric'],
                'contact_phone_number' => ['required', 'regex:/^\+\d{1,3}\d{7,15}$/'],
                'email' => ['required', 'email', 'unique:users,email'],
                'username' => ['required', 'unique:users,username', 'min:8'],
                'password' => ['required', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,16}$/'],
            ],
            [
                'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character (@$!%*#?&).',
                'contact_phone_number.regex' => 'The contact phone number format is invalid. It must start with a "+" followed by 1 to 3 digits for the country code and then 7 to 15 digits for the phone number.',
            ]
        );

        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'contact_phone_number' => $request->contact_phone_number,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

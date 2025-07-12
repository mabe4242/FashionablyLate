<?php

namespace App\Actions\Fortify;

use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        $request = new RegisterFormRequest();
        $rules = $request->rules();
        $messages = $request->messages();
        $attributes = $request->attributes();

        Validator::make($input, $rules, $messages, $attributes)->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
